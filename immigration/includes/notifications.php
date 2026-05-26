<?php
require_once __DIR__ . '/../config/mail.php';
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
$vendorLoaded = false;
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
    $vendorLoaded = true;
} else {
    error_log("Composer autoload not found at: {$autoloadPath}. Email/SMS providers that require vendor packages are disabled.");
}
$GLOBALS['vendorLoaded'] = $vendorLoaded;

use PHPMailer\PHPMailer\PHPMailer;

function applySmtpSecurity(PHPMailer $mail): void {
    $encryption = strtolower((string) MAIL_ENCRYPTION);
    if ($encryption === 'tls') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    } elseif ($encryption === 'ssl') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } else {
        $mail->SMTPSecure = false;
    }
}

// ─────────────────────────────────────────────
// SEND CONFIRMATION EMAIL
// Called after successful application submission
// ─────────────────────────────────────────────
function sendConfirmationEmail(array $application): bool {
    if (!SEND_EMAIL) return true;
    if (!$GLOBALS['vendorLoaded'] || !class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        error_log('Skipping confirmation email: PHPMailer dependency is not available.');
        return false;
    }

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        applySmtpSecurity($mail);
        $mail->Port       = MAIL_PORT;
        $mail->CharSet    = 'UTF-8';

        // Recipients
        $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $mail->addAddress($application['email'], $application['full_name']);
        $mail->addReplyTo('info@immigration.gov.np', 'Department of Immigration');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Visa Application Received — ' . $application['reference_number'];
        $mail->Body    = buildConfirmationEmailHTML($application);
        $mail->AltBody = buildConfirmationEmailText($application);

        $mail->send();
        return true;
    } catch (\Throwable $e) {
        error_log('Email send failed: ' . $mail->ErrorInfo . ' | ' . $e->getMessage());
        return false;
    }
}

// ─────────────────────────────────────────────
// SEND STATUS UPDATE EMAIL
// Called when admin changes application status
// ─────────────────────────────────────────────
function sendStatusUpdateEmail(array $application): bool {
    if (!SEND_EMAIL) return true;
    if (!$GLOBALS['vendorLoaded'] || !class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        error_log('Skipping status update email: PHPMailer dependency is not available.');
        return false;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        applySmtpSecurity($mail);
        $mail->Port       = MAIL_PORT;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
        $mail->addAddress($application['email'], $application['full_name']);

        $mail->isHTML(true);
        $mail->Subject = 'Application Status Update — ' . $application['reference_number'];
        $mail->Body    = buildStatusUpdateEmailHTML($application);
        $mail->AltBody = buildStatusUpdateEmailText($application);

        $mail->send();
        return true;
    } catch (\Throwable $e) {
        error_log('Status email failed: ' . $mail->ErrorInfo . ' | ' . $e->getMessage());
        return false;
    }
}

// ─────────────────────────────────────────────
// SEND CONFIRMATION SMS
// ─────────────────────────────────────────────
function sendConfirmationSMS(string $phone, string $ref, string $name): bool {
    if (!SEND_SMS) return true;

    $message = "Dear {$name}, your Nepal visa application has been received. Reference: {$ref}. Track at immigration.gov.np. Dept of Immigration Nepal.";

    return sendViaTwilio($phone, $message);
}

// ─────────────────────────────────────────────
// SEND STATUS UPDATE SMS
// ─────────────────────────────────────────────
function sendStatusUpdateSMS(string $phone, string $ref, string $name, string $status): bool {
    if (!SEND_SMS) return true;

    $message = "Dear {$name}, your Nepal visa application {$ref} status has been updated to: {$status}. Track at immigration.gov.np.";

    return sendViaTwilio($phone, $message);
}

