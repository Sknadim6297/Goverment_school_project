@extends('admin.layouts.app')

@section('title', 'Manage Saraswati Puja Fee')

@section('breadcrumb')
    <li class="breadcrumb-item">Saraswati Puja Committee</li>
    <li class="breadcrumb-item">Manage Fee</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Saraswati Puja Fee List</h3>
        </div>

        <div class="box-body">
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($saraswatiPujaFees as $index => $fee)
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
                            <td class="center">
                                <div class="action-buttons">
                                    <a class="btn btn-sm btn-success" 
                                       href="{{ route('admin.saraswati_puja.receipt', $fee->id) }}" 
                                       target="_blank"
                                       data-toggle="tooltip" 
                                       title="Receipt">
                                        <i class="fa fa-download"></i>
                                    </a>

                                    <a class="btn btn-sm btn-warning" 
                                       href="{{ route('admin.saraswati_puja.edit', $fee->id) }}" 
                                       data-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.saraswati_puja.delete', $fee->id) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Are you Sure to delete it')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-toggle="tooltip" 
                                                title="Delete">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align:center;">No Saraswati Puja fees found.</td>
                        </tr>
                        @endforelse
                    </tbody>
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
