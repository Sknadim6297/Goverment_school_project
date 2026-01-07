@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
@endsection

@section('content')
<div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Statistics Cards -->
    <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 32px; font-weight: 700;">{{ \App\Models\Admission::count() }}</h3>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Admissions</p>
            </div>
            <i class="fa fa-graduation-cap" style="font-size: 50px; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 32px; font-weight: 700;">{{ \App\Models\ComputerAdmission::count() }}</h3>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Computer Admissions</p>
            </div>
            <i class="fa fa-desktop" style="font-size: 50px; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 32px; font-weight: 700;">{{ \App\Models\SaraswatiPujaFee::count() }}</h3>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Saraswati Puja Fees</p>
            </div>
            <i class="fa fa-hands-praying" style="font-size: 50px; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0; font-size: 32px; font-weight: 700;">₹{{ number_format(\App\Models\Payment::sum('amount'), 2) }}</h3>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Collection</p>
            </div>
            <i class="fa fa-indian-rupee-sign" style="font-size: 50px; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<div class="content-box" style="margin-top: 30px;">
    <div class="box-header">
        <h3 class="box-title">Recent Admissions</h3>
    </div>
    <div class="box-body">
        <table class="data-table" style="width: 100%;">
            <thead>
                <tr>
                    <th>Admission No.</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Guardian Name</th>
                    <th>Mobile</th>
                    <th>Admission Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Admission::latest()->take(10)->get() as $admission)
                <tr>
                    <td>{{ $admission->admission_no }}</td>
                    <td>{{ $admission->name }}</td>
                    <td>{{ $admission->class }}</td>
                    <td>{{ $admission->guardian_name }}</td>
                    <td>{{ $admission->mobile_number }}</td>
                    <td>{{ $admission->admission_date->format('d-m-Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">No admissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
