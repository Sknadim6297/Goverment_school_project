@extends('admin.layouts.app')

@section('title', 'Manage Computer Admission')

@section('breadcrumb')
    <li class="breadcrumb-item">Computer Admission</li>
    <li class="breadcrumb-item">Manage</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Computer Admission List</h3>
        </div>

        <div class="box-body">
            <!-- DataTable -->
            <div class="table-responsive">
                <table id="example1" class="data-table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Roll No.</th>
                            <th>Admission Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($computerAdmissions as $index => $computerAdmission)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($computerAdmission->admission->name) }}</td>
                            <td>{{ $computerAdmission->admission->class }}</td>
                            <td>{{ $computerAdmission->admission->section ?? 'N/A' }}</td>
                            <td>{{ $computerAdmission->admission->rollno ?? 'N/A' }}</td>
                            <td>{{ $computerAdmission->admission->admission_no }}</td>
                            <td class="center">
                                <div class="action-buttons">
                                    @if($computerAdmission->payment_status == 'paid')
                                        <a class="btn btn-sm btn-success" 
                                           href="{{ route('admin.computer_admission.receipt', $computerAdmission->id) }}" 
                                           target="_blank"
                                           data-toggle="tooltip" 
                                           title="Receipt">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-sm btn-primary" 
                                           href="{{ route('admin.computer_admission.make_payment', $computerAdmission->id) }}" 
                                           data-toggle="tooltip" 
                                           title="Make Payment">
                                            <i class="fa fa-money"></i>
                                        </a>
                                    @endif

                                    <a class="btn btn-sm btn-warning" 
                                       href="{{ route('admin.computer_admission.edit', $computerAdmission->id) }}" 
                                       data-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.computer_admission.delete', $computerAdmission->id) }}" 
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
                            <td colspan="7" style="text-align:center;">No computer admissions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
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
