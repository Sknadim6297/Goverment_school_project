@extends('admin.layouts.app')

@section('title', 'Collect Fees')

@section('breadcrumb')
    <li class="breadcrumb-item">Collect Fees</li>
    <li class="breadcrumb-item">Manage Collection</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Collect Fees</h3>
        </div>

        <div class="box-body">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #155724; opacity: 0.8;">×</button>
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #721c24; opacity: 0.8;">×</button>
                    <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            
            <!-- Search Form -->
            <table width="100%" style="margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <td width="100%">
                            <form action="{{ route('admin.collect_fees.search') }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                                @csrf
                                <input type="text" class="form-control" name="std_id" 
                                       placeholder="Search By Unique ID or Admission No" required style="flex: 1; max-width: 400px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.collect_fees.index') }}" class="btn btn-default">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="example1" class="data-table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 50px;">Sl.No.</th>
                            <th>Student Name</th>
                            <th>Unique ID</th>
                            <th>Admission No</th>
                            <th>Present Class</th>
                            <th style="width: 80px;">Photo</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $key => $student)
                            <tr>
                                <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                <td><strong>{{ $student->name ?? 'N/A' }}</strong></td>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->admission_no ?? 'N/A' }}</td>
                                <td>{{ $student->present_class ?? 'N/A' }}</td>
                                <td>
                                    @if($student->student_profile)
                                        <img src="{{ asset('storage/' . $student->student_profile) }}" 
                                             alt="Student Photo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <span class="label label-warning">No Photo</span>
                                    @endif
                                </td>
                                <td class="center">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.collect_fees.show', $student->id) }}" 
                                           class="btn btn-sm btn-info" data-toggle="tooltip" title="Collect Fees">
                                            <i class="fa fa-indian-rupee-sign"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <h5>No Students Found</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-5">
                    <div class="dataTables_info">
                        Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} entries
                    </div>
                </div>
                <div class="col-sm-7">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
