@extends('admin.layouts.app')

@section('title', 'Computer Admission Reports')

@section('breadcrumb')
    <li class="breadcrumb-item">Computer Admission</li>
    <li class="breadcrumb-item">Reports</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Computer Admission Reports</h3>
        </div>

        <div class="box-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.computer_admission.reports') }}" class="form-horizontal" style="margin-bottom: 30px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-sm-4">
                        <label class="control-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-sm-4" style="margin-top:25px; display:flex; gap:8px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Filter
                        </button>
                        <button type="submit" name="download" value="csv" class="btn btn-success">
                            <i class="fa fa-download"></i> CSV
                        </button>
                        <button type="submit" name="download" value="xls" class="btn btn-success">
                            <i class="fa fa-file-excel-o"></i> XLS
                        </button>
                        <a href="{{ route('admin.computer_admission.reports') }}" class="btn btn-default">Clear</a>
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
                            <th>Course Name</th>
                            <th>Course Fee</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                            <th>Payment Status</th>
                            <th>Enrollment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalFee = 0; $totalPaid = 0; @endphp
                        @forelse($computerAdmissions as $index => $computerAdmission)
                        @php 
                            $totalFee += $computerAdmission->course_fee; 
                            $totalPaid += $computerAdmission->paid_amount; 
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($computerAdmission->admission->name) }}</td>
                            <td>{{ $computerAdmission->admission->admission_no }}</td>
                            <td>{{ $computerAdmission->admission->class }}</td>
                            <td>{{ $computerAdmission->course_name }}</td>
                            <td>₹{{ number_format($computerAdmission->course_fee, 2) }}</td>
                            <td>₹{{ number_format($computerAdmission->paid_amount, 2) }}</td>
                            <td>₹{{ number_format($computerAdmission->course_fee - $computerAdmission->paid_amount, 2) }}</td>
                            <td>
                                @if($computerAdmission->payment_status == 'paid')
                                    <span class="badge badge-success" style="background: #28a745; color: white; padding: 5px 10px; border-radius: 4px;">Paid</span>
                                @elseif($computerAdmission->payment_status == 'partial')
                                    <span class="badge badge-warning" style="background: #ffc107; color: #212529; padding: 5px 10px; border-radius: 4px;">Partial</span>
                                @else
                                    <span class="badge badge-danger" style="background: #dc3545; color: white; padding: 5px 10px; border-radius: 4px;">Pending</span>
                                @endif
                            </td>
                            <td>{{ $computerAdmission->enrollment_date->format('d-m-Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align:center;">No computer admissions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($computerAdmissions->count() > 0)
                    <tfoot style="background: #f8f9fa; font-weight: bold;">
                        <tr>
                            <td colspan="5" style="text-align: right;">Total:</td>
                            <td>₹{{ number_format($totalFee, 2) }}</td>
                            <td>₹{{ number_format($totalPaid, 2) }}</td>
                            <td>₹{{ number_format($totalFee - $totalPaid, 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $computerAdmissions->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
