<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Job Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
        }
        .field {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-left: 4px solid #10b981;
        }
        .field-label {
            font-weight: bold;
            color: #10b981;
            margin-bottom: 5px;
        }
        .cover-letter {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #10b981;
            margin: 20px 0;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .resume-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 10px;
            border-radius: 4px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Job Application Received</h1>
            <p>A new candidate has applied for a position at your company.</p>
        </div>

        <div class="field">
            <div class="field-label">Applicant Name:</div>
            <div>{{ $first_name }} {{ $last_name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email Address:</div>
            <div>{{ $email }}</div>
        </div>

        <div class="field">
            <div class="field-label">Phone Number:</div>
            <div>{{ $phone }}</div>
        </div>

        <div class="field">
            <div class="field-label">Position Applied For:</div>
            <div>{{ ucwords(str_replace('-', ' ', $position)) }}</div>
        </div>

        <div class="field">
            <div class="field-label">Years of Experience:</div>
            <div>{{ $experience }}</div>
        </div>

        <div class="field">
            <div class="field-label">Availability:</div>
            <div>{{ ucwords(str_replace('-', ' ', $availability)) }}</div>
        </div>

        @if($has_resume)
        <div class="resume-note">
            <strong>📎 Resume Attached</strong><br>
            The applicant's resume has been attached to this email.
        </div>
        @endif

        @if($cover_letter && $cover_letter !== 'No cover letter provided')
        <div>
            <div class="field-label">Cover Letter:</div>
            <div class="cover-letter">{{ $cover_letter }}</div>
        </div>
        @endif

        <div class="footer">
            <p>This application was submitted through your career page.</p>
            <p>Please review the application and respond to the candidate within 5 business days.</p>
        </div>
    </div>
</body>
</html>
