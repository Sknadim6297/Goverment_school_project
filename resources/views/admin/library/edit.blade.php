@extends('admin.layouts.app')

@section('title', 'Edit Library Record')

@section('breadcrumb')
    <li class="breadcrumb-item">Library Management</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.library.index') }}">Manage Library</a></li>
    <li class="breadcrumb-item">Edit Record</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Edit Library Details</h3>
                </div>

                <form class="form-horizontal" action="{{ route('admin.library.update', $library->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="box-body">
                        <!-- Success/Error Messages -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible" style="margin-bottom: 20px;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #721c24; opacity: 0.8;">×</button>
                                <i class="fa fa-exclamation-circle"></i>
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Student Unique ID -->
                        <div class="form-group">
                            <label for="selUser" class="col-sm-2 control-label">Student Unique Id*</label>
                            <div class="col-sm-4">
                                <select id="selUser" name="student_id" class="form-control" style="width: 100%;">
                                    <option value="">-- Search Student Name --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" 
                                                data-name="{{ $student->name }}" 
                                                data-admission="{{ $student->admission_no }}" 
                                                data-class="{{ $student->present_class }}"
                                                {{ old('student_id', $library->student_id) == $student->id ? 'selected' : '' }}>
                                            {{ $student->admission_no }} ({{ $student->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Student Name -->
                        <div class="form-group">
                            <label for="full_name" class="col-sm-2 control-label">Student Name*</label>
                            <div class="col-sm-4">
                                <input type="text" id="full_name" name="student_name" 
                                       value="{{ old('student_name', $library->student_name) }}" 
                                       class="form-control" readonly required>
                            </div>
                        </div>

                        <!-- Registration No -->
                        <div class="form-group">
                            <label for="registration_no" class="col-sm-2 control-label">Registration No*</label>
                            <div class="col-sm-4">
                                <input type="text" id="registration_no" name="registration_no" 
                                       value="{{ old('registration_no', $library->registration_no) }}" 
                                       class="form-control" readonly required>
                            </div>
                        </div>

                        <!-- Class -->
                        <div class="form-group">
                            <label for="class" class="col-sm-2 control-label">Class*</label>
                            <div class="col-sm-4">
                                <input type="text" name="class_name" id="class" 
                                       value="{{ old('class_name', $library->class_name) }}" 
                                       class="form-control" readonly required>
                            </div>
                        </div>

                        <!-- Book Name -->
                        <div class="form-group">
                            <label for="book_name" class="col-sm-2 control-label">Book Name*</label>
                            <div class="col-sm-4">
                                <input type="text" name="book_name" id="book_name" 
                                       value="{{ old('book_name', $library->book_name) }}" 
                                       class="form-control" placeholder="Book Name" required>
                            </div>
                        </div>

                        <!-- Issue Date -->
                        <div class="form-group">
                            <label for="issue_date" class="col-sm-2 control-label">Issue Date*</label>
                            <div class="col-sm-4">
                                <input type="date" name="issue_date" id="issue_date" 
                                       value="{{ old('issue_date', $library->issue_date ? $library->issue_date->format('Y-m-d') : '') }}" 
                                       class="form-control" required>
                            </div>
                        </div>

                        <!-- Return Date -->
                        <div class="form-group">
                            <label for="return_date" class="col-sm-2 control-label">Return Date*</label>
                            <div class="col-sm-4">
                                <input type="date" name="return_date" id="return_date" 
                                       value="{{ old('return_date', $library->return_date ? $library->return_date->format('Y-m-d') : '') }}" 
                                       class="form-control" required>
                            </div>
                        </div>

                        <!-- Returning On (Actual Return Date) -->
                        <div class="form-group">
                            <label for="returning_on" class="col-sm-2 control-label">Returning On</label>
                            <div class="col-sm-4">
                                <input type="date" name="returning_on" id="returning_on" 
                                       value="{{ old('returning_on', $library->returning_on ? $library->returning_on->format('Y-m-d') : '') }}" 
                                       class="form-control">
                                <small class="form-text text-muted">Leave empty if book is not returned yet</small>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status*</label>
                            <div class="col-sm-4">
                                <select name="status" id="status" class="form-control" required>
                                    <option value="issued" {{ old('status', $library->status) == 'issued' ? 'selected' : '' }}>Issued</option>
                                    <option value="returned" {{ old('status', $library->status) == 'returned' ? 'selected' : '' }}>Returned</option>
                                </select>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="form-group">
                            <label for="remarks" class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-4">
                                <textarea name="remarks" id="remarks" class="form-control" rows="3" 
                                          placeholder="Any additional notes">{{ old('remarks', $library->remarks) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="box-footer">
                        <a href="{{ route('admin.library.index') }}" class="btn btn-default">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-info pull-right">
                            <i class="fa fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#selUser').select2({
        placeholder: '-- Search Student Name --',
        allowClear: true,
        width: '100%'
    });

    // Function to populate fields from selected student
    function populateStudentFields() {
        var selectedOption = $('#selUser').find('option:selected');
        var studentName = selectedOption.data('name');
        var admissionNo = selectedOption.data('admission');
        var studentId = selectedOption.val();
        var studentClass = selectedOption.data('class');

        if (studentName) {
            $('#full_name').val(studentName);
            // Use admission number if available, otherwise use student ID
            $('#registration_no').val(admissionNo || studentId);
            $('#class').val(studentClass);
        }
    }

    // When student is selected, populate other fields
    $('#selUser').on('change', function() {
        populateStudentFields();
    });

    // Auto-set returning_on when status is changed to returned
    $('#status').on('change', function() {
        if ($(this).val() == 'returned' && !$('#returning_on').val()) {
            var today = new Date().toISOString().split('T')[0];
            $('#returning_on').val(today);
        }
    });

    // Trigger change on page load to populate fields
    $('#selUser').trigger('change');

    // Form submission validation
    $('form').on('submit', function(e) {
        var registrationNo = $('#registration_no').val();
        
        if (!registrationNo || registrationNo.trim() === '') {
            e.preventDefault();
            alert('Please select a student from the list');
            $('#selUser').focus();
            return false;
        }
    });
});
</script>
@endsection
