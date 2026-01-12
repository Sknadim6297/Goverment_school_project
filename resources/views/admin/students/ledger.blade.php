@extends('admin.layouts.app')

@section('title', 'Student Ledger')

@section('breadcrumb')
    <li class="breadcrumb-item">Student Management</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Manage Students</a></li>
    <li class="breadcrumb-item">Ledger</li>
@endsection

@section('styles')
<style>
.summary { display:flex; flex-wrap:wrap; gap:12px; margin-bottom:12px; }
.summary .card { flex:1 1 220px; background:#fff; border:1px solid #e5e5e5; border-radius:6px; padding:10px; }
.summary .card h6 { margin:0 0 6px; font-weight:600; color:#333; }
.table { width:100%; border-collapse:collapse; }
.table th, .table td { border:1px solid #e5e5e5; padding:8px; text-align:left; }
.table th { background:#fafafa; }
.actions { display:flex; gap:8px; }
</style>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Student Transaction List</h3>
        </div>
        <div class="box-body">
            <div class="summary">
                <div class="card">
                    <h6>Student</h6>
                    <div>{{ $student->name }}</div>
                </div>
                <div class="card">
                    <h6>Admission No</h6>
                    <div>{{ $student->admission_no ?? '—' }}</div>
                </div>
                <div class="card">
                    <h6>Class</h6>
                    <div>{{ $student->present_class ?? '—' }}</div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="example1" class="data-table table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Sl.No.</th>
                            <th>Payment Desc</th>
                            <th>Payment Date</th>
                            <th>Payment Amount</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $index => $payment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $payment->remarks ?? '—' }}</td>
                                <td>{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '—' }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->receipt_no }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="actions" style="margin-top:16px;">
                <a href="{{ route('admin.students.view', $student->id) }}" class="btn btn-default"><i class="fa fa-user"></i> Student</a>
                <a href="{{ route('admin.students.index') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</section>
@endsection
