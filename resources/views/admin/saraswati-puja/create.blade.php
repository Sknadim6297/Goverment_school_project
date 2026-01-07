@extends('admin.layouts.app')

@section('title', 'Add Saraswati Puja Fee')

@section('breadcrumb')
    <li class="breadcrumb-item">Saraswati Puja Committee</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.saraswati_puja.index') }}">Manage Fee</a></li>
    <li class="breadcrumb-item">Add New</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Saraswati Puja Fee Details</h3>
                </div>

                <form class="form-horizontal" action="{{ route('admin.saraswati_puja.store') }}" method="post">
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
                                <div><strong>Guardian:</strong> {{ $admission->guardian_name }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="year" class="col-sm-2 control-label required-field">Year</label>
                            <div class="col-sm-4">
                                <select name="year" id="year" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    @for($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ old('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fee_amount" class="col-sm-2 control-label required-field">Fee Amount (₹)</label>
                            <div class="col-sm-4">
                                <input type="number" name="fee_amount" id="fee_amount" class="form-control" placeholder="Enter Fee Amount" required min="0" step="0.01" value="{{ old('fee_amount') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_date" class="col-sm-2 control-label required-field">Fee Receive Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="payment_date" id="payment_date" class="form-control" required value="{{ old('payment_date', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_mode" class="col-sm-2 control-label required-field">Payment Mode</label>
                            <div class="col-sm-4">
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="online" {{ old('payment_mode') == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-4">
                                <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter any remarks">{{ old('remarks') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="{{ route('admin.admission.index') }}" class="btn btn-danger">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-info pull-right">
                            <i class="fa fa-save"></i> Add Saraswati Puja Fee
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
