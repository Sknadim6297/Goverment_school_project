@extends('admin.layouts.app')

@section('title', 'Add New Student')

@section('breadcrumb')
    <li class="breadcrumb-item">Student Management</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Manage Students</a></li>
    <li class="breadcrumb-item">Add New Student</li>
@endsection

@section('styles')
<style>
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 15px;
}
.input-container {
    position: relative;
    margin-bottom: 15px;
}
.input-container .icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}
.input-container input,
.input-container select,
.input-container textarea {
    padding-left: 35px;
    width: 100%;
}
.rounded {
    border-radius: 10px;
    border: 2px solid #ddd;
    padding: 5px;
}
.nav-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: space-between;
    background: #f9f9f9;
    padding: 15px;
    border-top: 1px solid #ddd;
    margin-top: 20px;
}
.nav-buttons-left {
    display: flex;
    gap: 10px;
}
.nav-buttons-right {
    display: flex;
    gap: 10px;
}
.nav-buttons button,
.nav-buttons a {
    white-space: nowrap;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.nav-buttons button i,
.nav-buttons a i {
    font-size: 14px;
}
</style>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Student Details</h3>
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
                      action="{{ route('admin.students.store') }}" 
                      method="post"
                      enctype="multipart/form-data">
                    @csrf

                    <!-- A. Basic Information -->
                    <div style="padding: 20px; display: block;" class="grid" id="basicinformation">
                        <div class="input-container">
                            <i class="fa fa-camera icon"></i>
                            <input type="file" name="student_profile" id="student_profile" 
                                   onchange="previewFile(this);" class="form-control" accept="image/*">
                        </div>
                        <img id="previewImg" class="rounded float-left" 
                             src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" 
                             width="250px" height="250px">
                        
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">A. Basic Information</h3>
                        </div>

                        <div>
                            <label for="name">Full Name*</label>
                            <div class="input-container">
                                <i class="fa fa-user icon"></i>
                                <input type="text" class="form-control" name="name" id="name" 
                                       placeholder="Full Name" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="dob">DOB*</label>
                            <div class="input-container">
                                <i class="fa fa-calendar icon"></i>
                                <input type="date" name="dob" id="dob" class="form-control" 
                                       value="{{ old('dob') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="birth_regn_no">Birth Regn No</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="birth_regn_no" id="birth_regn_no" 
                                       class="form-control" placeholder="Birth Regn No" 
                                       value="{{ old('birth_regn_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gender">Select Gender*</label>
                            <div class="input-container">
                                <i class="fa fa-venus-mars icon"></i>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="transgender" {{ old('gender') == 'transgender' ? 'selected' : '' }}>Transgender</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="social_category">Social Category*</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="social_category" id="social_category" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    <option value="sc" {{ old('social_category') == 'sc' ? 'selected' : '' }}>SC</option>
                                    <option value="st" {{ old('social_category') == 'st' ? 'selected' : '' }}>ST</option>
                                    <option value="obc" {{ old('social_category') == 'obc' ? 'selected' : '' }}>OBC</option>
                                    <option value="general" {{ old('social_category') == 'general' ? 'selected' : '' }}>General</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="religion">Religion*</label>
                            <div class="input-container">
                                <i class="fa fa-user icon"></i>
                                <input type="text" name="religion" id="religion" class="form-control" 
                                       placeholder="Religion" value="{{ old('religion') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="mother_tongue">Mother Tongue*</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="mother_tongue" id="mother_tongue" 
                                       class="form-control" value="{{ old('mother_tongue', 'Bengali') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="nationality">Nationality*</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="nationality" id="nationality" 
                                       class="form-control" value="{{ old('nationality', 'Indian') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="aadhar_no">Aadhaar No</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="aadhar_no" id="aadhar_no" 
                                       class="form-control" placeholder="Aadhaar No" 
                                       value="{{ old('aadhar_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="blood_group">Blood Group</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="blood_group" id="blood_group" 
                                       class="form-control" placeholder="Blood Group" 
                                       value="{{ old('blood_group') }}">
                            </div>
                        </div>

                        <div>
                            <label for="health_id">Health ID</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="health_id" id="health_id" 
                                       class="form-control" placeholder="Health ID" 
                                       value="{{ old('health_id') }}">
                            </div>
                        </div>

                        <div>
                            <label for="identyfication_mark">Identification Mark</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="identyfication_mark" id="identyfication_mark" 
                                       class="form-control" placeholder="Identification Mark" 
                                       value="{{ old('identyfication_mark') }}">
                            </div>
                        </div>
                    </div>

                    <!-- B. Educational Information -->
                    <div style="padding: 20px; display: none;" class="grid" id="educationalinformation">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">B. Educational Information</h3>
                        </div>

                        <div>
                            <label for="academic_year">Academic Year*</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="academic_year" id="academic_year" 
                                       class="form-control" placeholder="Academic Year (20XX-XX)" 
                                       value="{{ old('academic_year') }}">
                            </div>
                        </div>

                        <div>
                            <label for="admission_no">Admission No</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="admission_no" id="admission_no" 
                                       class="form-control" placeholder="Admission No" 
                                       value="{{ old('admission_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="admission_date">Admission Date*</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="date" name="admission_date" id="admission_date" 
                                       class="form-control" value="{{ old('admission_date') }}">
                            </div>
                        </div>

                        <div>
                            <label for="present_class">Present Class*</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="present_class" id="present_class" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    <option value="Pre Primary">Pre Primary</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>
                                    <option value="VII">VII</option>
                                    <option value="VIII">VIII</option>
                                    <option value="IX">IX</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="present_section">Present Section*</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="present_section" id="present_section" 
                                       class="form-control" placeholder="Present Section" 
                                       value="{{ old('present_section') }}">
                            </div>
                        </div>

                        <div>
                            <label for="present_roll_no">Present Roll No</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="present_roll_no" id="present_roll_no" 
                                       class="form-control" placeholder="Present Roll No" 
                                       value="{{ old('present_roll_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="present_streams">Present Stream</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="present_streams" id="present_streams" 
                                       class="form-control" placeholder="Present Stream" 
                                       value="{{ old('present_streams') }}">
                            </div>
                        </div>

                        <div>
                            <label for="previous_class">Previous Class</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="previous_class" id="previous_class" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>
                                    <option value="VII">VII</option>
                                    <option value="VIII">VIII</option>
                                    <option value="IX">IX</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="previous_section">Previous Section</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="previous_section" id="previous_section" 
                                       class="form-control" placeholder="Previous Section" 
                                       value="{{ old('previous_section') }}">
                            </div>
                        </div>

                        <div>
                            <label for="previous_roll_no">Previous Roll No</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="previous_roll_no" id="previous_roll_no" 
                                       class="form-control" placeholder="Previous Roll No" 
                                       value="{{ old('previous_roll_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="previous_streams">Previous Stream</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="previous_streams" id="previous_streams" 
                                       class="form-control" placeholder="Previous Stream" 
                                       value="{{ old('previous_streams') }}">
                            </div>
                        </div>

                        <div>
                            <label for="medium">Medium</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="medium" id="medium" 
                                       class="form-control" placeholder="Medium" 
                                       value="{{ old('medium') }}">
                            </div>
                        </div>

                        <div>
                            <label for="status_of_previous_year">If studying in class 1, status of previous year</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="status_of_previous_year" id="status_of_previous_year" 
                                       class="form-control" placeholder="Status of previous year" 
                                       value="{{ old('status_of_previous_year') }}">
                            </div>
                        </div>

                        <div>
                            <label for="child_attend_school">Number of days child attended school</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="child_attend_school" id="child_attend_school" 
                                       class="form-control" placeholder="Number of days" 
                                       value="{{ old('child_attend_school') }}">
                            </div>
                        </div>
                    </div>

                    <!-- C. Contact Information -->
                    <div style="padding: 20px; display: none;" class="grid" id="contactinformation">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">C. Contact Information</h3>
                        </div>

                        <div>
                            <label for="address">Address*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <textarea name="address" id="address" class="form-control" 
                                          placeholder="Address">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label for="locality">Habitation or Locality*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="locality" id="locality" 
                                       class="form-control" placeholder="Habitation or Locality" 
                                       value="{{ old('locality') }}">
                            </div>
                        </div>

                        <div>
                            <label for="district">District*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="district" id="district" 
                                       class="form-control" placeholder="District" 
                                       value="{{ old('district') }}">
                            </div>
                        </div>

                        <div>
                            <label for="block_municipaity">Block or Municipality*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="block_municipaity" id="block_municipaity" 
                                       class="form-control" placeholder="Block or Municipality" 
                                       value="{{ old('block_municipaity') }}">
                            </div>
                        </div>

                        <div>
                            <label for="panchayat">Panchayat</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="panchayat" id="panchayat" 
                                       class="form-control" placeholder="Panchayat" 
                                       value="{{ old('panchayat') }}">
                            </div>
                        </div>

                        <div>
                            <label for="post_office">Post Office*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="post_office" id="post_office" 
                                       class="form-control" placeholder="Post Office" 
                                       value="{{ old('post_office') }}">
                            </div>
                        </div>

                        <div>
                            <label for="police_station">Police Station*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="police_station" id="police_station" 
                                       class="form-control" placeholder="Police Station" 
                                       value="{{ old('police_station') }}">
                            </div>
                        </div>

                        <div>
                            <label for="pincode">Pincode*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="pincode" id="pincode" 
                                       class="form-control" placeholder="Pincode" 
                                       value="{{ old('pincode') }}">
                            </div>
                        </div>

                        <div>
                            <label for="contact_no">Contact No.*</label>
                            <div class="input-container">
                                <i class="fa fa-phone icon"></i>
                                <input type="text" name="contact_no" id="contact_no" 
                                       class="form-control" placeholder="Contact no." 
                                       maxlength="11" value="{{ old('contact_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="email_id">Email Id</label>
                            <div class="input-container">
                                <i class="fa fa-envelope icon"></i>
                                <input type="email" name="email_id" id="email_id" 
                                       class="form-control" placeholder="Email" 
                                       value="{{ old('email_id') }}">
                            </div>
                        </div>
                    </div>

                    <!-- D. Guardian's Details -->
                    <div style="padding: 20px; display: none;" class="grid" id="gurdaindetails">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">D. Guardian's Details</h3>
                        </div>

                        <div>
                            <label for="father_name">Father's Name*</label>
                            <div class="input-container">
                                <i class="fa fa-user icon"></i>
                                <input type="text" name="father_name" id="father_name" 
                                       class="form-control" placeholder="Father's Name" 
                                       value="{{ old('father_name') }}">
                            </div>
                        </div>

                        <div>
                            <label for="mother_name">Mother's Name*</label>
                            <div class="input-container">
                                <i class="fa fa-user icon"></i>
                                <input type="text" name="mother_name" id="mother_name" 
                                       class="form-control" placeholder="Mother's Name" 
                                       value="{{ old('mother_name') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurdain_name">Guardian's Name*</label>
                            <div class="input-container">
                                <i class="fa fa-user icon"></i>
                                <input type="text" name="gurdain_name" id="gurdain_name" 
                                       class="form-control" placeholder="Guardian's Name" 
                                       value="{{ old('gurdain_name') }}">
                            </div>
                        </div>

                        <div>
                            <label for="relation">Relationship (With Guardian)*</label>
                            <div class="input-container">
                                <i class="fa fa-user icon"></i>
                                <input type="text" name="relation" id="relation" 
                                       class="form-control" placeholder="Relationship" 
                                       value="{{ old('relation') }}">
                            </div>
                        </div>

                        <div>
                            <label for="family_income">Annual Family Income</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="family_income" id="family_income" 
                                       class="form-control" placeholder="Annual Family Income" 
                                       value="{{ old('family_income') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurdain_qualification">Guardian's Qualification</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="gurdain_qualification" id="gurdain_qualification" 
                                       class="form-control" placeholder="Guardian's Qualification" 
                                       value="{{ old('gurdain_qualification') }}">
                            </div>
                        </div>
                    </div>

                    <!-- E. Guardian's Contact Information -->
                    <div style="padding: 20px; display: none;" class="grid" id="gurdaincontactinformation">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">E. Guardian's Contact Information</h3>
                        </div>

                        <div>
                            <label for="gurd_address">Address*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <textarea name="gurd_address" id="gurd_address" class="form-control" 
                                          placeholder="Address">{{ old('gurd_address') }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label for="gurd_locality">Habitation or Locality*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="gurd_locality" id="gurd_locality" 
                                       class="form-control" placeholder="Habitation or Locality" 
                                       value="{{ old('gurd_locality') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_district">District*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="gurd_district" id="gurd_district" 
                                       class="form-control" placeholder="District" 
                                       value="{{ old('gurd_district') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_block_municipaity">Block or Municipality*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="gurd_block_municipaity" id="gurd_block_municipaity" 
                                       class="form-control" placeholder="Block or Municipality" 
                                       value="{{ old('gurd_block_municipaity') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_panchayat">Panchayat</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="gurd_panchayat" id="gurd_panchayat" 
                                       class="form-control" placeholder="Panchayat" 
                                       value="{{ old('gurd_panchayat') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_post_office">Post Office*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="gurd_post_office" id="gurd_post_office" 
                                       class="form-control" placeholder="Post Office" 
                                       value="{{ old('gurd_post_office') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_police_station">Police Station*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="gurd_police_station" id="gurd_police_station" 
                                       class="form-control" placeholder="Police Station" 
                                       value="{{ old('gurd_police_station') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_pincode">Pincode*</label>
                            <div class="input-container">
                                <i class="fa fa-map-marker icon"></i>
                                <input type="text" name="gurd_pincode" id="gurd_pincode" 
                                       class="form-control" placeholder="Pincode" 
                                       value="{{ old('gurd_pincode') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_contact_no">Contact No.*</label>
                            <div class="input-container">
                                <i class="fa fa-phone icon"></i>
                                <input type="text" name="gurd_contact_no" id="gurd_contact_no" 
                                       class="form-control" placeholder="Contact no." 
                                       maxlength="11" value="{{ old('gurd_contact_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="gurd_email_id">Email Id</label>
                            <div class="input-container">
                                <i class="fa fa-envelope icon"></i>
                                <input type="email" name="gurd_email_id" id="gurd_email_id" 
                                       class="form-control" placeholder="Email" 
                                       value="{{ old('gurd_email_id') }}">
                            </div>
                        </div>
                    </div>

                    <!-- F. Other Information -->
                    <div style="padding: 20px; display: none;" class="grid" id="otherinformation">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">F. Other Information</h3>
                        </div>

                        <div>
                            <label for="bpl_status">BPL Status</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="bpl_status" id="bpl_status" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="bpl_no">BPL No.</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="bpl_no" id="bpl_no" 
                                       class="form-control" placeholder="BPL No" 
                                       value="{{ old('bpl_no') }}">
                            </div>
                        </div>

                        <div>
                            <label for="special_need">Children With Special Need</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="special_need" id="special_need" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="disability">Type Of Disability</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="disability" id="disability" 
                                       class="form-control" placeholder="Type Of Disability" 
                                       value="{{ old('disability') }}">
                            </div>
                        </div>
                    </div>

                    <!-- G. Facilities -->
                    <div style="padding: 20px; display: none;" class="grid" id="facilities">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">G. Facilities</h3>
                        </div>

                        <div>
                            <label for="disadvantage_group">Disadvantaged Group</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="disadvantage_group" id="disadvantage_group" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="free_education_rte">Getting free education as per RTE Act</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="free_education_rte" id="free_education_rte" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="child_is_homeless">Whether the child is Homeless</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="child_is_homeless" id="child_is_homeless" 
                                       class="form-control" placeholder="Whether the child is Homeless" 
                                       value="{{ old('child_is_homeless') }}">
                            </div>
                        </div>

                        <div>
                            <label for="uniform_received">No Of Uniform Sets Received</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="uniform_received" id="uniform_received" 
                                       class="form-control" placeholder="No Of Uniform Sets" 
                                       value="{{ old('uniform_received') }}">
                            </div>
                        </div>

                        <div>
                            <label for="free_books">Complete Set Of Free Books</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="free_books" id="free_books" 
                                       class="form-control" placeholder="Complete Set Of Free Books" 
                                       value="{{ old('free_books') }}">
                            </div>
                        </div>

                        <div>
                            <label for="transport_facility">Free Transport Facilities</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="transport_facility" id="transport_facility" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="escort_facility">Free Escort Facilities</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="escort_facility" id="escort_facility" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="hostel_facility">Free Hostel Facilities</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="hostel_facility" id="hostel_facility" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="hostel_type">Hostel Type</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="hostel_type" id="hostel_type" 
                                       class="form-control" placeholder="Hostel Type" 
                                       value="{{ old('hostel_type') }}">
                            </div>
                        </div>

                        <div>
                            <label for="hostel_schemes">Hostel Schemes</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="hostel_schemes" id="hostel_schemes" 
                                       class="form-control" placeholder="Hostel Schemes" 
                                       value="{{ old('hostel_schemes') }}">
                            </div>
                        </div>

                        <div>
                            <label for="special_training_facility">Special Training Facilities</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="special_training_facility" id="special_training_facility" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="remarks">Remarks</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="remarks" id="remarks" 
                                       class="form-control" placeholder="Remarks" 
                                       value="{{ old('remarks') }}">
                            </div>
                        </div>

                        <div>
                            <label for="cwsn_facility_receive">CWSN Facility Received</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <input type="text" name="cwsn_facility_receive" id="cwsn_facility_receive" 
                                       class="form-control" placeholder="CWSN Facility Received" 
                                       value="{{ old('cwsn_facility_receive') }}">
                            </div>
                        </div>

                        <div>
                            <label for="free_bicycle">Free Bicycle</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="free_bicycle" id="free_bicycle" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="free_shoe">Free Shoe</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="free_shoe" id="free_shoe" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="exercise_book">Free Exercise Book</label>
                            <div class="input-container">
                                <i class="fa fa-bars icon"></i>
                                <select name="exercise_book" id="exercise_book" class="form-control">
                                    <option value="">-Please Select-</option>
                                    <option value="yes">YES</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- H. Bank Details -->
                    <div style="padding: 20px; display: none;" class="grid" id="bankdetails">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">H. Bank Details</h3>
                        </div>

                        <div>
                            <label for="bank_name">Bank Name</label>
                            <div class="input-container">
                                <i class="fa fa-university icon"></i>
                                <input type="text" name="bank_name" id="bank_name" 
                                       class="form-control" placeholder="Bank Name" 
                                       value="{{ old('bank_name') }}">
                            </div>
                        </div>

                        <div>
                            <label for="branch_code">Branch Code</label>
                            <div class="input-container">
                                <i class="fa fa-university icon"></i>
                                <input type="text" name="branch_code" id="branch_code" 
                                       class="form-control" placeholder="Branch Code" 
                                       value="{{ old('branch_code') }}">
                            </div>
                        </div>

                        <div>
                            <label for="ifsc">IFSC Code</label>
                            <div class="input-container">
                                <i class="fa fa-university icon"></i>
                                <input type="text" name="ifsc" id="ifsc" 
                                       class="form-control" placeholder="IFSC Code" 
                                       value="{{ old('ifsc') }}">
                            </div>
                        </div>

                        <div>
                            <label for="account_no">Account Number</label>
                            <div class="input-container">
                                <i class="fa fa-university icon"></i>
                                <input type="text" name="account_no" id="account_no" 
                                       class="form-control" placeholder="Account Number" 
                                       value="{{ old('account_no') }}">
                            </div>
                        </div>
                    </div>

                    <!-- I. Upload Documents -->
                    <div style="padding: 20px; display: none;" class="grid" id="documentupload">
                        <div class="box-header with-border" style="background-color: #3c8dbc; color:white; grid-column: 1/-1;">
                            <h3 class="box-title">I. Upload Document</h3>
                        </div>

                        <div>
                            <label for="aadhar_picture">Upload Aadhaar</label>
                            <div class="input-container">
                                <input type="file" name="aadhar_picture" id="aadhar_picture" 
                                       accept="image/*" onchange="preview_image(event)" class="form-control">
                                <img id="output_image" width="250px" height="250px" style="margin-top: 10px; display: none;">
                            </div>
                        </div>

                        <div>
                            <label for="birth_certificate">Upload Birth Certificate</label>
                            <div class="input-container">
                                <input type="file" name="birth_certificate" id="birth_certificate" 
                                       onchange="preview_image_birth(event)" class="form-control">
                                <img id="output_image_birth" width="250px" height="250px" style="margin-top: 10px; display: none;">
                            </div>
                        </div>

                        <div>
                            <label for="tc_certificate">Upload T.C.</label>
                            <div class="input-container">
                                <input type="file" name="tc_certificate" id="tc_certificate" 
                                       onchange="preview_image_tc(event)" class="form-control">
                                <img id="output_image_tc" width="250px" height="250px" style="margin-top: 10px; display: none;">
                            </div>
                        </div>

                        <div>
                            <label for="social_certificate">Upload SC/ST/OBC Certificate</label>
                            <div class="input-container">
                                <input type="file" name="social_certificate" id="social_certificate" 
                                       onchange="preview_image_sc(event)" class="form-control">
                                <img id="output_image_sc" width="250px" height="250px" style="margin-top: 10px; display: none;">
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="nav-buttons">
                        <div class="nav-buttons-left">
                            <button type="button" id="prevBtn" onclick="showPrev()" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-left"></i> Show Prev
                            </button>
                            <button type="button" id="nextBtn" onclick="showNext()" class="btn btn-primary btn-sm">
                                Show Next <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                        <div class="nav-buttons-right">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-default btn-sm">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-save"></i> Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
let currentStep = 0;
const steps = [
    'basicinformation',
    'educationalinformation',
    'contactinformation',
    'gurdaindetails',
    'gurdaincontactinformation',
    'otherinformation',
    'facilities',
    'bankdetails',
    'documentupload'
];

function showStep(step) {
    // Hide all steps
    steps.forEach((s) => {
        const element = document.getElementById(s);
        if (element) {
            element.style.display = 'none';
        }
    });
    
    // Show current step
    const currentElement = document.getElementById(steps[step]);
    if (currentElement) {
        currentElement.style.display = 'grid';
    }
    
    currentStep = step;
    updateButtonStates();
}

function showNext() {
    if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
        window.scrollTo(0, 0);
    }
}

function showPrev() {
    if (currentStep > 0) {
        showStep(currentStep - 1);
        window.scrollTo(0, 0);
    }
}

function updateButtonStates() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    // Disable prev button on first step
    if (prevBtn) {
        prevBtn.disabled = currentStep === 0;
        prevBtn.style.opacity = currentStep === 0 ? '0.5' : '1';
    }
    
    // Change next button text on last step
    if (nextBtn) {
        if (currentStep === steps.length - 1) {
            nextBtn.style.display = 'none';
        } else {
            nextBtn.style.display = 'inline-block';
        }
    }
}

function previewFile(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function preview_image(event) {
    const output = document.getElementById('output_image');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display = 'block';
}

function preview_image_birth(event) {
    const output = document.getElementById('output_image_birth');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display = 'block';
}

function preview_image_tc(event) {
    const output = document.getElementById('output_image_tc');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display = 'block';
}

function preview_image_sc(event) {
    const output = document.getElementById('output_image_sc');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display = 'block';
}

// Initialize first step
document.addEventListener('DOMContentLoaded', function() {
    showStep(0);
    updateButtonStates();
});
</script>
@endsection
