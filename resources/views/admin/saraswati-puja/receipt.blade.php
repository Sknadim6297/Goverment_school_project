@extends('admin.layouts.app')

@section('title', 'Saraswati Puja Receipt')

@section('breadcrumb')
    <li class="breadcrumb-item">Saraswati Puja Committee</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.saraswati_puja.index') }}">Manage Fee</a></li>
    <li class="breadcrumb-item">Receipt</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="content-box" style="padding: 25px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <h3 style="margin:0;">Saraswati Puja Fee Receipt</h3>
                    <span style="font-weight:bold;">Receipt No: {{ $saraswatiPujaFee->receipt_no }}</span>
                </div>

                <div style="margin-bottom:15px;">
                    <h4 style="margin:0 0 10px 0;">Student Details</h4>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:8px;">
                        <div><strong>Name:</strong> {{ $saraswatiPujaFee->admission->name }}</div>
                        <div><strong>Admission No:</strong> {{ $saraswatiPujaFee->admission->admission_no }}</div>
                        <div><strong>Class:</strong> {{ $saraswatiPujaFee->admission->class }}</div>
                        <div><strong>Section:</strong> {{ $saraswatiPujaFee->admission->section ?? 'N/A' }}</div>
                        <div><strong>Roll No.:</strong> {{ $saraswatiPujaFee->admission->rollno ?? 'N/A' }}</div>
                        <div><strong>Guardian:</strong> {{ $saraswatiPujaFee->admission->guardian_name }}</div>
                    </div>
                </div>

                <div style="margin-bottom:15px;">
                    <h4 style="margin:0 0 10px 0;">Payment Details</h4>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:8px;">
                        <div><strong>Year:</strong> {{ $saraswatiPujaFee->year }}</div>
                        <div><strong>Amount:</strong> ₹{{ number_format($saraswatiPujaFee->fee_amount, 2) }}</div>
                        <div><strong>Fee Receive Date:</strong> {{ $saraswatiPujaFee->payment_date->format('d-m-Y') }}</div>
                        <div><strong>Payment Mode:</strong> {{ strtoupper($saraswatiPujaFee->payment_mode) }}</div>
                        <div><strong>Remarks:</strong> {{ $saraswatiPujaFee->remarks ?: 'N/A' }}</div>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:25px;">
                    <a href="{{ route('admin.saraswati_puja.index') }}" class="btn btn-default">Back</a>
                    <button class="btn btn-success" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
