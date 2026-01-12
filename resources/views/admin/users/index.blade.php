@extends('admin.layouts.app')

@section('title', 'User Management')

@section('breadcrumb')
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item">Manage Users</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Total Users</h3>
        </div>

        <div class="box-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible" style="margin-bottom: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Action Buttons -->
            <table width="100%" style="margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <td width="50%">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-action">
                                <i class="fa fa-plus"></i> Add New User
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.export') }}" class="btn btn-success">
                                <i class="fa fa-file-excel"></i> Download Excel
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
                            <th style="width: 80px;">Sl.No.</th>
                            <th>User Name</th>
                            <th>User Id</th>
                            <th>Position Hold</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->position_hold == 1 ? 'danger' : ($user->position_hold == 2 ? 'info' : 'warning') }}">
                                    {{ $user->position_name }}
                                </span>
                            </td>
                            <td class="center">
                                <div class="action-buttons">
                                    <a class="btn btn-sm btn-warning" 
                                       href="{{ route('admin.users.edit', $user->id) }}" 
                                       data-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    @if($user->id != auth()->id())
                                    <form action="{{ route('admin.users.delete', $user->id) }}" 
                                          method="POST" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-toggle="tooltip" 
                                                title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
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
@endsection

@section('scripts')
@endsection
