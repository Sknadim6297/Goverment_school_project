@extends('admin.layouts.app')

@section('title', 'View Student')

@section('breadcrumb')
    <li class="breadcrumb-item">Student Management</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Manage Students</a></li>
    <li class="breadcrumb-item">View Student</li>
@endsection

@section('styles')
<style>
.details-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 12px; }
.details-item { background:#fff; border:1px solid #e5e5e5; border-radius:6px; padding:10px; }
.details-item h6 { margin:0 0 6px; font-weight:600; color:#333; }
.details-item p { margin:0; color:#555; }
.profile-wrap { display:flex; align-items:center; gap:16px; }
.profile-wrap img { width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ddd; }
.actions { display:flex; gap:8px; }
</style>
@endsection

@section('content')
<section class="content">
    <div class="content-box">
        <div class="box-header">
            <h3 class="box-title">Student Details</h3>
        </div>
        <div class="box-body">
            <div class="profile-wrap" style="margin-bottom: 16px;">
                @php
                    $photoUrl = $student->student_profile ? Storage::url($student->student_profile) : asset('admin/images/placeholder/user.png');
                @endphp
                <img src="{{ $photoUrl }}" alt="Profile" onerror="this.src='{{ asset('admin/images/placeholder/user.png') }}'">
                <div>
                    <h4 style="margin:0 0 4px;">{{ $student->name }}</h4>
                    <div style="color:#666">Admission No: {{ $student->admission_no ?? '—' }}</div>
                </div>
            </div>

            <div class="details-grid">
                <div class="details-item">
                    <h6>Basic</h6>
                    <p>Gender: {{ $student->gender ?? '—' }}</p>
                    <p>Date of Birth: {{ $student->dob ? $student->dob->format('Y-m-d') : '—' }}</p>
                    <p>Birth Regn No: {{ $student->birth_regn_no ?? '—' }}</p>
                    <p>Blood Group: {{ $student->blood_group ?? '—' }}</p>
                    <p>Religion: {{ $student->religion ?? '—' }}</p>
                    <p>Social Category: {{ $student->social_category ?? '—' }}</p>
                    <p>Identification Mark: {{ $student->identyfication_mark ?? '—' }}</p>
                </div>
                <div class="details-item">
                    <h6>Academic</h6>
                    <p>Academic Year: {{ $student->academic_year ?? '—' }}</p>
                    <p>Present Class: {{ $student->present_class ?? '—' }}</p>
                    <p>Section: {{ $student->present_section ?? '—' }}</p>
                    <p>Roll No: {{ $student->present_roll_no ?? '—' }}</p>
                    <p>Stream: {{ $student->present_streams ?? '—' }}</p>
                    <p>Medium: {{ $student->medium ?? '—' }}</p>
                </div>
                <div class="details-item">
                    <h6>Contact</h6>
                    <p>Mobile: {{ $student->contact_no ?? '—' }}</p>
                    <p>Email: {{ $student->email_id ?? '—' }}</p>
                    <p>Address: {{ $student->address ?? '—' }}</p>
                    <p>District: {{ $student->district ?? '—' }}</p>
                    <p>Block/Municipality: {{ $student->block_municipaity ?? '—' }}</p>
                    <p>Police Station: {{ $student->police_station ?? '—' }}</p>
                </div>
                <div class="details-item">
                    <h6>Guardian</h6>
                    <p>Father: {{ $student->father_name ?? '—' }}</p>
                    <p>Mother: {{ $student->mother_name ?? '—' }}</p>
                    <p>Guardian: {{ $student->gurdain_name ?? '—' }}</p>
                    <p>Relation: {{ $student->relation ?? '—' }}</p>
                    <p>Guardian Contact: {{ $student->gurd_contact_no ?? '—' }}</p>
                </div>
                <div class="details-item">
                    <h6>Identifiers</h6>
                    <p>Aadhaar: {{ $student->aadhar_no ?? '—' }}</p>
                    <p>Health ID: {{ $student->health_id ?? '—' }}</p>
                    <p>Nationality: {{ $student->nationality ?? '—' }}</p>
                    <p>Mother Tongue: {{ $student->mother_tongue ?? '—' }}</p>
                </div>
                <div class="details-item">
                    <h6>Bank</h6>
                    <p>Bank: {{ $student->bank_name ?? '—' }}</p>
                    <p>IFSC: {{ $student->ifsc ?? '—' }}</p>
                    <p>Account No: {{ $student->account_no ?? '—' }}</p>
                </div>
            </div>

            <div class="actions" style="margin-top:16px;">
                <a href="{{ route('admin.students.index') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                <a href="{{ route('admin.students.ledger', $student->id) }}" class="btn btn-info"><i class="fa fa-book"></i> View Ledger</a>
            </div>
        </div>
    </div>
</section>
@endsection
