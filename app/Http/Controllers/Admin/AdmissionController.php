<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with(['computerAdmission', 'saraswatiPujaFees'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        return view('admin.admission.index', compact('admissions'));
    }

    public function create()
    {
        return view('admin.admission.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_no' => 'nullable|unique:admissions,admission_no',
            'admission_date' => 'required|date',
            'name' => 'required|string|max:255',
            'class' => 'required|string',
            'section' => 'nullable|string',
            'rollno' => 'nullable|string',
            'stream' => 'nullable|string',
            'guardian_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
        ]);

        // Generate admission number if not provided
        if (empty($validated['admission_no'])) {
            $lastAdmission = Admission::latest('id')->first();
            $nextId = $lastAdmission ? $lastAdmission->id + 1 : 1;
            $validated['admission_no'] = 'ADM' . date('Y') . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        }

        Admission::create($validated);

        return redirect()->route('admin.admission.index')
                         ->with('success', 'Admission added successfully!');
    }

    public function edit($id)
    {
        $admission = Admission::findOrFail($id);
        return view('admin.admission.edit', compact('admission'));
    }

    public function update(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);

        $validated = $request->validate([
            'admission_no' => 'required|unique:admissions,admission_no,' . $id,
            'admission_date' => 'required|date',
            'name' => 'required|string|max:255',
            'class' => 'required|string',
            'section' => 'nullable|string',
            'rollno' => 'nullable|string',
            'stream' => 'nullable|string',
            'guardian_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
        ]);

        $admission->update($validated);

        return redirect()->route('admin.admission.index')
                         ->with('success', 'Admission updated successfully!');
    }

    public function destroy($id)
    {
        $admission = Admission::findOrFail($id);
        $admission->delete();

        return redirect()->route('admin.admission.index')
                         ->with('success', 'Admission deleted successfully!');
    }

    public function makePayment($id)
    {
        $admission = Admission::findOrFail($id);
        return view('admin.admission.payment', compact('admission'));
    }

    public function processPayment(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);
        
        // Validate the fee inputs
        $validated = $request->validate([
            'development_fees' => 'nullable|numeric|min:0',
            'registration_fees' => 'nullable|numeric|min:0',
            'enrollment_fees' => 'nullable|numeric|min:0',
            'lab_one_fees' => 'nullable|numeric|min:0',
            'lab_two_fees' => 'nullable|numeric|min:0',
            'lab_three_fees' => 'nullable|numeric|min:0',
            'lab_four_fees' => 'nullable|numeric|min:0',
            'miscellaneous_fees' => 'nullable|numeric|min:0',
            'donation' => 'nullable|numeric|min:0',
            'concession' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'amount_in_words' => 'required|string',
            'payment_mode' => 'required|string',
            'transaction_id' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
        
        // Store payment details in session for receipt generation
        session([
            'payment_data' => array_merge($validated, [
                'admission_id' => $id,
                'receipt_no' => 'RCP' . date('Y') . str_pad($id, 5, '0', STR_PAD_LEFT),
                'payment_date' => date('Y-m-d'),
            ])
        ]);
        
        // Update admission payment status
        $admission->update(['payment_status' => 'paid']);
        
        // Redirect to receipt page
        return redirect()->route('admin.admission.receipt', $id);
    }

    public function receipt($id)
    {
        $admission = Admission::findOrFail($id);
        
        // Get payment data from session or create empty object
        $paymentData = session('payment_data', []);
        $payment = (object) $paymentData;
        
        return view('admin.admission.receipt', compact('admission', 'payment'));
    }

    public function editReceipt($id)
    {
        $admission = Admission::findOrFail($id);
        return view('admin.admission.edit-receipt', compact('admission'));
    }

    public function updateReceipt(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);
        
        // Validate the fee inputs
        $validated = $request->validate([
            'development_fees' => 'nullable|numeric|min:0',
            'registration_fees' => 'nullable|numeric|min:0',
            'enrollment_fees' => 'nullable|numeric|min:0',
            'lab_one_fees' => 'nullable|numeric|min:0',
            'lab_two_fees' => 'nullable|numeric|min:0',
            'lab_three_fees' => 'nullable|numeric|min:0',
            'lab_four_fees' => 'nullable|numeric|min:0',
            'miscellaneous_fees' => 'nullable|numeric|min:0',
            'donation' => 'nullable|numeric|min:0',
            'concession' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'amount_in_words' => 'required|string',
            'payment_mode' => 'required|string',
            'transaction_id' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
        
        // Store payment details in session for receipt generation
        session([
            'payment_data' => array_merge($validated, [
                'admission_id' => $id,
                'receipt_no' => 'RCP' . date('Y') . str_pad($id, 5, '0', STR_PAD_LEFT),
                'payment_date' => date('Y-m-d'),
            ])
        ]);
        
        // Update admission payment status
        $admission->update(['payment_status' => 'paid']);
        
        // Redirect to receipt page
        return redirect()->route('admin.admission.receipt', $id)
                         ->with('success', 'Receipt updated successfully!');
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'xls');
        $rows = Admission::orderBy('created_at', 'desc')->get();

        if (in_array($format, ['csv', 'xls'], true)) {
            $filename = 'admissions.' . $format;
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($rows) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, [
                    'Sl.No.', 'Name', 'Class', 'Stream', 'Guardian Name', 'Mobile Number', 'Admission No', 'Admission Date'
                ]);
                foreach ($rows as $index => $row) {
                    fputcsv($handle, [
                        $index + 1,
                        strtoupper($row->name),
                        $row->class,
                        $row->stream,
                        $row->guardian_name,
                        $row->mobile_number,
                        $row->admission_no,
                        optional($row->admission_date)->format('Y-m-d'),
                    ]);
                }
                fclose($handle);
            };

            return response()->streamDownload($callback, $filename, $headers);
        }

        if ($format === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.admission.export_pdf', [
                'rows' => $rows,
            ])->setPaper('a4', 'portrait');
            return $pdf->download('admissions.pdf');
        }

        return redirect()->back()->with('error', 'Unsupported export format');
    }
}
