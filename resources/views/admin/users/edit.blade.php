@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('breadcrumb')
    <li class="breadcrumb-item">User Management</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
    <li class="breadcrumb-item">Edit User</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Edit User Details</h3>
                    @if($errors->any())
                        <div class="alert alert-danger" style="margin-top: 15px;">
                            <strong>Validation Errors:</strong>
                            <ul style="margin-bottom: 0;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <form class="form-horizontal" 
                      action="{{ route('admin.users.update', $user->id) }}" 
                      method="post">
                    @csrf
                    @method('PUT')
                    
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required-field">Name</label>
                            <div class="col-sm-6">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control" 
                                       placeholder="Enter Full Name" 
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_id" class="col-sm-2 control-label required-field">User Id (Email)</label>
                            <div class="col-sm-6">
                                <input type="email" 
                                       name="user_id" 
                                       id="user_id" 
                                       class="form-control" 
                                       placeholder="Enter Email Address" 
                                       value="{{ old('user_id', $user->email) }}"
                                       required>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control" 
                                       placeholder="Enter New Password (Leave blank to keep current)">
                                <small class="help-block" style="color: #999; margin-top: 5px;">
                                    <i class="fa fa-info-circle"></i> Leave blank if you don't want to change password
                                </small>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="position_hold" class="col-sm-2 control-label required-field">Position Hold</label>
                            <div class="col-sm-6">
                                <select name="position_hold" 
                                        id="position_hold" 
                                        class="form-control" 
                                        required>
                                    <option value="">-Please Select-</option>
                                    <option value="1" {{ old('position_hold', $user->position_hold) == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ old('position_hold', $user->position_hold) == 2 ? 'selected' : '' }}>Accountant</option>
                                    <option value="3" {{ old('position_hold', $user->position_hold) == 3 ? 'selected' : '' }}>Librarian</option>
                                </select>
                                @error('position_hold')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="box-footer" style="background: #f9f9f9; padding: 15px; border-top: 1px solid #ddd;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-default">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success" style="margin-left: 10px;">
                                <i class="fa fa-save"></i> Update
                            </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
