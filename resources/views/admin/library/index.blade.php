@extends('admin.layouts.app')

@section('title', 'Library Management')

@section('breadcrumb')
    <li class="breadcrumb-item">Library Management</li>
    <li class="breadcrumb-item">Manage Library</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Total Library</h3>
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

            @if(session('info'))
                <div class="alert alert-info alert-dismissible" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #0c5460; opacity: 0.8;">×</button>
                    <i class="fa fa-info-circle"></i> {{ session('info') }}
                </div>
            @endif

            <!-- Action Buttons -->
            <table width="100%" style="margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <td width="50%">
                            <a href="{{ route('admin.library.create') }}" class="btn btn-primary btn-action">
                                <i class="fa fa-plus"></i> Add New
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.library.export') }}" class="btn btn-success">
                                <i class="fa fa-file-excel"></i> Download In Excel
                            </a>
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
                            <th>Student Name</th>
                            <th>Registration No</th>
                            <th>Class Name</th>
                            <th>Book Name</th>
                            <th>Issue Date</th>
                            <th>Return Date</th>
                            <th>Returning On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($libraries as $index => $library)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $library->student_name }}</strong></td>
                            <td>{{ $library->registration_no }}</td>
                            <td>{{ $library->class_name }}</td>
                            <td>{{ $library->book_name }}</td>
                            <td>{{ $library->issue_date ? \Carbon\Carbon::parse($library->issue_date)->format('d-m-Y') : 'N/A' }}</td>
                            <td>{{ $library->return_date ? \Carbon\Carbon::parse($library->return_date)->format('d-m-Y') : 'N/A' }}</td>
                            <td>
                                @if($library->returning_on)
                                    {{ \Carbon\Carbon::parse($library->returning_on)->format('d-m-Y') }}
                                @else
                                    <span class="label label-warning">Not Returned</span>
                                @endif
                            </td>
                            <td class="center">
                                <div class="action-buttons">
                                    <a class="btn btn-sm btn-warning" 
                                       href="{{ route('admin.library.edit', $library->id) }}" 
                                       data-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" 
                                       href="javascript:void(0);" 
                                       onclick="deleteLibrary({{ $library->id }})" 
                                       data-toggle="tooltip" 
                                       title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Hidden Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('scripts')
<script>
function deleteLibrary(id) {
    if (confirm('Are you sure you want to delete this library record?')) {
        var form = document.getElementById('deleteForm');
        form.action = '{{ route("admin.library.delete", ":id") }}'.replace(':id', id);
        form.submit();
    }
}
</script>
@endsection
