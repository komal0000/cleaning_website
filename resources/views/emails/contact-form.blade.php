<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
        }
        .field {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
        }
        .field-label {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Submission</h1>
            <p>You have received a new contact form submission from your website.</p>
        </div>

        <div class="field">
            <div class="field-label">Customer Name:</div>
            <div>{{ $contact->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email Address:</div>
            <div>{{ $contact->email }}</div>
        </div>

        <div class="field">
            <div class="field-label">Phone Number:</div>
            <div>{{ $contact->phone }}</div>
        </div>

        <div class="field">
            <div class="field-label">Service Requested:</div>
            <div>{{ ucwords(str_replace('-', ' ', $contact->service)) }}</div>
        </div>

        @if($contact->message && $contact->message !== 'No additional message' && $contact->message !== '')
        <div class="field">
            <div class="field-label">Additional Message:</div>
            <div>{{ $contact->message }}</div>
        </div>
        @endif

        <div class="footer">
            @if(config('app.env') === 'local')
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                <strong>🧪 TEST ENVIRONMENT</strong><br>
                This email was sent from the local development environment.
            </div>
            @endif
            <p>This email was sent from your cleaning service website contact form.</p>
            <p>Please review the request and respond using the team's current service process.</p>
        </div>
    </div>
</body>
</html>
