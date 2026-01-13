<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Payment;
use Illuminate\Http\Request;

class CollectFeesController extends Controller
{
    /**
     * Display a listing of all students for fee collection
     */
    public function index()
    {
        $students = Student::select('id', 'name', 'admission_no', 'present_class', 'student_profile')->paginate(10);
        return view('admin.collect-fees.index', compact('students'));
    }

    /**
     * Search students by admission number
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'std_id' => 'required|string',
        ]);

        $student = Student::where('admission_no', $validated['std_id'])
            ->orWhere('id', $validated['std_id'])
            ->first();

        if (!$student) {
            return redirect()->route('admin.collect_fees.index')
                ->with('error', 'Student not found');
        }

        return redirect()->route('admin.collect_fees.show', $student->id);
    }

    /**
     * Show student details and collect fees
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        $payments = Payment::where('student_id', $id)->get();
        
        return view('admin.collect-fees.show', compact('student', 'payments'));
    }

    /**
     * Store the fee collection
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_mode' => 'required|string',
            'transaction_id' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $validated['payment_date'] = now();
        $validated['receipt_no'] = 'RCP-' . date('YmdHis') . '-' . $validated['student_id'];

        Payment::create($validated);

        return redirect()->route('admin.collect_fees.show', $validated['student_id'])
            ->with('success', 'Fee collected successfully!');
    }
}
