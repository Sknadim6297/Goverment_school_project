@extends('admin.layouts.app')

@section('title', 'Edit Saraswati Puja Fee')

@section('breadcrumb')
    <li class="breadcrumb-item">Saraswati Puja Committee</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.saraswati_puja.index') }}">Manage Fee</a></li>
    <li class="breadcrumb-item">Edit</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Update Saraswati Puja Fee</h3>
                </div>

                <form class="form-horizontal" action="{{ route('admin.saraswati_puja.update', $saraswatiPujaFee->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="box-body">
                        <div style="background: #e9ecef; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                            <h4 style="margin-top: 0; color: #0d3b66;">Student Information</h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div><strong>Name:</strong> {{ $saraswatiPujaFee->admission->name }}</div>
                                <div><strong>Admission No:</strong> {{ $saraswatiPujaFee->admission->admission_no }}</div>
                                <div><strong>Class:</strong> {{ $saraswatiPujaFee->admission->class }}</div>
                                <div><strong>Section:</strong> {{ $saraswatiPujaFee->admission->section ?? 'N/A' }}</div>
                                <div><strong>Roll No.:</strong> {{ $saraswatiPujaFee->admission->rollno ?? 'N/A' }}</div>
                                <div><strong>Guardian:</strong> {{ $saraswatiPujaFee->admission->guardian_name }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="year" class="col-sm-2 control-label required-field">Year</label>
                            <div class="col-sm-4">
                                <select name="year" id="year" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    @for($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ old('year', $saraswatiPujaFee->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fee_amount" class="col-sm-2 control-label required-field">Fee Amount (₹)</label>
                            <div class="col-sm-4">
                                <input type="number" name="fee_amount" id="fee_amount" class="form-control" required min="0" step="0.01" value="{{ old('fee_amount', $saraswatiPujaFee->fee_amount) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_date" class="col-sm-2 control-label required-field">Fee Receive Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="payment_date" id="payment_date" class="form-control" required value="{{ old('payment_date', $saraswatiPujaFee->payment_date->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_mode" class="col-sm-2 control-label required-field">Payment Mode</label>
                            <div class="col-sm-4">
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    <option value="cash" {{ old('payment_mode', $saraswatiPujaFee->payment_mode) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="online" {{ old('payment_mode', $saraswatiPujaFee->payment_mode) == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="cheque" {{ old('payment_mode', $saraswatiPujaFee->payment_mode) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-4">
                                <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ old('remarks', $saraswatiPujaFee->remarks) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="{{ route('admin.saraswati_puja.index') }}" class="btn btn-danger">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-info pull-right">
                            <i class="fa fa-save"></i> Update Fee
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
    .pull-right { float: right; }
    .col-md-12 { width: 100%; }
</style>
@endpush
