<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
    <h1>Invoice #{{ $invoice->id }}</h1>
    <p>Driver Name: {{ $invoice->user->first_name . ' ' . $invoice->user->last_name }}</p>
    <p>Total Jobs: {{ $invoice->total_job }}</p>
    <p>Total Hours: {{ $invoice->total_hours }}</p>
    <p>Total Amount: ${{ number_format($invoice->total_amount, 2) }}</p>

    <h3>Job Details:</h3>
    <table  cellpadding="5">
        <thead>
            <tr>
                <th>Job ID</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Hours</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->start_time }}</td>
                <td>{{ $job->end_time }}</td>
                <td>{{ $job->total_minutes }}</td>
                <td>&#163;{{ number_format($job->total_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
