@extends('admin.layouts.app')

@section('title', 'Edit Computer Admission')

@section('breadcrumb')
    <li class="breadcrumb-item">Computer Admission</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.computer_admission.index') }}">Manage</a></li>
    <li class="breadcrumb-item">Edit</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Edit Computer Admission</h3>
                </div>

                <div class="box-body">
                    <!-- Student Info -->
                    <div class="student-info">
                        <h4>Student Information</h4>
                        <div class="student-grid">
                            <div><strong>Admission No:</strong> {{ $computerAdmission->admission->admission_no ?? 'N/A' }}</div>
                            <div><strong>Admission Date:</strong> {{ optional($computerAdmission->admission->created_at)->format('Y-m-d') }}</div>
                            <div><strong>Name:</strong> {{ $computerAdmission->admission->name ?? 'N/A' }}</div>
                            <div><strong>Class:</strong> {{ $computerAdmission->admission->class ?? 'N/A' }}</div>
                            <div><strong>Section:</strong> {{ $computerAdmission->admission->section ?? 'N/A' }}</div>
                            <div><strong>Roll No.:</strong> {{ $computerAdmission->admission->rollno ?? 'N/A' }}</div>
                            <div><strong>Guardian Name:</strong> {{ $computerAdmission->admission->guardian_name ?? 'N/A' }}</div>
                            <div><strong>Mobile Number:</strong> {{ $computerAdmission->admission->mobile_number ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <form class="form-horizontal" action="{{ route('admin.computer_admission.update', $computerAdmission->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="enrollment_date" class="col-sm-2 control-label required-field">Admission Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="enrollment_date" id="enrollment_date" class="form-control" required value="{{ old('enrollment_date', optional($computerAdmission->enrollment_date)->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="course_name" class="col-sm-2 control-label required-field">Course Name</label>
                            <div class="col-sm-4">
                                <input type="text" name="course_name" id="course_name" class="form-control" required value="{{ old('course_name', $computerAdmission->course_name) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="course_fee" class="col-sm-2 control-label required-field">Course Fee</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01" min="0" name="course_fee" id="course_fee" class="form-control" required value="{{ old('course_fee', $computerAdmission->course_fee) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paid_amount" class="col-sm-2 control-label">Paid Amount</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01" min="0" name="paid_amount" id="paid_amount" class="form-control" value="{{ old('paid_amount', $computerAdmission->paid_amount) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start_date" class="col-sm-2 control-label">Start Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', optional($computerAdmission->start_date)->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="end_date" class="col-sm-2 control-label">End Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', optional($computerAdmission->end_date)->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-8">
                                <textarea name="remarks" id="remarks" rows="3" class="form-control" placeholder="Add any additional notes...">{{ old('remarks', $computerAdmission->remarks) }}</textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <a href="{{ route('admin.computer_admission.index') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-info pull-right">
                                <i class="fa fa-save"></i> Update Computer Admission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Prevent horizontal scroll and normalize spacing */
    html, body { overflow-x: hidden; }

    .content-box { width: 100%; }
    .box-header { padding: 12px 16px; }
    .box-body { padding: clamp(16px, 3vw, 24px); }
    .box-footer { padding: 12px 16px; }

    .student-info {
        background: #e9ecef;
        padding: clamp(12px, 2.5vw, 20px);
        border-radius: 8px;
        margin-bottom: clamp(16px, 3vw, 24px);
    }
    .student-info h4 { margin: 0 0 12px; color: #0d3b66; font-weight: 600; }
    .student-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: clamp(10px, 2vw, 16px);
    }

    .form-horizontal .form-group { margin-bottom: clamp(12px, 2.5vw, 18px); }
    .form-horizontal .control-label { padding-top: 8px; }

    /* Ensure inputs are touch-friendly and consistent */
    .form-control {
        padding: clamp(10px, 2vw, 12px) 12px;
        border-radius: 8px;
        font-size: 14px;
    }

    .pull-right { float: right; }
    .col-md-12 { width: 100%; }

    /* Mobile layout: stack labels and inputs, remove large gaps */
    @media (max-width: 576px) {
        .student-grid { grid-template-columns: 1fr; }
        .form-horizontal .col-sm-2,
        .form-horizontal .col-sm-4,
        .form-horizontal .col-sm-6,
        .form-horizontal .col-sm-8,
        .form-horizontal .col-sm-10,
        .form-horizontal .col-sm-12 {
            width: 100%;
            float: none;
            padding-left: 0;
            padding-right: 0;
        }
        .form-horizontal .control-label {
            text-align: left;
            margin-bottom: 6px;
        }
        .box-footer .btn { width: 100%; margin-bottom: 8px; }
        .pull-right { float: none; }
    }
</style>
@endpush
