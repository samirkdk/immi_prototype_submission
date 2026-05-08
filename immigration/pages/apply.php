<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$lang = getLang();
$rootPath = '../';
$currentPage = 'apply';
$visaType = $_GET['type'] ?? 'tourist';

$typeLabels = [
  'arrival' => ['en' => 'Visa on Arrival', 'ne' => 'आगमनमा भिसा'],
  'eta' => ['en' => 'Electronic Travel Authorization', 'ne' => 'इलेक्ट्रोनिक ट्राभेल अथराइजेसन'],
  'mission' => ['en' => 'Visa from Nepalese Mission', 'ne' => 'नेपाली नियोगबाट भिसा'],
  'entry' => ['en' => 'Entry Visa', 'ne' => 'प्रवेश भिसा'],
  'extension' => ['en' => 'Visa Extension', 'ne' => 'भिसा विस्तार'],
  'conversion' => ['en' => 'Visa Conversion', 'ne' => 'भिसा रूपान्तरण'],
];

$typeLabel = $typeLabels[$visaType] ?? $typeLabels['entry'];
$typeToDbVisaType = [
  'arrival' => 'Tourist',
  'eta' => 'Tourist',
  'mission' => 'Entry',
  'entry' => 'Entry',
  'extension' => 'Tourist',
  'conversion' => 'Entry',
];
$defaultDbVisaType = $typeToDbVisaType[$visaType] ?? 'Entry';
$pageTitle = ($lang === 'ne' ? $typeLabel['ne'] : $typeLabel['en']) . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [
  ['label' => $lang === 'ne' ? 'भिसा' : 'Visa', 'url' => '#'],
  ['label' => $lang === 'ne' ? $typeLabel['ne'] : $typeLabel['en']],
];

