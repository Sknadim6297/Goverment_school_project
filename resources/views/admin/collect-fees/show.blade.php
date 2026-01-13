@extends('admin.layouts.app')

@section('title', 'Collect Fees - ' . $student->name)

@section('breadcrumb')
    <li class="breadcrumb-item">Collect Fees</li>
    <li class="breadcrumb-item">{{ $student->name }}</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <!-- Student Information Card -->
        <div class="col-md-4">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Student Information</h3>
                </div>
                <div class="box-body">
                    <!-- Student Photo -->
                    @if($student->student_profile)
                        <img src="{{ asset('storage/' . $student->student_profile) }}" 
                             alt="Student Photo" style="width: 100%; border-radius: 5px; margin-bottom: 15px;">
                    @else
                        <div style="width: 100%; height: 200px; background-color: #f0f0f0; display: flex; 
                                   align-items: center; justify-content: center; border-radius: 5px; margin-bottom: 15px;">
                            <span>No Photo Available</span>
                        </div>
                    @endif

                    <!-- Student Details -->
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $student->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Student ID:</strong></td>
                            <td>{{ $student->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Admission No:</strong></td>
                            <td>{{ $student->admission_no ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Class:</strong></td>
                            <td>{{ $student->present_class ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>DOB:</strong></td>
                            <td>{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d-m-Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Gender:</strong></td>
                            <td>{{ $student->gender ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Contact:</strong></td>
                            <td>{{ $student->contact_no ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $student->email_id ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Fee Collection Form -->
        <div class="col-md-8">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Collect Fees</h3>
                </div>

                <form action="{{ route('admin.collect_fees.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <!-- Success/Error Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible" style="margin-bottom: 20px;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #155724; opacity: 0.8;">×</button>
                                <i class="fa fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible" style="margin-bottom: 20px;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #721c24; opacity: 0.8;">×</button>
                                <i class="fa fa-exclamation-circle"></i> Please correct the errors below
                            </div>
                        @endif

                        <!-- Hidden Student ID -->
                        <input type="hidden" name="student_id" value="{{ $student->id }}">

                        <!-- Amount -->
                        <div class="form-group">
                            <label for="amount">Amount <span style="color: red;">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" placeholder="Enter amount (in Rupees)" required 
                                   value="{{ old('amount') }}">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Payment Mode -->
                        <div class="form-group">
                            <label for="payment_mode">Payment Mode <span style="color: red;">*</span></label>
                            <select class="form-control @error('payment_mode') is-invalid @enderror" 
                                    id="payment_mode" name="payment_mode" required>
                                <option value="">-- Select Payment Mode --</option>
                                <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Check" {{ old('payment_mode') == 'Check' ? 'selected' : '' }}>Check</option>
                                <option value="Online Transfer" {{ old('payment_mode') == 'Online Transfer' ? 'selected' : '' }}>Online Transfer</option>
                                <option value="Debit Card" {{ old('payment_mode') == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                                <option value="Credit Card" {{ old('payment_mode') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                            </select>
                            @error('payment_mode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Transaction ID -->
                        <div class="form-group">
                            <label for="transaction_id">Transaction ID (Optional)</label>
                            <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" 
                                   id="transaction_id" name="transaction_id" placeholder="Enter transaction ID if applicable"
                                   value="{{ old('transaction_id') }}">
                            @error('transaction_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="form-group">
                            <label for="remarks">Remarks (Optional)</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" name="remarks" rows="3" 
                                      placeholder="Enter any remarks">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Submit Payment
                        </button>
                        <a href="{{ route('admin.collect_fees.index') }}" class="btn btn-default">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Payment History -->
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Payment History</h3>
                </div>
                <div class="box-body">
                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr style="background-color: #f4f4f4;">
                                        <th>#</th>
                                        <th>Receipt No</th>
                                        <th>Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Payment Date</th>
                                        <th>Transaction ID</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $key => $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $payment->receipt_no ?? 'N/A' }}</td>
                                            <td>₹ {{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->payment_mode ?? 'N/A' }}</td>
                                            <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') : 'N/A' }}</td>
                                            <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                            <td>{{ $payment->remarks ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Total Amount -->
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
                            <div class="row">
                                <div class="col-md-8 text-right">
                                    <strong style="font-size: 16px;">Total Amount Collected:</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong style="font-size: 18px; color: #27ae60;">₹ {{ number_format($payments->sum('amount'), 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No payments recorded yet
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
