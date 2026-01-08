<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\ComputerAdmission;
use Illuminate\Http\Request;

class ComputerAdmissionController extends Controller
{
    public function index()
    {
        $computerAdmissions = ComputerAdmission::with('admission')
                                               ->orderBy('created_at', 'desc')
                                               ->paginate(10);
        return view('admin.computer-admission.index', compact('computerAdmissions'));
    }

    public function create($admission_id)
    {
        $admission = Admission::findOrFail($admission_id);
        return view('admin.computer-admission.create', compact('admission'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'enrollment_date' => 'required|date',
        ]);

        // Set defaults for nullable fields
        $validated['course_name'] = 'Computer Course';
        $validated['course_fee'] = 0;
        $validated['paid_amount'] = 0;
        $validated['payment_status'] = 'pending';

        ComputerAdmission::create($validated);

        return redirect()->route('admin.computer_admission.index')
                         ->with('success', 'Computer admission added successfully!');
    }

    public function edit($id)
    {
        $computerAdmission = ComputerAdmission::with('admission')->findOrFail($id);
        return view('admin.computer-admission.edit', compact('computerAdmission'));
    }

    public function update(Request $request, $id)
    {
        $computerAdmission = ComputerAdmission::findOrFail($id);

        $validated = $request->validate([
            'enrollment_date' => 'required|date',
            'course_name' => 'required|string|max:255',
            'course_fee' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'remarks' => 'nullable|string',
        ]);

        $computerAdmission->update($validated);

        return redirect()->route('admin.computer_admission.index')
                         ->with('success', 'Computer admission updated successfully!');
    }

    public function destroy($id)
    {
        $computerAdmission = ComputerAdmission::findOrFail($id);
        $computerAdmission->delete();

        return redirect()->route('admin.computer_admission.index')
                         ->with('success', 'Computer admission deleted successfully!');
    }

    public function reports(Request $request)
    {
        $query = ComputerAdmission::with('admission');

        // Apply date filters when provided
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('enrollment_date', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('enrollment_date', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('enrollment_date', '<=', $request->date_to);
        }

        // Clone the filtered query for download/export without pagination
        $exportQuery = clone $query;

        // Handle CSV / XLS / PDF download
        $downloadType = $request->input('download');
        if (in_array($downloadType, ['csv', 'xls'], true)) {
            $rows = $exportQuery->orderBy('enrollment_date', 'desc')->get();
            $filename = 'computer_admission_reports.' . $downloadType;

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($rows) {
                $handle = fopen('php://output', 'w');
                // Headings
                fputcsv($handle, [
                    'Sl.No.', 'Student Name', 'Admission No', 'Class', 'Course Name',
                    'Course Fee', 'Paid Amount', 'Due Amount', 'Payment Status', 'Enrollment Date'
                ]);

                foreach ($rows as $index => $row) {
                    fputcsv($handle, [
                        $index + 1,
                        strtoupper($row->admission->name),
                        $row->admission->admission_no,
                        $row->admission->class,
                        $row->course_name,
                        $row->course_fee,
                        $row->paid_amount,
                        $row->course_fee - $row->paid_amount,
                        $row->payment_status,
                        optional($row->enrollment_date)->format('Y-m-d'),
                    ]);
                }

                fclose($handle);
            };

            return response()->streamDownload($callback, $filename, $headers);
        } elseif ($downloadType === 'pdf') {
            $rows = $exportQuery->orderBy('enrollment_date', 'desc')->get();
            $totals = [
                'fee' => $rows->sum('course_fee'),
                'paid' => $rows->sum('paid_amount'),
            ];
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.computer-admission.reports_pdf', [
                'rows' => $rows,
                'totals' => $totals,
                'filters' => [
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                ],
            ])->setPaper('a4', 'portrait');
            return $pdf->download('computer_admission_reports.pdf');
        }

        $computerAdmissions = $query->orderBy('enrollment_date', 'desc')->paginate(10);
        
        return view('admin.computer-admission.reports', compact('computerAdmissions'));
    }

    public function makePayment($id)
    {
        $computerAdmission = ComputerAdmission::with('admission')->findOrFail($id);
        
        if ($computerAdmission->payment_status == 'paid') {
            return redirect()->route('admin.computer_admission.index')
                             ->with('error', 'Payment already completed for this admission!');
        }
        
        return view('admin.computer-admission.make_payment', compact('computerAdmission'));
    }

    public function processPayment(Request $request, $id)
    {
        $computerAdmission = ComputerAdmission::findOrFail($id);
        
        $validated = $request->validate([
            'computer_fees' => 'nullable|numeric|min:0',
            'book_fees' => 'nullable|numeric|min:0',
            'miscellaneous' => 'nullable|numeric|min:0',
            'payment_amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:cash,online,cheque',
            'remarks' => 'nullable|string',
        ]);

        // Calculate total from breakdown
        $computerFees = $validated['computer_fees'] ?? 0;
        $bookFees = $validated['book_fees'] ?? 0;
        $miscellaneous = $validated['miscellaneous'] ?? 0;
        $totalFees = $computerFees + $bookFees + $miscellaneous;

        // Update computer admission
        $computerAdmission->course_fee = $totalFees;
        $computerAdmission->paid_amount = $validated['payment_amount'];
        $computerAdmission->payment_status = 'paid';
        $computerAdmission->payment_date = $validated['payment_date'];
        $computerAdmission->payment_mode = $validated['payment_mode'];
        $computerAdmission->computer_fees = $computerFees;
        $computerAdmission->book_fees = $bookFees;
        $computerAdmission->miscellaneous_fees = $miscellaneous;
        
        $computerAdmission->save();

        return redirect()->route('admin.computer_admission.index')
                         ->with('success', 'Payment processed successfully!');
    }

    public function receipt($id)
    {
        $computerAdmission = ComputerAdmission::with('admission')->findOrFail($id);
        return view('admin.computer-admission.receipt', compact('computerAdmission'));
    }
}
