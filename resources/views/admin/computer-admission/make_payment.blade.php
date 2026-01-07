@extends('admin.layouts.app')

@section('title', 'Make Payment - Computer Admission')

@section('breadcrumb')
    <li class="breadcrumb-item">Computer Admission</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.computer_admission.index') }}">Manage</a></li>
    <li class="breadcrumb-item">Make Payment</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="content-box">
                <div class="box-header">
                    <h3 class="box-title">Computer Admission Payment</h3>
                </div>

                <form class="form-horizontal" action="{{ route('admin.computer_admission.process_payment', $computerAdmission->id) }}" method="post">
                    @csrf
                    
                    <div class="box-body">
                        <!-- Student Info Table -->
                        <table class="table table-bordered" style="margin-bottom: 20px;">
                            <tr>
                                <th>Student Name</th>
                                <th>Admission Number</th>
                                <th>Present Class</th>
                                <th>Section</th>
                                <th>Date</th>
                            </tr>
                            <tr>
                                <td>{{ $computerAdmission->admission->name }}</td>
                                <td>{{ $computerAdmission->admission->admission_no }}</td>
                                <td>{{ $computerAdmission->admission->class }}</td>
                                <td>{{ $computerAdmission->admission->section ?? 'N/A' }}</td>
                                <td>{{ date('Y-m-d') }}</td>
                            </tr>
                        </table>

                        <!-- Fee Breakdown -->
                        <table class="table table-bordered" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Particular</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Computer Fees*</td>
                                    <td>
                                        <input type="number" name="computer_fees" id="computer_fees" class="form-control" min="0" step="0.01" value="{{ old('computer_fees', 0) }}" oninput="calculateTotal()">
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Book Fees*</td>
                                    <td>
                                        <input type="number" name="book_fees" id="book_fees" class="form-control" min="0" step="0.01" value="{{ old('book_fees', 0) }}" oninput="calculateTotal()">
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Miscellaneous*</td>
                                    <td>
                                        <input type="number" name="miscellaneous" id="miscellaneous" class="form-control" min="0" step="0.01" value="{{ old('miscellaneous', 0) }}" oninput="calculateTotal()">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align:right;">Total</th>
                                    <th><span id="total_amount">0.00</span></th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:right;"><strong>Amount in Words</strong></td>
                                    <td id="amount_in_words">Rupees Zero</td>
                                </tr>
                            </tbody>
                        </table>

                        <input type="hidden" name="payment_amount" id="payment_amount">

                        <div class="form-group">
                            <label for="payment_date" class="col-sm-2 control-label required-field">Payment Date</label>
                            <div class="col-sm-4">
                                <input type="date" name="payment_date" id="payment_date" class="form-control" required value="{{ old('payment_date', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_mode" class="col-sm-2 control-label required-field">Payment Mode</label>
                            <div class="col-sm-4">
                                <select name="payment_mode" id="payment_mode" class="form-control" required>
                                    <option value="">-Please Select-</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="online" {{ old('payment_mode') == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remarks" class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-4">
                                <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter any remarks">{{ old('remarks') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="{{ route('admin.computer_admission.index') }}" class="btn btn-danger">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success pull-right">
                            <i class="fa fa-money"></i> Process Payment
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
    .help-block {
        color: #666;
        font-size: 12px;
        margin-top: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
function calculateTotal() {
    const computerFees = parseFloat(document.getElementById('computer_fees').value) || 0;
    const bookFees = parseFloat(document.getElementById('book_fees').value) || 0;
    const miscellaneous = parseFloat(document.getElementById('miscellaneous').value) || 0;
    
    const total = computerFees + bookFees + miscellaneous;
    
    document.getElementById('total_amount').textContent = total.toFixed(2);
    document.getElementById('payment_amount').value = total.toFixed(2);
    document.getElementById('amount_in_words').textContent = numberToWords(total);
}

function numberToWords(amount) {
    if (amount === 0) return 'Rupees Zero';
    
    const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
    const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    const teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
    
    function convertLessThanThousand(num) {
        if (num === 0) return '';
        
        let result = '';
        
        if (num >= 100) {
            result += ones[Math.floor(num / 100)] + ' Hundred ';
            num %= 100;
        }
        
        if (num >= 20) {
            result += tens[Math.floor(num / 10)] + ' ';
            num %= 10;
        } else if (num >= 10) {
            result += teens[num - 10] + ' ';
            return result;
        }
        
        if (num > 0) {
            result += ones[num] + ' ';
        }
        
        return result;
    }
    
    const rupees = Math.floor(amount);
    const paise = Math.round((amount - rupees) * 100);
    
    let words = 'Rupees ';
    
    if (rupees >= 10000000) {
        words += convertLessThanThousand(Math.floor(rupees / 10000000)) + 'Crore ';
        rupees %= 10000000;
    }
    
    if (rupees >= 100000) {
        words += convertLessThanThousand(Math.floor(rupees / 100000)) + 'Lakh ';
        rupees %= 100000;
    }
    
    if (rupees >= 1000) {
        words += convertLessThanThousand(Math.floor(rupees / 1000)) + 'Thousand ';
        rupees %= 1000;
    }
    
    if (rupees > 0) {
        words += convertLessThanThousand(rupees);
    }
    
    if (paise > 0) {
        words += 'and ' + convertLessThanThousand(paise) + 'Paise ';
    }
    
    return words.trim() + ' Only';
}

// Calculate on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endpush
