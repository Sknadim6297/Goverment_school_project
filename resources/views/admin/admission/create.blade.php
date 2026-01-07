@extends('admin.layouts.app')

@section('title', 'Add New Admission')

@section('breadcrumb')
    <li class="breadcrumb-item">Admission</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.admission.index') }}">Manage Admission</a></li>
    <li class="breadcrumb-item">Add New</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Admission Details</h3>
                    <div id="validation" style="color:red;"></div>
                </div>

                <form class="form-horizontal" action="{{ route('admin.admission.store') }}" method="post" onsubmit="return validation()" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        
                        <div class="form-group">
                            <label for="admission_no" class="col-sm-2 control-label">Admission Number</label>
                            <div class="col-sm-4">
                                <input type="text" name="admission_no" id="admission_no" class="form-control" placeholder="Leave blank for auto-generate" value="{{ old('admission_no') }}">
                                <span id="error_catname" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="admission_date" class="col-sm-2 control-label">Admission Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="admission_date" id="admission_date" class="form-control" required value="{{ old('admission_date', date('Y-m-d')) }}">
                                <span id="error_catname" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label required-field">Name</label>
                            <div class="col-sm-4">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Type Your Name" required value="{{ old('name') }}">
                                <span id="error_catname" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="class" class="col-sm-2 control-label required-field">Class</label>
                            <div class="col-sm-4">
                                <select type="text" name="class" id="class" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    <option value="Pre Primary" {{ old('class') == 'Pre Primary' ? 'selected' : '' }}>Pre Primary</option>
                                    <option value="I" {{ old('class') == 'I' ? 'selected' : '' }}>I</option>
                                    <option value="II" {{ old('class') == 'II' ? 'selected' : '' }}>II</option>
                                    <option value="III" {{ old('class') == 'III' ? 'selected' : '' }}>III</option>
                                    <option value="IV" {{ old('class') == 'IV' ? 'selected' : '' }}>IV</option>
                                    <option value="V" {{ old('class') == 'V' ? 'selected' : '' }}>V</option>
                                    <option value="VI" {{ old('class') == 'VI' ? 'selected' : '' }}>VI</option>
                                    <option value="VII" {{ old('class') == 'VII' ? 'selected' : '' }}>VII</option>
                                    <option value="VIII" {{ old('class') == 'VIII' ? 'selected' : '' }}>VIII</option>
                                    <option value="IX" {{ old('class') == 'IX' ? 'selected' : '' }}>IX</option>
                                    <option value="X" {{ old('class') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ old('class') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ old('class') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="section" class="col-sm-2 control-label">Section</label>
                            <div class="col-sm-4">
                                <input type="text" name="section" id="section" class="form-control" placeholder="Type Your section" value="{{ old('section') }}">
                                <span id="error_catname" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rollno" class="col-sm-2 control-label">Roll No.</label>
                            <div class="col-sm-4">
                                <input type="text" name="rollno" id="rollno" class="form-control" placeholder="Type Roll No" value="{{ old('rollno') }}">
                                <span id="error_catname" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group" id="stream_div" style="display: none;">
                            <label for="stream" class="col-sm-2 control-label">Stream</label>
                            <div class="col-sm-4">
                                <select type="text" name="stream" id="stream" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="Arts" {{ old('stream') == 'Arts' ? 'selected' : '' }}>Arts</option>
                                    <option value="Science" {{ old('stream') == 'Science' ? 'selected' : '' }}>Science</option>
                                    <option value="Para science" {{ old('stream') == 'Para science' ? 'selected' : '' }}>Para science</option>
                                    <option value="Commerce" {{ old('stream') == 'Commerce' ? 'selected' : '' }}>Commerce</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="guardian_name" class="col-sm-2 control-label required-field">Guardian Name</label>
                            <div class="col-sm-4">
                                <input type="text" name="guardian_name" id="guardian_name" class="form-control" placeholder="Type Guardian Name" required value="{{ old('guardian_name') }}">
                                <span id="error_catname" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile_number" class="col-sm-2 control-label required-field">Mobile Number</label>
                            <div class="col-sm-4">
                                <input type="text" name="mobile_number" id="mobile_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Type Mobile Number" minlength="10" maxlength="10" class="form-control" required value="{{ old('mobile_number') }}">
                                <span id="error_catname" style="color:red"></span>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <a href="{{ route('admin.admission.index') }}" class="btn btn-danger">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-info pull-right">
                            <i class="fa fa-save"></i> Add Admission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .pull-right {
        float: right;
    }
    .col-md-12 {
        width: 100%;
    }
</style>
@endpush
