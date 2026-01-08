<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Admissions</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin: 0 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Admissions</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Class</th>
                <th>Stream</th>
                <th>Guardian</th>
                <th>Mobile</th>
                <th>Admission No</th>
                <th>Admission Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ strtoupper($r->name) }}</td>
                <td>{{ $r->class }}</td>
                <td>{{ $r->stream }}</td>
                <td>{{ $r->guardian_name }}</td>
                <td>{{ $r->mobile_number }}</td>
                <td>{{ $r->admission_no }}</td>
                <td>{{ optional($r->admission_date)->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
