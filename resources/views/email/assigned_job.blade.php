<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #00846F;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            margin: 0 0 15px;
            line-height: 1.6;
        }
        .email-body .highlight {
            font-weight: bold;
            color: #00846F;
        }
        .email-footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #666;
        }
        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Job Won</h1>
        </div>
        <div class="email-body">
            <!-- <p>Dear <span class="highlight">[Customer Name]</span>,</p> -->
            <p>You have been assigned a job from HATS. Please find the details below:</p>
            <p><strong>Job Title:</strong> {{ $jobData->job_department_title?->job_title }}</p>
            <p><strong>Job Location:</strong> {{ $jobData->location->name }}</p>
            <p><strong>Job Start Date Time:</strong> {{ $jobData->start_date->format('d-m-Y')  }} {{ $jobData->start_time }}</p>
            <p><strong>Job End Date Time:</strong> {{ $jobData->end_date->format('d-m-Y') }}  {{ $jobData->end_time }}</p>
            <p><strong>Job Hourly Pay:</strong> {{ $jobData->hourly_pay }}</p>
            <p><strong>Job Description:</strong> {{ $jobData->description }}</p>
           
            <If>If you have any questions, please don't hesitate to contact us.</p>
            <p>Thank you for choosing our services!</p>
            <p>Best regards,</p>
            <p><strong>Your HATS</strong></p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your HATS. All rights reserved.</p>
            <!-- <p>
                <a href="[Company Website]">Visit our website</a> |
                <a href="[Unsubscribe Link]">Unsubscribe</a>
            </p> -->
        </div>
    </div>
</body>
</html>
