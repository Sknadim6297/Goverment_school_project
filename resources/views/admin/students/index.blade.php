@extends('admin.layouts.app')

@section('title', 'Manage Students')

@section('breadcrumb')
    <li class="breadcrumb-item">Student Management</li>
    <li class="breadcrumb-item">Manage Students</li>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Manage Student</h3>
        </div>

        <div class="box-body">
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

            <!-- Filter and Export Section -->
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-6">
                    <form action="{{ route('admin.students.filter') }}" method="post">
                        @csrf
                        <label>Choose Student Present Class</label>
                        <select class="form-control" name="class_name" onchange="this.form.submit()">
                            <option value="">All Classes</option>
                            <option value="Pre Primary" {{ (isset($className) && $className == 'Pre Primary') ? 'selected' : '' }}>Pre Primary</option>
                            <option value="I" {{ (isset($className) && $className == 'I') ? 'selected' : '' }}>I</option>
                            <option value="II" {{ (isset($className) && $className == 'II') ? 'selected' : '' }}>II</option>
                            <option value="III" {{ (isset($className) && $className == 'III') ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ (isset($className) && $className == 'IV') ? 'selected' : '' }}>IV</option>
                            <option value="V" {{ (isset($className) && $className == 'V') ? 'selected' : '' }}>V</option>
                            <option value="VI" {{ (isset($className) && $className == 'VI') ? 'selected' : '' }}>VI</option>
                            <option value="VII" {{ (isset($className) && $className == 'VII') ? 'selected' : '' }}>VII</option>
                            <option value="VIII" {{ (isset($className) && $className == 'VIII') ? 'selected' : '' }}>VIII</option>
                            <option value="IX" {{ (isset($className) && $className == 'IX') ? 'selected' : '' }}>IX</option>
                            <option value="X" {{ (isset($className) && $className == 'X') ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ (isset($className) && $className == 'XI') ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ (isset($className) && $className == 'XII') ? 'selected' : '' }}>XII</option>
                        </select>
                    </form>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <a href="{{ route('admin.students.export') }}" class="btn btn-success btn-block">
                        <i class="fa fa-file-excel"></i> Download In Excel
                    </a>
                </div>
            </div>

            <!-- Action Buttons -->
            <table width="100%" style="margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <td width="50%">
                            <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-action">
                                <i class="fa fa-plus"></i> Add New Student
                            </a>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <!-- Bulk Upload Section -->
            <form class="form-horizontal" action="{{ route('admin.students.bulk_upload') }}" method="post" enctype="multipart/form-data" style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ asset('uploads/Student_upload_excel.csv') }}" class="btn btn-success" download>
                            <i class="fa fa-download"></i> Download Excel Format
                        </a>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 15px;">
                    <label for="bulk_file" class="col-sm-4 control-label">Upload File (*Download the format from above link)</label>
                    <div class="col-sm-6">
                        <input type="file" name="bulk_file" id="bulk_file" class="form-control" required accept=".xlsx,.xls,.csv">
                        <span id="error_file" style="color:red"></span>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-info">
                            <i class="fa fa-upload"></i> Submit
                        </button>
                    </div>
                </div>
            </form>

            <!-- DataTable -->
            <div class="table-responsive">
                <table id="example1" class="data-table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Sl.No.</th>
                            <th>Student Name</th>
                            <th>Unique Id</th>
                            <th>Date Of Birth</th>
                            <th>Birth Regn No</th>
                            <th>Present Class</th>
                            <th>Mother Tongue</th>
                            <th>Nationality</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $student->name }}</strong></td>
                            <td>{{ $student->admission_no ?? 'STD' }}</td>
                            <td>{{ $student->dob ? $student->dob->format('Y-m-d') : '' }}</td>
                            <td>{{ $student->birth_regn_no ?? '' }}</td>
                            <td>{{ $student->present_class ?? '' }}</td>
                            <td>{{ $student->mother_tongue ?? '' }}</td>
                            <td>{{ $student->nationality ?? 'Indian' }}</td>
                            <td class="center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.students.view', $student->id) }}" 
                                       class="btn btn-sm btn-warning"
                                       data-toggle="tooltip"
                                       title="View Student">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.students.ledger', $student->id) }}" 
                                       class="btn btn-sm btn-info"
                                       data-toggle="tooltip"
                                       title="View Ledger">
                                        <i class="fa fa-bookmark"></i>
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
@endsection

@section('scripts')
@endsection