// ─────────────────────────────────────────────
// TWILIO SMS SENDER
// ─────────────────────────────────────────────
function sendViaTwilio(string $to, string $message): bool {
    if (!$GLOBALS['vendorLoaded'] || !class_exists('Twilio\\Rest\\Client')) {
        error_log('Skipping Twilio SMS: Twilio SDK dependency is not available.');
        return false;
    }
    try {
        $client = new Twilio\Rest\Client(TWILIO_SID, TWILIO_TOKEN);
        $client->messages->create($to, [
            'from' => TWILIO_FROM,
            'body' => $message,
        ]);
        return true;
    } catch (\Throwable $e) {
        error_log('Twilio SMS failed: ' . $e->getMessage());
        return false;
    }
}

// ─────────────────────────────────────────────
// EMAIL TEMPLATES
// ─────────────────────────────────────────────
function buildConfirmationEmailHTML(array $app): string {
    $ref  = htmlspecialchars($app['reference_number']);
    $name = htmlspecialchars($app['full_name']);
    $type = htmlspecialchars($app['visa_type']);
    $date = date('d M Y', strtotime($app['entry_date']));
    $dur  = $app['duration_days'];
    $sub  = date('d M Y, H:i', strtotime($app['submitted_at']));

    return <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f0f2f5;font-family:'Segoe UI',Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f2f5;padding:32px 0;">
    <tr><td align="center">
      <table width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0;">
        <tr><td style="background:#003893;padding:24px 32px;">
          <p style="margin:0;font-size:11px;color:rgba(255,255,255,0.7);">Government of Nepal · Ministry of Home Affairs</p>
          <p style="margin:4px 0 0;font-size:20px;font-weight:700;color:#fff;">Department of Immigration</p>
        </td></tr>
        <tr><td style="padding:32px;">
          <p style="font-size:18px;font-weight:700;color:#1a1a2e;margin:0 0 8px;">Application Received</p>
          <p style="color:#718096;font-size:14px;margin:0 0 24px;">Dear {$name}, your visa application has been successfully submitted.</p>
          <div style="background:#003893;border-radius:8px;padding:16px 24px;text-align:center;margin-bottom:24px;">
            <p style="margin:0;font-size:12px;color:rgba(255,255,255,0.7);">Your Reference Number</p>
            <p style="margin:6px 0 0;font-size:24px;font-weight:700;color:#fff;letter-spacing:3px;">{$ref}</p>
          </div>
          <p style="font-size:13px;color:#718096;margin:0 0 16px;">Keep this reference number safe — you will need it to track your application.</p>
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f7f8fa;border-radius:8px;padding:16px;">
            <tr><td style="padding:6px 0;font-size:13px;color:#a0aec0;width:140px;">Visa Type</td><td style="font-size:13px;color:#1a1a2e;font-weight:500;">{$type}</td></tr>
            <tr><td style="padding:6px 0;font-size:13px;color:#a0aec0;">Entry Date</td><td style="font-size:13px;color:#1a1a2e;font-weight:500;">{$date}</td></tr>
            <tr><td style="padding:6px 0;font-size:13px;color:#a0aec0;">Duration</td><td style="font-size:13px;color:#1a1a2e;font-weight:500;">{$dur} days</td></tr>
            <tr><td style="padding:6px 0;font-size:13px;color:#a0aec0;">Submitted</td><td style="font-size:13px;color:#1a1a2e;font-weight:500;">{$sub}</td></tr>
          </table>
          <div style="text-align:center;margin-top:24px;">
            <a href="https://www.immigration.gov.np/pages/track.php?ref={$ref}" style="background:#DC143C;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:700;">Track My Application</a>
          </div>
          <p style="font-size:12px;color:#a0aec0;margin-top:24px;text-align:center;">If you have any questions, contact us at info@immigration.gov.np or 01-4529660.</p>
        </td></tr>
        <tr><td style="background:#001850;padding:16px 32px;text-align:center;">
          <p style="margin:0;font-size:11px;color:#4a5568;">© 2025 Department of Immigration, Nepal. All Rights Reserved.</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;
}

