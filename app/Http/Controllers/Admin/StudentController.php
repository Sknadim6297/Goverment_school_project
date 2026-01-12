<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Admission;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index()
    {
        $students = Student::orderBy('id', 'desc')->get();
        return view('admin.students.index', compact('students'));
    }

    /**
     * Filter students by class
     */
    public function filterByClass(Request $request)
    {
        $className = $request->input('class_name');
        $students = Student::where('present_class', $className)
            ->orderBy('id', 'desc')
            ->get();
        
        return view('admin.students.index', compact('students', 'className'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create()
    {
        return view('admin.students.add');
    }

    /**
     * Store a newly created student in database
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'dob' => 'required|date',
                'gender' => 'required|string',
                'social_category' => 'required|string',
                'religion' => 'required|string',
                'mother_tongue' => 'required|string',
                'nationality' => 'required|string',
                'present_class' => 'required|string',
            ]);

            // Collect all form data except files and token
            $data = $request->except([
                '_token', 'student_profile', 'aadhar_picture', 'birth_certificate', 
                'tc_certificate', 'social_certificate'
            ]);

            // Handle file uploads
            if ($request->hasFile('student_profile')) {
                $data['student_profile'] = $request->file('student_profile')->store('students/profiles', 'public');
            }

            if ($request->hasFile('aadhar_picture')) {
                $data['aadhar_picture'] = $request->file('aadhar_picture')->store('students/documents', 'public');
            }

            if ($request->hasFile('birth_certificate')) {
                $data['birth_certificate'] = $request->file('birth_certificate')->store('students/documents', 'public');
            }

            if ($request->hasFile('tc_certificate')) {
                $data['tc_certificate'] = $request->file('tc_certificate')->store('students/documents', 'public');
            }

            if ($request->hasFile('social_certificate')) {
                $data['social_certificate'] = $request->file('social_certificate')->store('students/documents', 'public');
            }

            // Create student record
            Student::create($data);

            return redirect()->route('admin.students.index')
                ->with('success', 'Student added successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error adding student: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified student
     */
    public function view($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.view', compact('student'));
    }

    /**
     * Show student ledger
     */
    public function viewLedger($id)
    {
        $student = Student::findOrFail($id);

        // Try to locate related admission via admission_no
        $admission = null;
        $payments = collect();

        if (!empty($student->admission_no)) {
            $admission = Admission::where('admission_no', $student->admission_no)->first();
            if ($admission) {
                $payments = $admission->payments()->orderBy('payment_date', 'asc')->get();
            }
        }

        return view('admin.students.ledger', compact('student', 'admission', 'payments'));
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in database
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'present_class' => 'required|string',
            'mother_tongue' => 'nullable|string',
            'nationality' => 'nullable|string',
        ]);

        // Handle photo upload
        if ($request->hasFile('student_photo')) {
            // Delete old photo
            if ($student->student_photo) {
                Storage::disk('public')->delete($student->student_photo);
            }
            $validated['student_photo'] = $request->file('student_photo')->store('students', 'public');
        }

        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from database
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        // Delete photo if exists
        if ($student->student_photo) {
            Storage::disk('public')->delete($student->student_photo);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully!');
    }

    /**
     * Export students to Excel
     */
    public function export()
    {
        $students = Student::orderBy('id','asc')->get();

        $filename = "students_" . date('Y-m-d') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Add headers consistent with index listing
        fputcsv($output, [
            'Sl.No.',
            'Student Name',
            'Admission No',
            'Date Of Birth',
            'Birth Regn No',
            'Present Class',
            'Mother Tongue',
            'Nationality'
        ]);

        // Add data
        $count = 1;
        foreach ($students as $student) {
            fputcsv($output, [
                $count++,
                $student->name ?? '',
                $student->admission_no ?? '',
                $student->dob ? $student->dob->format('Y-m-d') : '',
                $student->birth_regn_no ?? '',
                $student->present_class ?? '',
                $student->mother_tongue ?? '',
                $student->nationality ?? ''
            ]);
        }

        fclose($output);
        exit();
    }

    /**
     * Bulk upload students
     */
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'bulk_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Handle bulk upload logic here
        // You can use Laravel Excel or similar package

        return redirect()->route('admin.students.index')
            ->with('success', 'Students uploaded successfully!');
    }
}
