<!DOCTYPE html>
<html>
<head>
    <title>Fee Receipt - {{ $admission->admission_no }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 20px;
            color: #666;
            font-weight: normal;
        }
        
        .header p {
            color: #888;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        
        .receipt-info div {
            flex: 1;
        }
        
        .receipt-info strong {
            display: block;
            color: #333;
            margin-bottom: 5px;
        }
        
        .student-details {
            margin-bottom: 20px;
        }
        
        .student-details table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .student-details th,
        .student-details td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .student-details th {
            background-color: #f4f4f4;
            font-weight: bold;
            width: 35%;
        }
        
        .fee-details {
            margin-bottom: 20px;
        }
        
        .fee-details table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .fee-details th,
        .fee-details td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .fee-details th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }
        
        .fee-details td {
            text-align: left;
        }
        
        .fee-details td.amount {
            text-align: right;
        }
        
        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
            font-size: 16px;
        }
        
        .amount-words {
            margin: 20px 0;
            padding: 15px;
            background-color: #fffbcc;
            border: 1px solid #e6db55;
            border-radius: 4px;
        }
        
        .amount-words strong {
            color: #333;
        }
        
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }
        
        .signature {
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
        
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        
        .print-button button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .print-button button:hover {
            background-color: #45a049;
        }
        
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            
            .print-button {
                display: none;
            }
            
            .receipt-container {
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>GOVERNMENT SCHOOL</h1>
            <h2>Fee Receipt</h2>
            <p>Address Line 1, Address Line 2 | Phone: (123) 456-7890</p>
        </div>
        
        <!-- Receipt Info -->
        <div class="receipt-info">
            <div>
                <strong>Receipt No:</strong>
                {{ $payment->receipt_no ?? 'RCP' . date('Y') . str_pad($admission->id, 5, '0', STR_PAD_LEFT) }}
            </div>
            <div>
                <strong>Date:</strong>
                {{ date('d-M-Y') }}
            </div>
            <div>
                <strong>Payment Status:</strong>
                <span style="color: green; font-weight: bold;">PAID</span>
            </div>
        </div>
        
        <!-- Student Details -->
        <div class="student-details">
            <table>
                <tr>
                    <th>Student Name</th>
                    <td>{{ strtoupper($admission->name) }}</td>
                </tr>
                <tr>
                    <th>Admission Number</th>
                    <td>{{ $admission->admission_no }}</td>
                </tr>
                <tr>
                    <th>Class</th>
                    <td>{{ $admission->class }} {{ $admission->stream ? '(' . $admission->stream . ')' : '' }}</td>
                </tr>
                <tr>
                    <th>Guardian Name</th>
                    <td>{{ $admission->guardian_name }}</td>
                </tr>
                <tr>
                    <th>Mobile Number</th>
                    <td>{{ $admission->mobile_number }}</td>
                </tr>
                @if(isset($payment->payment_mode))
                <tr>
                    <th>Payment Mode</th>
                    <td><strong>{{ $payment->payment_mode }}</strong></td>
                </tr>
                @endif
                @if(isset($payment->transaction_id) && $payment->transaction_id)
                <tr>
                    <th>Transaction ID / Cheque No</th>
                    <td>{{ $payment->transaction_id }}</td>
                </tr>
                @endif
                @if(isset($payment->remarks) && $payment->remarks)
                <tr>
                    <th>Remarks</th>
                    <td>{{ $payment->remarks }}</td>
                </tr>
                @endif
            </table>
        </div>
        
        <!-- Fee Details -->
        <div class="fee-details">
            <table>
                <thead>
                    <tr>
                        <th width="10%">Sl No</th>
                        <th width="60%">Particular</th>
                        <th width="30%">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $fees = [
                            'Development Fees' => $payment->development_fees ?? 0,
                            'Registration Fees' => $payment->registration_fees ?? 0,
                            'Enrollment & Center Charge' => $payment->enrollment_fees ?? 0,
                            'Laboratory Fees (Lab One)' => $payment->lab_one_fees ?? 0,
                            'Laboratory Fees (Lab Two)' => $payment->lab_two_fees ?? 0,
                            'Laboratory Fees (Lab Three)' => $payment->lab_three_fees ?? 0,
                            'Laboratory Fees (Lab Four)' => $payment->lab_four_fees ?? 0,
                            'Miscellaneous' => $payment->miscellaneous_fees ?? 0,
                            'Donation' => $payment->donation ?? 0,
                        ];
                        $concession = $payment->concession ?? 0;
                    @endphp
                    
                    @foreach($fees as $index => $item)
                        @if($item > 0)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $index }}</td>
                                <td class="amount">{{ number_format($item, 2) }}</td>
                            </tr>
                            @php $total += $item; @endphp
                        @endif
                    @endforeach
                    
                    @if($concession > 0)
                        <tr>
                            <td>{{ count(array_filter($fees)) + 1 }}</td>
                            <td>Concession</td>
                            <td class="amount" style="color: red;">-{{ number_format($concession, 2) }}</td>
                        </tr>
                        @php $total -= $concession; @endphp
                    @endif
                    
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right; padding-right: 20px;">TOTAL</td>
                        <td class="amount">₹ {{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Amount in Words -->
        <div class="amount-words">
            <strong>Amount in Words:</strong>
            {{ $payment->amount_in_words ?? 'Rupees ' . ucwords(numberToWords($total)) . ' Only' }}
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="signature">
                <div class="signature-line">Received By</div>
            </div>
            <div class="signature">
                <div class="signature-line">Authorized Signature</div>
            </div>
        </div>
        
        <p style="margin-top: 30px; text-align: center; color: #666; font-size: 12px;">
            This is a computer-generated receipt and does not require a signature.<br>
            Please preserve this receipt for future reference.
        </p>
    </div>
    
    <!-- Print Button -->
    <div class="print-button">
        <button onclick="window.print()">Print Receipt</button>
        <button onclick="window.close()" style="background-color: #f44336; margin-left: 10px;">Close</button>
    </div>
</body>
</html>

@php
function numberToWords($number) {
    $ones = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
    $tens = array('', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');
    $teens = array('Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen');
    
    $rupees = floor($number);
    $paisa = round(($number - $rupees) * 100);
    
    $result = '';
    
    if ($rupees >= 10000000) {
        $crore = floor($rupees / 10000000);
        $result .= numberToWordsHelper($crore, $ones, $tens, $teens) . 'Crore ';
        $rupees %= 10000000;
    }
    
    if ($rupees >= 100000) {
        $lakh = floor($rupees / 100000);
        $result .= numberToWordsHelper($lakh, $ones, $tens, $teens) . 'Lakh ';
        $rupees %= 100000;
    }
    
    if ($rupees >= 1000) {
        $thousand = floor($rupees / 1000);
        $result .= numberToWordsHelper($thousand, $ones, $tens, $teens) . 'Thousand ';
        $rupees %= 1000;
    }
    
    if ($rupees > 0) {
        $result .= numberToWordsHelper($rupees, $ones, $tens, $teens);
    }
    
    if ($paisa > 0) {
        $result .= 'and Paisa ' . numberToWordsHelper($paisa, $ones, $tens, $teens);
    }
    
    return trim($result);
}

function numberToWordsHelper($n, $ones, $tens, $teens) {
    $result = '';
    
    if ($n >= 100) {
        $result .= $ones[floor($n / 100)] . ' Hundred ';
        $n %= 100;
    }
    
    if ($n >= 20) {
        $result .= $tens[floor($n / 10)] . ' ';
        $n %= 10;
    } elseif ($n >= 10) {
        $result .= $teens[$n - 10] . ' ';
        return $result;
    }
    
    if ($n > 0) {
        $result .= $ones[$n] . ' ';
    }
    
    return $result;
}
@endphp
