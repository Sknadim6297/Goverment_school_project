@extends('admin.layouts.app')

@section('title', 'Saraswati Puja Fee Reports')

@section('breadcrumb')
    <li class="breadcrumb-item">Saraswati Puja Committee</li>
    <li class="breadcrumb-item">Reports</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Saraswati Puja Fee Reports</h3>
        </div>

        <div class="box-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.saraswati_puja.reports') }}" class="form-horizontal" style="margin-bottom: 30px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
                <div class="row" style="margin-bottom: 10px; gap: 10px;">
                    <div class="col-sm-3">
                        <label class="control-label">Year</label>
                        <select name="year" class="form-control">
                            <option value="">All Years</option>
                            @for($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-sm-3" style="margin-top:25px; display:flex; gap:8px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Filter
                        </button>
                        <button type="submit" name="download" value="csv" class="btn btn-success">
                            <i class="fa fa-download"></i> CSV
                        </button>
                        <button type="submit" name="download" value="xls" class="btn btn-success">
                            <i class="fa fa-file-excel-o"></i> XLS
                        </button>
                        <button type="submit" name="download" value="pdf" class="btn btn-danger">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </button>
                        <a href="{{ route('admin.saraswati_puja.reports') }}" class="btn btn-default">Clear</a>
                    </div>
                </div>
            </form>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="example1" class="data-table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Student Name</th>
                            <th>Admission No</th>
                            <th>Class</th>
                            <th>Year</th>
                            <th>Fee Amount</th>
                            <th>Receipt No</th>
                            <th>Payment Date</th>
                            <th>Payment Mode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalAmount = 0; @endphp
                        @forelse($saraswatiPujaFees as $index => $fee)
                        @php $totalAmount += $fee->fee_amount; @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($fee->admission->name) }}</td>
                            <td>{{ $fee->admission->admission_no }}</td>
                            <td>{{ $fee->admission->class }}</td>
                            <td>{{ $fee->year }}</td>
                            <td>₹{{ number_format($fee->fee_amount, 2) }}</td>
                            <td>{{ $fee->receipt_no }}</td>
                            <td>{{ $fee->payment_date->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge" style="padding: 5px 10px; border-radius: 4px; text-transform: uppercase; 
                                    @if($fee->payment_mode == 'cash') background: #28a745; color: white;
                                    @elseif($fee->payment_mode == 'online') background: #17a2b8; color: white;
                                    @else background: #ffc107; color: #212529; @endif">
                                    {{ $fee->payment_mode }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align:center;">No Saraswati Puja fees found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($saraswatiPujaFees->count() > 0)
                    <tfoot style="background: #f8f9fa; font-weight: bold;">
                        <tr>
                            <td colspan="5" style="text-align: right;">Total Collection:</td>
                            <td colspan="4">₹{{ number_format($totalAmount, 2) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $saraswatiPujaFees->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
