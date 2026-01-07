@extends('admin.layouts.app')

@section('title', 'Collect Fees')

@section('breadcrumb')
    <li class="breadcrumb-item">Dashboard</li>
    <li class="breadcrumb-item">Collect Fees</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Collect Fees</h3>
                </div>

                <div class="box-body">
                    <!-- Student Information Table -->
                    <table class="table table-bordered" style="margin-bottom: 20px;">
                        <thead>
                            <tr style="background-color: #f4f4f4;">
                                <th>Student Name</th>
                                <th>Admission Number</th>
                                <th>Present Class</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ strtoupper($admission->name) }}</td>
                                <td>{{ $admission->admission_no ?? '' }}</td>
                                <td>{{ $admission->class }} {{ $admission->stream ? '(' . $admission->stream . ')' : '' }}</td>
                                <td>{{ date('Y-m-d') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Fee Collection Form -->
                    <form action="{{ route('admin.admission.process_payment', $admission->id) }}" method="POST" id="feeForm">
                        @csrf
                        <input type="hidden" name="admission_id" value="{{ $admission->id }}">
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #f4f4f4;">
                                    <th width="10%">Sl No</th>
                                    <th width="50%">Particular</th>
                                    <th width="40%">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Development Fees*</td>
                                    <td>
                                        <input type="number" name="development_fees" id="development_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('development_fees', 240) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Registration Fees*</td>
                                    <td>
                                        <input type="number" name="registration_fees" id="registration_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('registration_fees', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Enrollment & Center Charge*</td>
                                    <td>
                                        <input type="number" name="enrollment_fees" id="enrollment_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('enrollment_fees', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Laboratory Fees* <small>(Lab One*)</small></td>
                                    <td>
                                        <input type="number" name="lab_one_fees" id="lab_one_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('lab_one_fees', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Laboratory Fees* <small>(Lab Two*)</small></td>
                                    <td>
                                        <input type="number" name="lab_two_fees" id="lab_two_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('lab_two_fees', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Laboratory Fees* <small>(Lab Three*)</small></td>
                                    <td>
                                        <input type="number" name="lab_three_fees" id="lab_three_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('lab_three_fees', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Laboratory Fees* <small>(Lab Four*)</small></td>
                                    <td>
                                        <input type="number" name="lab_four_fees" id="lab_four_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('lab_four_fees', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Miscellaneous*</td>
                                    <td>
                                        <input type="number" name="miscellaneous_fees" id="miscellaneous_fees" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('miscellaneous_fees', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Donation*</td>
                                    <td>
                                        <input type="number" name="donation" id="donation" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('donation', 0) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Concession*</td>
                                    <td>
                                        <input type="number" name="concession" id="concession" class="form-control fee-input" placeholder="0" min="0" step="0.01" value="{{ old('concession', 0) }}">
                                    </td>
                                </tr>
                                <tr style="background-color: #f9f9f9; font-weight: bold;">
                                    <td colspan="2" style="text-align: right; padding-right: 20px;">Total</td>
                                    <td>
                                        <input type="number" name="total_amount" id="total_amount" class="form-control" readonly value="0" style="font-weight: bold; background-color: #e9ecef;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right; padding-right: 20px; font-weight: bold;">Amount in Words</td>
                                    <td>
                                        <input type="text" name="amount_in_words" id="amount_in_words" class="form-control" readonly value="Rupees Zero Only" style="background-color: #e9ecef;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Payment Method Section -->
                        <div style="margin-top: 30px; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd;">
                            <h4 style="margin-bottom: 15px;">Payment Method</h4>
                            
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Payment Mode*</label>
                                <select name="payment_mode" id="payment_mode" class="form-control" required style="max-width: 400px;">
                                    <option value="">-Please Select-</option>
                                    <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="UPI" {{ old('payment_mode') == 'UPI' ? 'selected' : '' }}>UPI</option>
                                    <option value="Card" {{ old('payment_mode') == 'Card' ? 'selected' : '' }}>Card</option>
                                    <option value="Net Banking" {{ old('payment_mode') == 'Net Banking' ? 'selected' : '' }}>Net Banking</option>
                                    <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Transaction ID / Cheque No</label>
                                <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="Enter Transaction ID or Cheque Number" value="{{ old('transaction_id') }}" style="max-width: 400px;">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 0;">
                                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control" rows="2" placeholder="Enter any remarks" style="max-width: 400px;">{{ old('remarks') }}</textarea>
                            </div>
                        </div>

                        <div class="box-footer" style="margin-top: 20px;">
                            <a href="{{ route('admin.admission.index') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success pull-right">
                                <i class="fa fa-check"></i> Submit & Generate Receipt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Calculate total when any fee input changes
    document.querySelectorAll('.fee-input').forEach(function(input) {
        input.addEventListener('input', calculateTotal);
    });

    function calculateTotal() {
        let total = 0;
        
        // Sum all fee inputs
        document.querySelectorAll('.fee-input').forEach(function(input) {
            let value = parseFloat(input.value) || 0;
            total += value;
        });

        // Subtract concession
        let concession = parseFloat(document.getElementById('concession').value) || 0;
        total -= concession;

        // Update total field
        document.getElementById('total_amount').value = total.toFixed(2);

        // Convert to words
        document.getElementById('amount_in_words').value = numberToWords(total);
    }

    function numberToWords(amount) {
        if (amount === 0) return 'Rupees Zero Only';

        const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

        function convertLessThanThousand(n) {
            if (n === 0) return '';
            
            let result = '';
            
            if (n >= 100) {
                result += ones[Math.floor(n / 100)] + ' Hundred ';
                n %= 100;
            }
            
            if (n >= 20) {
                result += tens[Math.floor(n / 10)] + ' ';
                n %= 10;
            } else if (n >= 10) {
                result += teens[n - 10] + ' ';
                return result;
            }
            
            if (n > 0) {
                result += ones[n] + ' ';
            }
            
            return result;
        }

        let rupees = Math.floor(amount);
        let paisa = Math.round((amount - rupees) * 100);

        let result = 'Rupees ';

        if (rupees >= 10000000) {
            result += convertLessThanThousand(Math.floor(rupees / 10000000)) + 'Crore ';
            rupees %= 10000000;
        }

        if (rupees >= 100000) {
            result += convertLessThanThousand(Math.floor(rupees / 100000)) + 'Lakh ';
            rupees %= 100000;
        }

        if (rupees >= 1000) {
            result += convertLessThanThousand(Math.floor(rupees / 1000)) + 'Thousand ';
            rupees %= 1000;
        }

        if (rupees > 0) {
            result += convertLessThanThousand(rupees);
        }

        if (paisa > 0) {
            result += 'and Paisa ' + convertLessThanThousand(paisa);
        }

        return result.trim() + ' Only';
    }

    // Initialize calculation on page load
    calculateTotal();
</script>
@endpush

@push('styles')
<style>
    .pull-right {
        float: right;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd;
        padding: 10px;
    }
    .table-bordered thead tr {
        background-color: #f4f4f4;
    }
    .fee-input {
        width: 100%;
        text-align: right;
    }
    .box-footer {
        padding: 15px;
        background-color: #f9f9f9;
        border-top: 1px solid #ddd;
    }
</style>
@endpush
