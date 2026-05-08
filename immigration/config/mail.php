<?php
// ─────────────────────────────────────────────
// EMAIL CONFIGURATION — PHPMailer + SMTP
// ─────────────────────────────────────────────
// Options: 'gmail', 'smtp' (custom), 'sendgrid'
define('MAIL_DRIVER', 'gmail');

// Gmail SMTP (recommended for development)
// Enable "App Passwords" in your Google account
// https://support.google.com/accounts/answer/185833
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');       // Your Gmail address
define('MAIL_PASSWORD', '');           // Gmail App Password (not account password)
define('MAIL_ENCRYPTION', 'tls');
define('MAIL_FROM_ADDRESS', 'noreply@immigration.gov.np');
define('MAIL_FROM_NAME', 'Department of Immigration, Nepal');

// ─────────────────────────────────────────────
// SMS CONFIGURATION (Twilio)
// Sign up at https://www.twilio.com
// ─────────────────────────────────────────────
define('TWILIO_SID', 'ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('TWILIO_TOKEN', 'your-twilio-auth-token');
define('TWILIO_FROM', ''); // Your Twilio phone number

// ─────────────────────────────────────────────
// FEATURE FLAGS
// Set to false to disable during development
// ─────────────────────────────────────────────
define('SEND_EMAIL', false);
define('SEND_SMS', false);
