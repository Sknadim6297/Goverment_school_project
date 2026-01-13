<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    /**
     * Display a listing of library records.
     */
    public function index()
    {
        $libraries = Library::orderBy('created_at', 'desc')->get();
        return view('admin.library.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new library record.
     */
    public function create()
    {
        $students = Student::select('id', 'name', 'admission_no', 'present_class')->get();
        return view('admin.library.create', compact('students'));
    }

    /**
     * Store a newly created library record in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'nullable|exists:students,id',
            'student_name' => 'required|string|max:255',
            'registration_no' => 'nullable|string|max:255',
            'class_name' => 'required|string|max:100',
            'book_name' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:issue_date',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Library::create($request->all());

        return redirect()->route('admin.library.index')
            ->with('success', 'Library record added successfully!');
    }

    /**
     * Show the form for editing the specified library record.
     */
    public function edit($id)
    {
        $library = Library::findOrFail($id);
        $students = Student::select('id', 'name', 'admission_no', 'present_class')->get();
        return view('admin.library.edit', compact('library', 'students'));
    }

    /**
     * Update the specified library record in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'nullable|exists:students,id',
            'student_name' => 'required|string|max:255',
            'registration_no' => 'required|string|max:255',
            'class_name' => 'required|string|max:100',
            'book_name' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:issue_date',
            'returning_on' => 'nullable|date',
            'status' => 'required|in:issued,returned',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $library = Library::findOrFail($id);
        $library->update($request->all());

        return redirect()->route('admin.library.index')
            ->with('success', 'Library record updated successfully!');
    }

    /**
     * Remove the specified library record from storage.
     */
    public function destroy($id)
    {
        $library = Library::findOrFail($id);
        $library->delete();

        return redirect()->route('admin.library.index')
            ->with('success', 'Library record deleted successfully!');
    }

    /**
     * Export library records to Excel.
     */
    public function export()
    {
        // Export functionality can be added later
        return redirect()->route('admin.library.index')
            ->with('info', 'Export functionality will be implemented soon.');
    }
}
