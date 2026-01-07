@extends('admin.layouts.app')

@section('title', 'Add Computer Admission')

@section('breadcrumb')
    <li class="breadcrumb-item">Computer Admission</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.computer_admission.index') }}">Manage</a></li>
    <li class="breadcrumb-item">Add New</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Computer Admission Details</h3>
                </div>

                <form class="form-horizontal" action="{{ route('admin.computer_admission.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="admission_id" value="{{ $admission->id }}">
                    
                    <div class="box-body">
                        <!-- Student Info -->
                        <div style="background: #e9ecef; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                            <h4 style="margin-top: 0; color: #0d3b66;">Student Information</h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div><strong>Name:</strong> {{ $admission->name }}</div>
                                <div><strong>Admission No:</strong> {{ $admission->admission_no }}</div>
                                <div><strong>Class:</strong> {{ $admission->class }}</div>
                                <div><strong>Section:</strong> {{ $admission->section ?? 'N/A' }}</div>
                                <div><strong>Roll No.:</strong> {{ $admission->rollno ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="enrollment_date" class="col-sm-2 control-label required-field">Admission Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="enrollment_date" id="enrollment_date" class="form-control" required value="{{ old('enrollment_date', date('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="{{ route('admin.admission.index') }}" class="btn btn-danger">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-info pull-right">
                            <i class="fa fa-save"></i> Add Computer Admission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .pull-right {
        float: right;
    }
    .col-md-12 {
        width: 100%;
    }
</style>
@endpush
