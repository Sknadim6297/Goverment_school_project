@extends('admin.layouts.app')

@section('title', 'Payment Receipt - Computer Admission')

@section('breadcrumb')
    <li class="breadcrumb-item">Computer Admission</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.computer_admission.index') }}">Manage</a></li>
    <li class="breadcrumb-item">Receipt</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box" id="printable">
                <div class="box-header">
                    <h3 class="box-title" style="text-align:center;">Computer Admission Payment Receipt</h3>
                </div>

                <div class="box-body">
                    <!-- School Header -->
                    <div style="text-align:center; margin-bottom: 30px;">
                        <h2>Government High School</h2>
                        <p>Computer Admission Fee Receipt</p>
                        <p>Receipt No: CA-{{ str_pad($computerAdmission->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    <!-- Student Information -->
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">Student Name</th>
                            <td width="25%">{{ $computerAdmission->admission->name }}</td>
                            <th width="25%">Admission Number</th>
                            <td width="25%">{{ $computerAdmission->admission->admission_no }}</td>
                        </tr>
                        <tr>
                            <th>Class</th>
                            <td>{{ $computerAdmission->admission->class }}</td>
                            <th>Section</th>
                            <td>{{ $computerAdmission->admission->section ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Roll Number</th>
                            <td>{{ $computerAdmission->admission->roll_no ?? 'N/A' }}</td>
                            <th>Guardian Name</th>
                            <td>{{ $computerAdmission->admission->guardian_name }}</td>
                        </tr>
                    </table>

                    <!-- Payment Details -->
                    <h4 style="margin-top: 30px;">Payment Details</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Particular</th>
                                <th style="text-align:right;">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Computer Fees</td>
                                <td style="text-align:right;">{{ number_format($computerAdmission->computer_fees ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Book Fees</td>
                                <td style="text-align:right;">{{ number_format($computerAdmission->book_fees ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Miscellaneous</td>
                                <td style="text-align:right;">{{ number_format($computerAdmission->miscellaneous_fees ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" style="text-align:right;">Total Amount Paid</th>
                                <th style="text-align:right;">{{ number_format($computerAdmission->paid_amount, 2) }}</th>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered" style="margin-top: 10px;">
                        <tr>
                            <th width="25%">Payment Date</th>
                            <td width="25%">{{ $computerAdmission->payment_date ? date('d-m-Y', strtotime($computerAdmission->payment_date)) : 'N/A' }}</td>
                            <th width="25%">Payment Mode</th>
                            <td width="25%">{{ ucfirst($computerAdmission->payment_mode ?? 'N/A') }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td colspan="3">
                                @if($computerAdmission->payment_status == 'paid')
                                    <span class="label label-success">PAID</span>
                                @else
                                    <span class="label label-warning">PENDING</span>
                                @endif
                            </td>
                        </tr>
                        @if($computerAdmission->remarks)
                        <tr>
                            <th>Remarks</th>
                            <td colspan="3">{{ $computerAdmission->remarks }}</td>
                        </tr>
                        @endif
                    </table>

                    <!-- Signature Section -->
                    <div style="margin-top: 50px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Date: {{ date('d-m-Y') }}</p>
                            </div>
                            <div class="col-sm-6" style="text-align:right;">
                                <p>_____________________</p>
                                <p>Authorized Signature</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer no-print">
                    <a href="{{ route('admin.computer_admission.index') }}" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <button type="button" class="btn btn-primary pull-right" onclick="window.print();">
                        <i class="fa fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .content-box {
            border: none !important;
            box-shadow: none !important;
        }
    }
    .pull-right {
        float: right;
    }
    .label {
        padding: 5px 10px;
        border-radius: 3px;
        color: white;
        font-weight: bold;
    }
    .label-success {
        background-color: #28a745;
    }
    .label-warning {
        background-color: #ffc107;
        color: #333;
    }
</style>
@endpush
