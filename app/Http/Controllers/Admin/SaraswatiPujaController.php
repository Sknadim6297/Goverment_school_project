<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\SaraswatiPujaFee;
use Illuminate\Http\Request;

class SaraswatiPujaController extends Controller
{
    public function index()
    {
        $saraswatiPujaFees = SaraswatiPujaFee::with('admission')
                                             ->orderBy('created_at', 'desc')
                                             ->paginate(10);
        return view('admin.saraswati-puja.index', compact('saraswatiPujaFees'));
    }

    public function create($admission_id)
    {
        $admission = Admission::findOrFail($admission_id);
        return view('admin.saraswati-puja.create', compact('admission'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'year' => 'required|integer|min:2000|max:2100',
            'fee_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:cash,online,cheque',
            'remarks' => 'nullable|string',
        ]);

        // Generate receipt number
        $lastReceipt = SaraswatiPujaFee::latest('id')->first();
        $nextId = $lastReceipt ? $lastReceipt->id + 1 : 1;
        $validated['receipt_no'] = 'SP' . $validated['year'] . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        SaraswatiPujaFee::create($validated);

        return redirect()->route('admin.saraswati_puja.index')
                         ->with('success', 'Saraswati Puja fee added successfully!');
    }

    public function edit($id)
    {
        $saraswatiPujaFee = SaraswatiPujaFee::with('admission')->findOrFail($id);
        return view('admin.saraswati-puja.edit', compact('saraswatiPujaFee'));
    }

    public function update(Request $request, $id)
    {
        $saraswatiPujaFee = SaraswatiPujaFee::findOrFail($id);

        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'fee_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:cash,online,cheque',
            'remarks' => 'nullable|string',
        ]);

        $saraswatiPujaFee->update($validated);

        return redirect()->route('admin.saraswati_puja.index')
                         ->with('success', 'Saraswati Puja fee updated successfully!');
    }

    public function destroy($id)
    {
        $saraswatiPujaFee = SaraswatiPujaFee::findOrFail($id);
        $saraswatiPujaFee->delete();

        return redirect()->route('admin.saraswati_puja.index')
                         ->with('success', 'Saraswati Puja fee deleted successfully!');
    }

    public function reports(Request $request)
    {
        $query = SaraswatiPujaFee::with('admission');

        // Filters
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('payment_date', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // Clone for export without pagination
        $exportQuery = clone $query;

        // Handle CSV / XLS / PDF export
        $downloadType = $request->input('download');
        if (in_array($downloadType, ['csv', 'xls'], true)) {
            $rows = $exportQuery->orderBy('payment_date', 'desc')->get();
            $filename = 'saraswati_puja_reports.' . $downloadType;

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($rows) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, [
                    'Sl.No.', 'Student Name', 'Admission No', 'Class', 'Year', 'Fee Amount', 'Receipt No', 'Payment Date', 'Payment Mode'
                ]);

                foreach ($rows as $index => $row) {
                    fputcsv($handle, [
                        $index + 1,
                        strtoupper($row->admission->name),
                        $row->admission->admission_no,
                        $row->admission->class,
                        $row->year,
                        $row->fee_amount,
                        $row->receipt_no,
                        optional($row->payment_date)->format('Y-m-d'),
                        $row->payment_mode,
                    ]);
                }

                fclose($handle);
            };

            return response()->streamDownload($callback, $filename, $headers);
        } elseif ($downloadType === 'pdf') {
            $rows = $exportQuery->orderBy('payment_date', 'desc')->get();
            $totalAmount = $rows->sum('fee_amount');
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.saraswati-puja.reports_pdf', [
                'rows' => $rows,
                'totalAmount' => $totalAmount,
                'filters' => [
                    'year' => $request->input('year'),
                    'date_from' => $request->input('date_from'),
                    'date_to' => $request->input('date_to'),
                ],
            ])->setPaper('a4', 'portrait');
            return $pdf->download('saraswati_puja_reports.pdf');
        }

        $saraswatiPujaFees = $query->orderBy('payment_date', 'desc')->paginate(10);
        
        return view('admin.saraswati-puja.reports', compact('saraswatiPujaFees'));
    }

    public function receipt($id)
    {
        $saraswatiPujaFee = SaraswatiPujaFee::with('admission')->findOrFail($id);
        return view('admin.saraswati-puja.receipt', compact('saraswatiPujaFee'));
    }
}
