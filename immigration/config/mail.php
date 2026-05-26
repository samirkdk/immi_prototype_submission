<?php
// ─────────────────────────────────────────────
// EMAIL CONFIGURATION — PHPMailer + SMTP
// ─────────────────────────────────────────────
// Options: 'gmail', 'smtp' (custom), 'sendgrid'
define('MAIL_DRIVER', getenv('MAIL_DRIVER') ?: 'gmail');

// Gmail SMTP (recommended for development)
// Enable "App Passwords" in your Google account
// https://support.google.com/accounts/answer/185833
define('MAIL_HOST', getenv('MAIL_HOST') ?: 'smtp.gmail.com');
define('MAIL_PORT', getenv('MAIL_PORT') ?: 587);
define('MAIL_USERNAME', getenv('MAIL_USERNAME') ?: '');
define('MAIL_PASSWORD', getenv('MAIL_PASSWORD') ?: '');
define('MAIL_ENCRYPTION', getenv('MAIL_ENCRYPTION') ?: 'tls');
define('MAIL_FROM_ADDRESS', getenv('MAIL_FROM_ADDRESS') ?: 'noreply@immigration.gov.np');
define('MAIL_FROM_NAME', getenv('MAIL_FROM_NAME') ?: 'Department of Immigration, Nepal');

// ─────────────────────────────────────────────
// SMS CONFIGURATION (Twilio)
// Sign up at https://www.twilio.com
// ─────────────────────────────────────────────
define('TWILIO_SID', getenv('TWILIO_SID') ?: '');
define('TWILIO_TOKEN', getenv('TWILIO_TOKEN') ?: '');
define('TWILIO_FROM', getenv('TWILIO_FROM') ?: '');

// ─────────────────────────────────────────────
// FEATURE FLAGS
// Set to false to disable during development
// ─────────────────────────────────────────────
define('SEND_EMAIL', filter_var(getenv('SEND_EMAIL'), FILTER_VALIDATE_BOOLEAN));
define('SEND_SMS', filter_var(getenv('SEND_SMS'), FILTER_VALIDATE_BOOLEAN));
