<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <style>
      body { font-family: Arial, sans-serif; background: #f6f6f6; padding: 20px; }
      .email-container { max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
      .header { font-size: 22px; margin-bottom: 20px; color: #333; }
      .info { margin-bottom: 10px; }
      .info strong { display: inline-block; width: 80px; }
      .footer { margin-top: 30px; font-size: 13px; color: #888; }
   </style>
</head>
<body>
<div class="email-container">
   <div class="header">New Contact Form Submission</div>

   <div class="info"><strong>Name:</strong> {{ $details['name'] }}</div>
   <div class="info"><strong>Email:</strong> {{ $details['email'] }}</div>
   <div class="info"><strong>Subject:</strong> {{ $details['subject'] }}</div>
   <div class="info"><strong>Message:</strong> {{ $details['comments'] }}</div>

   <div class="footer">
      This message was sent from your website contact form.
   </div>
</div>
</body>
</html>
