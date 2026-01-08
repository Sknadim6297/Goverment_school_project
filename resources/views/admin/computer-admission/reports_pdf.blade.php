<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Computer Admission Reports</title>
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
    <h2>Computer Admission Reports</h2>
    <div class="meta">
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
                <th>Course</th>
                <th class="right">Course Fee</th>
                <th class="right">Paid</th>
                <th class="right">Due</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ strtoupper($r->admission->name) }}</td>
                <td>{{ $r->admission->admission_no }}</td>
                <td>{{ $r->admission->class }}</td>
                <td>{{ $r->course_name }}</td>
                <td class="right">{{ number_format($r->course_fee, 2) }}</td>
                <td class="right">{{ number_format($r->paid_amount, 2) }}</td>
                <td class="right">{{ number_format($r->course_fee - $r->paid_amount, 2) }}</td>
                <td>{{ strtoupper($r->payment_status) }}</td>
                <td>{{ optional($r->enrollment_date)->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="right">Totals</td>
                <td class="right">{{ number_format($totals['fee'], 2) }}</td>
                <td class="right">{{ number_format($totals['paid'], 2) }}</td>
                <td class="right">{{ number_format($totals['fee'] - $totals['paid'], 2) }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