function buildConfirmationEmailText(array $app): string {
    return "Dear {$app['full_name']},\n\nYour visa application has been received.\n\nReference Number: {$app['reference_number']}\nVisa Type: {$app['visa_type']}\nEntry Date: " . date('d M Y', strtotime($app['entry_date'])) . "\nDuration: {$app['duration_days']} days\n\nTrack your application at: https://www.immigration.gov.np/pages/track.php?ref={$app['reference_number']}\n\nDepartment of Immigration, Nepal\ninfo@immigration.gov.np | 01-4529660";
}

function buildStatusUpdateEmailHTML(array $app): string {
    $ref    = htmlspecialchars($app['reference_number']);
    $name   = htmlspecialchars($app['full_name']);
    $status = htmlspecialchars($app['status']);
    $notes  = !empty($app['admin_notes']) ? htmlspecialchars($app['admin_notes']) : '';
    $colours = ['Approved' => '#27500A', 'Rejected' => '#791F1F', 'Under Review' => '#633806', 'Submitted' => '#0C447C'];
    $bg      = ['Approved' => '#EAF3DE', 'Rejected' => '#FCEBEB', 'Under Review' => '#FAEEDA', 'Submitted' => '#E6F1FB'];
    $c = $colours[$status] ?? '#0C447C';
    $b = $bg[$status] ?? '#E6F1FB';
    $noteRow = $notes ? "<p style='font-size:13px;color:#2d3748;background:#f7f8fa;padding:12px;border-radius:6px;margin-top:16px;'><strong>Note from immigration office:</strong><br>{$notes}</p>" : '';

    return <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f0f2f5;font-family:'Segoe UI',Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f2f5;padding:32px 0;">
    <tr><td align="center">
      <table width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e2e8f0;">
        <tr><td style="background:#003893;padding:24px 32px;">
          <p style="margin:0;font-size:11px;color:rgba(255,255,255,0.7);">Government of Nepal · Ministry of Home Affairs</p>
          <p style="margin:4px 0 0;font-size:20px;font-weight:700;color:#fff;">Department of Immigration</p>
        </td></tr>
        <tr><td style="padding:32px;">
          <p style="font-size:18px;font-weight:700;color:#1a1a2e;margin:0 0 8px;">Application Status Update</p>
          <p style="color:#718096;font-size:14px;margin:0 0 24px;">Dear {$name}, your application status has been updated.</p>
          <p style="font-size:13px;color:#718096;margin:0 0 8px;">Reference: <strong style="color:#1a1a2e;">{$ref}</strong></p>
          <div style="background:{$b};border-radius:8px;padding:14px 20px;display:inline-block;margin-bottom:16px;">
            <p style="margin:0;font-size:15px;font-weight:700;color:{$c};">Status: {$status}</p>
          </div>
          {$noteRow}
          <div style="text-align:center;margin-top:24px;">
            <a href="https://www.immigration.gov.np/pages/track.php?ref={$ref}" style="background:#003893;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:700;">View Full Details</a>
          </div>
          <p style="font-size:12px;color:#a0aec0;margin-top:24px;text-align:center;">Questions? Contact info@immigration.gov.np or 01-4529660.</p>
        </td></tr>
        <tr><td style="background:#001850;padding:16px 32px;text-align:center;">
          <p style="margin:0;font-size:11px;color:#4a5568;">© 2025 Department of Immigration, Nepal. All Rights Reserved.</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;
}

function buildStatusUpdateEmailText(array $app): string {
    return "Dear {$app['full_name']},\n\nYour application {$app['reference_number']} status has been updated to: {$app['status']}.\n\n" . (!empty($app['admin_notes']) ? "Note: {$app['admin_notes']}\n\n" : '') . "Track your application at: https://www.immigration.gov.np/pages/track.php?ref={$app['reference_number']}\n\nDepartment of Immigration, Nepal";
}