if (empty($_SESSION['csrf_apply'])) {
  $_SESSION['csrf_apply'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_apply'];

$flowStep = $_POST['flow_step'] ?? ($_GET['step'] ?? 'intro');
$allowedSteps = ['intro', 'eligibility', 'form'];
if (!in_array($flowStep, $allowedSteps, true)) $flowStep = 'intro';

$errors = [];
$quickErrors = [];
$formData = [
  'full_name' => '',
  'email' => '',
  'phone' => '',
  'nationality' => '',
  'date_of_birth' => '',
  'passport_number' => '',
  'passport_expiry' => '',
  'visa_type' => $defaultDbVisaType,
  'entry_date' => '',
  'duration_days' => '30',
];
$quickData = [
  'passport_expiry' => '',
  'entry_date' => '',
  'nationality' => '',
  'acknowledge' => '',
];

if (!empty($_SESSION['apply_prefill']) && is_array($_SESSION['apply_prefill'])) {
  $formData = array_merge($formData, $_SESSION['apply_prefill']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $postedToken = $_POST['csrf_token'] ?? '';
  if (!hash_equals($csrfToken, $postedToken)) {
    $errors['general'] = $lang === 'ne' ? 'सुरक्षा टोकन मिलेन। कृपया फेरि प्रयास गर्नुहोस्।' : 'Security token mismatch. Please try again.';
    $flowStep = 'intro';
  } else {
    if ($flowStep === 'intro') {
      $flowStep = 'eligibility';
    } elseif ($flowStep === 'eligibility') {
      $quickData['passport_expiry'] = trim($_POST['passport_expiry'] ?? '');
      $quickData['entry_date'] = trim($_POST['entry_date'] ?? '');
      $quickData['nationality'] = normalizeText($_POST['nationality'] ?? '');
      $quickData['acknowledge'] = $_POST['acknowledge'] ?? '';

      $entryErr = validateEntryDateValue($quickData['entry_date']);
      if ($entryErr) $quickErrors['entry_date'] = $entryErr;

      $passportErr = validatePassportExpiryValue($quickData['passport_expiry'], $quickData['entry_date']);
      if ($passportErr) $quickErrors['passport_expiry'] = $passportErr;

      $natErr = validateNationality($quickData['nationality']);
      if ($natErr) $quickErrors['nationality'] = $natErr;

      if ($quickData['acknowledge'] !== '1') {
        $quickErrors['acknowledge'] = $lang === 'ne' ? 'अगाडि बढ्नुअघि विवरण पुष्टि गर्नुहोस्।' : 'Please confirm before proceeding.';
      }

      if (empty($quickErrors)) {
        $_SESSION['apply_prefill'] = array_merge($_SESSION['apply_prefill'] ?? [], [
          'passport_expiry' => $quickData['passport_expiry'],
          'entry_date' => $quickData['entry_date'],
          'nationality' => $quickData['nationality'],
        ]);
        $formData = array_merge($formData, $_SESSION['apply_prefill']);
        $flowStep = 'form';
      }
    } elseif ($flowStep === 'form') {
      $fields = ['full_name', 'email', 'phone', 'nationality', 'date_of_birth', 'passport_number', 'passport_expiry', 'visa_type', 'entry_date', 'duration_days'];
      foreach ($fields as $f) {
        $formData[$f] = trim($_POST[$f] ?? '');
      }

      $formData['full_name'] = normalizeText($formData['full_name']);
      $formData['nationality'] = normalizeText($formData['nationality']);
      $formData['phone'] = normalizePhone($formData['phone']);
      $formData['passport_number'] = normalizePassport($formData['passport_number']);

      $nameErr = validateName($formData['full_name']);
      if ($nameErr) $errors['full_name'] = $nameErr;

      $emailErr = validateEmailAddress($formData['email']);
      if ($emailErr) $errors['email'] = $emailErr;

      $phoneErr = validatePhoneNumber($formData['phone']);
      if ($phoneErr) $errors['phone'] = $phoneErr;

      $natErr = validateNationality($formData['nationality']);
      if ($natErr) $errors['nationality'] = $natErr;

      $dobErr = validatePastDate($formData['date_of_birth'], 'date of birth');
      if ($dobErr) $errors['date_of_birth'] = $dobErr;

      $passNoErr = validatePassportNumber($formData['passport_number']);
      if ($passNoErr) $errors['passport_number'] = $passNoErr;

      $entryErr = validateEntryDateValue($formData['entry_date']);
      if ($entryErr) $errors['entry_date'] = $entryErr;

      $passExpErr = validatePassportExpiryValue($formData['passport_expiry'], $formData['entry_date']);
      if ($passExpErr) $errors['passport_expiry'] = $passExpErr;

      $durationErr = validateDurationDays($formData['duration_days']);
      if ($durationErr) $errors['duration_days'] = $durationErr;

      $allowedVisaTypes = ['Tourist', 'Business', 'Transit', 'Student', 'Entry'];
      $submittedVisaType = $formData['visa_type'] ?: $defaultDbVisaType;
      $dbVisaType = in_array($submittedVisaType, $allowedVisaTypes, true) ? $submittedVisaType : $defaultDbVisaType;

      $fingerprint = hash('sha256', implode('|', [
        $formData['passport_number'],
        $formData['entry_date'],
        $dbVisaType,
        strtolower($formData['email']),
      ]));
      $lastFingerprint = $_SESSION['last_submission_fingerprint'] ?? '';
      $lastFingerprintAt = (int) ($_SESSION['last_submission_at'] ?? 0);
      if ($lastFingerprint === $fingerprint && (time() - $lastFingerprintAt) < 300) {
        $errors['general'] = $lang === 'ne' ? 'उही आवेदन हालै पठाइसकिएको छ। केही मिनेट पछि फेरि प्रयास गर्नुहोस्।' : 'A similar application was recently submitted. Please wait a few minutes.';
      }

      if (empty($errors)) {
        try {
          $db = getDB();
          $ref = generateReference();

          $stmt = $db->prepare("INSERT INTO visa_applications
            (reference_number, full_name, email, phone, nationality, date_of_birth, passport_number, passport_expiry, visa_type, entry_date, duration_days, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Submitted')");
          $stmt->execute([
            $ref,
            $formData['full_name'],
            $formData['email'],
            $formData['phone'],
            $formData['nationality'],
            $formData['date_of_birth'],
            $formData['passport_number'],
            $formData['passport_expiry'],
            $dbVisaType,
            $formData['entry_date'],
            (int) $formData['duration_days'],
          ]);

          $_SESSION['last_submission_fingerprint'] = $fingerprint;
          $_SESSION['last_submission_at'] = time();
          $_SESSION['apply_prefill'] = [
            'nationality' => $formData['nationality'],
            'entry_date' => $formData['entry_date'],
            'passport_expiry' => $formData['passport_expiry'],
          ];

          $appData = getApplicationByRef($ref);
          if ($appData) {
            require_once __DIR__ . '/../includes/notifications.php';
            try {
              sendConfirmationEmail($appData);
              sendConfirmationSMS($formData['phone'], $ref, $formData['full_name']);
            } catch (\Throwable $e) {
              error_log('Notification error after submit: ' . $e->getMessage());
            }
          }

          header("Location: confirmation.php?ref=" . urlencode($ref));
          exit;
        } catch (Exception $e) {
          error_log($e->getMessage());
          $errors['general'] = $lang === 'ne' ? 'एउटा त्रुटि भयो। कृपया पुनः प्रयास गर्नुहोस्।' : 'An error occurred. Please try again.';
        }
      }
    }
  }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-wrap">
  <div class="card">
    <div class="card-title"><?= h($lang === 'ne' ? $typeLabel['ne'] : $typeLabel['en']) ?></div>

    <?php if (!empty($errors['general'])): ?>
      <div class="alert alert-error"><?= h($errors['general']) ?></div>
    <?php endif; ?>

    <?php if ($flowStep === 'intro'): ?>
      <div class="card-sub">
        <?= $lang === 'ne'
          ? 'आवेदन सुरु गर्नु अघि छोटो पूर्व-जाँच पूरा गर्नुहोस्।'
          : 'Complete a quick pre-check before starting your full application.' ?>
      </div>
      <div class="alert alert-info">
        <?= $lang === 'ne'
          ? 'तपाईंलाई पासपोर्ट विवरण, प्रवेश मिति, र सम्पर्क जानकारी चाहिन्छ।'
          : 'You will need passport details, intended entry date, and contact information.' ?>
      </div>
      <ul style="margin: 14px 0 20px 18px; color:#4a5568; line-height:1.7;">
        <li><?= $lang === 'ne' ? 'पासपोर्ट कम्तिमा ६ महिनासम्म मान्य हुनुपर्छ।' : 'Passport should be valid for at least 6 months.' ?></li>
        <li><?= $lang === 'ne' ? 'प्रवेश मिति भविष्यको हुनुपर्छ।' : 'Entry date must be in the future.' ?></li>
        <li><?= $lang === 'ne' ? 'पुष्टिकरणको लागि वैध इमेल र फोन चाहिन्छ।' : 'A valid email and phone are required for confirmation.' ?></li>
      </ul>
      <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
        <input type="hidden" name="flow_step" value="intro">
        <button type="submit" class="btn btn-primary"><?= $lang === 'ne' ? 'पूर्व-जाँच सुरु गर्नुहोस्' : 'Start Pre-check' ?></button>
      </form>
    <?php elseif ($flowStep === 'eligibility'): ?>
      <div class="card-sub">
        <?= $lang === 'ne' ? 'अगाडि बढ्नुअघि आफ्नो पात्रता पुष्टि गर्नुहोस्।' : 'Confirm eligibility before moving to the full form.' ?>
      </div>
      <form method="POST" action="" id="eligibility-form">
        <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
        <input type="hidden" name="flow_step" value="eligibility">
        <div class="form-grid">
          <div class="form-group">
            <label for="entry_date"><?= $lang === 'ne' ? 'नेपाल प्रवेश मिति' : 'Intended Entry Date' ?> <span class="req">*</span></label>
            <input type="date" id="entry_date" name="entry_date" value="<?= h($quickData['entry_date'] ?: ($formData['entry_date'] ?? '')) ?>" min="<?= date('Y-m-d') ?>" required class="<?= isset($quickErrors['entry_date']) ? 'error' : '' ?>">
            <?php if (isset($quickErrors['entry_date'])): ?><div class="error-msg"><?= h($quickErrors['entry_date']) ?></div><?php endif; ?>
          </div>
          <div class="form-group">
            <label for="passport_expiry"><?= $lang === 'ne' ? 'राहदानी म्याद समाप्ति मिति' : 'Passport Expiry Date' ?> <span class="req">*</span></label>
            <input type="date" id="passport_expiry" name="passport_expiry" value="<?= h($quickData['passport_expiry'] ?: ($formData['passport_expiry'] ?? '')) ?>" required class="<?= isset($quickErrors['passport_expiry']) ? 'error' : '' ?>">
            <?php if (isset($quickErrors['passport_expiry'])): ?><div class="error-msg"><?= h($quickErrors['passport_expiry']) ?></div><?php endif; ?>
          </div>
          <div class="form-group full">
            <label for="nationality"><?= $lang === 'ne' ? 'राष्ट्रियता' : 'Nationality' ?> <span class="req">*</span></label>
            <input type="text" id="nationality" name="nationality" value="<?= h($quickData['nationality'] ?: ($formData['nationality'] ?? '')) ?>" required class="<?= isset($quickErrors['nationality']) ? 'error' : '' ?>">
            <?php if (isset($quickErrors['nationality'])): ?><div class="error-msg"><?= h($quickErrors['nationality']) ?></div><?php endif; ?>
          </div>
        </div>
        <label style="display:flex;gap:8px;align-items:flex-start;margin-top:10px;font-size:13px;color:#4a5568;">
          <input type="checkbox" name="acknowledge" value="1" <?= $quickData['acknowledge'] === '1' ? 'checked' : '' ?>>
          <span><?= $lang === 'ne' ? 'माथिका विवरण सही छन् र म पूर्ण आवेदन फारममा जान चाहन्छु।' : 'I confirm the details above and want to continue to the full application form.' ?></span>
        </label>
        <?php if (isset($quickErrors['acknowledge'])): ?><div class="error-msg"><?= h($quickErrors['acknowledge']) ?></div><?php endif; ?>
        <div style="display:flex;gap:10px;margin-top:18px;">
          <a href="?type=<?= urlencode($visaType) ?>&step=intro" class="btn btn-outline"><?= $lang === 'ne' ? 'फर्कनुहोस्' : 'Back' ?></a>
          <button type="submit" class="btn btn-primary"><?= $lang === 'ne' ? 'पूर्ण फारममा जानुहोस्' : 'Continue to Full Form' ?></button>
        </div>
      </form>
    <?php else: ?>
      <div class="card-sub">
        <?= $lang === 'ne'
          ? 'कृपया तलको फारम सही जानकारीसहित भर्नुहोस्। सबै क्षेत्रहरू अनिवार्य छन्।'
          : 'Please complete the form below with accurate information. All fields marked with * are required.' ?>
      </div>
      <form method="POST" action="" id="visa-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
        <input type="hidden" name="flow_step" value="form">
        <input type="hidden" name="visa_type" value="<?= h($defaultDbVisaType) ?>">

        <div class="form-grid">
          <div class="form-group full">
            <label for="full_name"><?= $lang === 'ne' ? 'पूरा नाम' : 'Full Name' ?> <span class="req">*</span></label>
            <input type="text" id="full_name" name="full_name" value="<?= h($formData['full_name']) ?>" placeholder="<?= $lang === 'ne' ? 'राहदानीमा भएअनुसार' : 'As it appears on your passport' ?>" class="<?= isset($errors['full_name']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['full_name'])): ?><div class="error-msg"><?= h($errors['full_name']) ?></div><?php endif; ?>
          </div>

          <div class="form-group">
            <label for="email"><?= $lang === 'ne' ? 'इमेल ठेगाना' : 'Email Address' ?> <span class="req">*</span></label>
            <input type="email" id="email" name="email" value="<?= h($formData['email']) ?>" placeholder="you@example.com" class="<?= isset($errors['email']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['email'])): ?><div class="error-msg"><?= h($errors['email']) ?></div><?php endif; ?>
            <div class="form-hint"><?= $lang === 'ne' ? 'पुष्टिकरण यस ठेगानामा पठाइनेछ।' : 'Confirmation will be sent to this address.' ?></div>
          </div>

          <div class="form-group">
            <label for="phone"><?= $lang === 'ne' ? 'फोन नम्बर' : 'Phone Number' ?> <span class="req">*</span></label>
            <input type="tel" id="phone" name="phone" value="<?= h($formData['phone']) ?>" placeholder="+9779800000000" class="<?= isset($errors['phone']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['phone'])): ?><div class="error-msg"><?= h($errors['phone']) ?></div><?php endif; ?>
            <div class="form-hint"><?= $lang === 'ne' ? 'SMS पुष्टिकरणको लागि अन्तर्राष्ट्रिय ढाँचामा।' : 'Use international format for SMS confirmation.' ?></div>
          </div>

          <div class="form-group">
            <label for="nationality"><?= $lang === 'ne' ? 'राष्ट्रियता' : 'Nationality' ?> <span class="req">*</span></label>
            <input type="text" id="nationality" name="nationality" value="<?= h($formData['nationality']) ?>" class="<?= isset($errors['nationality']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['nationality'])): ?><div class="error-msg"><?= h($errors['nationality']) ?></div><?php endif; ?>
          </div>

          <div class="form-group">
            <label for="date_of_birth"><?= $lang === 'ne' ? 'जन्म मिति' : 'Date of Birth' ?> <span class="req">*</span></label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?= h($formData['date_of_birth']) ?>" class="<?= isset($errors['date_of_birth']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['date_of_birth'])): ?><div class="error-msg"><?= h($errors['date_of_birth']) ?></div><?php endif; ?>
          </div>

          <div class="form-group">
            <label for="passport_number"><?= $lang === 'ne' ? 'राहदानी नम्बर' : 'Passport Number' ?> <span class="req">*</span></label>
            <input type="text" id="passport_number" name="passport_number" value="<?= h($formData['passport_number']) ?>" placeholder="<?= $lang === 'ne' ? 'उदाहरण: AB1234567' : 'e.g. AB1234567' ?>" class="<?= isset($errors['passport_number']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['passport_number'])): ?><div class="error-msg"><?= h($errors['passport_number']) ?></div><?php endif; ?>
          </div>

          <div class="form-group">
            <label for="passport_expiry"><?= $lang === 'ne' ? 'राहदानी म्याद समाप्ति मिति' : 'Passport Expiry Date' ?> <span class="req">*</span></label>
            <input type="date" id="passport_expiry" name="passport_expiry" value="<?= h($formData['passport_expiry']) ?>" class="<?= isset($errors['passport_expiry']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['passport_expiry'])): ?><div class="error-msg"><?= h($errors['passport_expiry']) ?></div><?php endif; ?>
          </div>

          <div class="form-group">
            <label for="entry_date"><?= $lang === 'ne' ? 'नेपाल प्रवेश मिति' : 'Intended Entry Date' ?> <span class="req">*</span></label>
            <input type="date" id="entry_date" name="entry_date" value="<?= h($formData['entry_date']) ?>" min="<?= date('Y-m-d') ?>" class="<?= isset($errors['entry_date']) ? 'error' : '' ?>" required>
            <?php if (isset($errors['entry_date'])): ?><div class="error-msg"><?= h($errors['entry_date']) ?></div><?php endif; ?>
          </div>

          <div class="form-group">
            <label for="duration_days"><?= $lang === 'ne' ? 'बसाइको अवधि (दिन)' : 'Duration of Stay (days)' ?></label>
            <select id="duration_days" name="duration_days" class="<?= isset($errors['duration_days']) ? 'error' : '' ?>">
              <?php foreach ([15, 30, 60, 90] as $d): ?>
                <option value="<?= $d ?>" <?= ((int) $formData['duration_days'] === $d) ? 'selected' : '' ?>>
                  <?= $d ?> <?= $lang === 'ne' ? 'दिन' : 'days' ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($errors['duration_days'])): ?><div class="error-msg"><?= h($errors['duration_days']) ?></div><?php endif; ?>
          </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:28px;align-items:center;">
          <button type="submit" class="btn btn-primary"><?= $lang === 'ne' ? 'आवेदन पेश गर्नुहोस्' : 'Submit Application' ?></button>
          <a href="../index.php" class="btn btn-outline"><?= $lang === 'ne' ? 'रद्द गर्नुहोस्' : 'Cancel' ?></a>
          <span style="font-size:12px;color:#a0aec0;margin-left:8px;"><?= $lang === 'ne' ? 'पेश गरेपछि तपाईंलाई इमेल र SMS पुष्टिकरण प्राप्त हुनेछ।' : 'You will receive email and SMS confirmation after submitting.' ?></span>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>