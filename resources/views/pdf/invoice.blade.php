<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 10px;
            background-color: #00846F;
            color: #ffffff;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f1f1f1;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 12px;
        }
        .content {
            margin-bottom: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        .totals p {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <h1>Invoice #{{ $invoice->id }}</h1>
            <p>Generated on: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        </div>

        <!-- Invoice Details -->
        <div class="content">
            <p><strong>Driver Name:</strong> {{ $invoice->user->first_name . ' ' . $invoice->user->last_name }}</p>
            <p><strong>Total Jobs:</strong> {{ $invoice->total_job }}</p>
            <p><strong>Total Hours:</strong> {{ $invoice->total_hours }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($invoice->total_amount, 2) }}</p>

            <!-- Job Details -->
            <h3>Job Details:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Job ID</th>
                        <th>Job Title</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Hourly Pay</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>{{ $job->job_department_title?->job_title ?? 'N/A' }}</td>
                        <td>{{ $job->start_time }}</td>
                        <td>{{ $job->end_time }}</td>
                        <td>&#163;{{ $job->hourly_pay }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total Summary -->
            <!-- <div class="totals">
                <p>Total Jobs: {{ count($jobs) }}</p>
                <p>Total Amount: &#163;{{ number_format($jobs->sum('total_amount'), 2) }}</p>
            </div> -->
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} Your HATS. All Rights Reserved.</p>
    </div>
</body>
</html>
