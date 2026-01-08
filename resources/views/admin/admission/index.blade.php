@extends('admin.layouts.app')

@section('title', 'Total Admissions')

@section('breadcrumb')
    <li class="breadcrumb-item">Admission</li>
    <li class="breadcrumb-item">Manage Admission</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Total Admission</h3>
        </div>

        <div class="box-body">
            <!-- Action Buttons -->
            <table width="100%" style="margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <td width="50%">
                            <a href="{{ route('admin.admission.create') }}" class="btn btn-primary btn-action">
                                <i class="fa fa-plus"></i> Add New Admission
                            </a>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                <a href="{{ route('admin.admission.export', ['format' => 'xls']) }}" class="btn btn-success">
                                    <i class="fa fa-file-excel-o"></i> Excel
                                </a>
                                <a href="{{ route('admin.admission.export', ['format' => 'csv']) }}" class="btn btn-success">
                                    <i class="fa fa-download"></i> CSV
                                </a>
                                <a href="{{ route('admin.admission.export', ['format' => 'pdf']) }}" class="btn btn-danger">
                                    <i class="fa fa-file-pdf-o"></i> PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="example1" class="data-table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Stream</th>
                            <th>Guardian Name & Number</th>
                            <th>Admission Number</th>
                            <th>Action</th>
                            <th>Event(Saraswati Puja)</th>
                            <th>Event(Computer Class)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admissions as $index => $admission)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($admission->name) }}</td>
                            <td>{{ $admission->class }}</td>
                            <td>{{ $admission->stream ?? '' }}</td>
                            <td>{{ $admission->guardian_name }}({{ $admission->mobile_number }})</td>
                            <td>{{ $admission->admission_no }}</td>
                            <td class="center">
                                <div class="action-buttons">
                                    @if($admission->payment_status == 'pending')
                                        <a class="btn btn-sm btn-primary" 
                                           href="{{ route('admin.admission.make_payment', $admission->id) }}" 
                                           data-toggle="tooltip" 
                                           title="Payment">
                                            <i class="fa fa-money-bill"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-sm btn-info" 
                                           href="{{ route('admin.admission.edit_receipt', $admission->id) }}" 
                                           data-toggle="tooltip" 
                                           title="Edit Receipt">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-success" 
                                           href="{{ route('admin.admission.receipt', $admission->id) }}" 
                                           target="_blank"
                                           data-toggle="tooltip" 
                                           title="Receipt">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endif

                                    <a class="btn btn-sm btn-warning" 
                                       href="{{ route('admin.admission.edit', $admission->id) }}" 
                                       data-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.admission.delete', $admission->id) }}" 
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
                            <td>
                                @if($admission->saraswatiPujaFees->count() > 0)
                                    <a class="btn btn-sm btn-success" 
                                       href="{{ route('admin.saraswati_puja.receipt', $admission->saraswatiPujaFees->first()->id) }}" 
                                       target="_blank"
                                       data-toggle="tooltip" 
                                       title="Saraswati Puja Receipt">
                                        Take Receipt
                                    </a>
                                @else
                                    <a class="btn btn-sm btn-info" 
                                       href="{{ route('admin.saraswati_puja.create', $admission->id) }}" 
                                       data-toggle="tooltip" 
                                       title="Add Saraswati Puja">
                                        Add New
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($admission->computerAdmission)
                                    <a class="btn btn-sm btn-success" 
                                       href="{{ route('admin.computer_admission.receipt', $admission->computerAdmission->id) }}" 
                                       target="_blank"
                                       data-toggle="tooltip" 
                                       title="Computer Admission Receipt">
                                        Take Receipt
                                    </a>
                                @else
                                    <a class="btn btn-sm btn-info" 
                                       href="{{ route('admin.computer_admission.create', $admission->id) }}" 
                                       data-toggle="tooltip" 
                                       title="Add Computer Admission">
                                        Add New
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No admissions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 20px;">
                {{ $admissions->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.02);
    }
    .action-buttons {
        white-space: nowrap;
    }
    .action-buttons .btn {
        margin: 2px;
    }
</style>
@endpush
