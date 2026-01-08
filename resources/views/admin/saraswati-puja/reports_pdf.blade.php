<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Saraswati Puja Fee Reports</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin: 0 0 8px; }
        .meta { font-size: 11px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f2f2f2; }
        tfoot td { font-weight: bold; background: #f9f9f9; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <h2>Saraswati Puja Fee Reports</h2>
    <div class="meta">
        @if($filters['year']) Year: {{ $filters['year'] }} @endif
        @if($filters['date_from']) From: {{ $filters['date_from'] }} @endif
        @if($filters['date_to']) &nbsp;&nbsp; To: {{ $filters['date_to'] }} @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Adm No</th>
                <th>Class</th>
                <th>Year</th>
                <th class="right">Fee Amount</th>
                <th>Receipt No</th>
                <th>Date</th>
                <th>Mode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ strtoupper($r->admission->name) }}</td>
                <td>{{ $r->admission->admission_no }}</td>
                <td>{{ $r->admission->class }}</td>
                <td>{{ $r->year }}</td>
                <td class="right">{{ number_format($r->fee_amount, 2) }}</td>
                <td>{{ $r->receipt_no }}</td>
                <td>{{ optional($r->payment_date)->format('Y-m-d') }}</td>
                <td>{{ strtoupper($r->payment_mode) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="right">Total Collection</td>
                <td class="right">{{ number_format($totalAmount, 2) }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
