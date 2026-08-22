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
            <div>{{ $name }}</div>
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
            <div class="field-label">Service Requested:</div>
            <div>{{ ucwords(str_replace('-', ' ', $service)) }}</div>
        </div>

        <div class="field">
            <div class="field-label">Property Type:</div>
            <div>{{ ucwords($property_type) }}</div>
        </div>

        <div class="field">
            <div class="field-label">Cleaning Frequency:</div>
            <div>{{ ucwords($frequency) }}</div>
        </div>

        <div class="field">
            <div class="field-label">Number of Bedrooms:</div>
            <div>{{ $bedrooms }}</div>
        </div>

        <div class="field">
            <div class="field-label">Number of Bathrooms:</div>
            <div>{{ $bathrooms }}</div>
        </div>

        @if($message && $message !== 'No additional message')
        <div class="field">
            <div class="field-label">Additional Message:</div>
            <div>{{ $message }}</div>
        </div>
        @endif

        <div class="footer">
            <p>This email was sent from your cleaning service website contact form.</p>
            <p>Please respond to the customer within 24 hours for the best service experience.</p>
        </div>
    </div>
</body>
</html>
