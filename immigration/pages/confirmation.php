<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'apply';
$ref = strtoupper(trim($_GET['ref'] ?? ''));

if (empty($ref)) {
  header('Location: ../index.php');
  exit;
}

$application = getApplicationByRef($ref);
if (!$application) {
  header('Location: ../index.php');
  exit;
}

$pageTitle = ($lang === 'ne' ? 'आवेदन पुष्टिकरण' : 'Application Confirmed') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [
  ['label' => $lang === 'ne' ? 'भिसा' : 'Visa', 'url' => '#'],
  ['label' => $lang === 'ne' ? 'आवेदन पुष्टिकरण' : 'Application Confirmed'],
];
require_once __DIR__ . '/../includes/header.php';
?>

<div class="confirm-wrap">
  <div class="confirm-icon">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5">
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
    </svg>
  </div>

  <h1 style="font-size:24px;font-weight:700;color:#1a1a2e;margin-bottom:8px;">
    <?= $lang === 'ne' ? 'आवेदन सफलतापूर्वक पेश भयो!' : 'Application Submitted Successfully!' ?>
  </h1>
  <p style="color:#718096;font-size:14px;margin-bottom:20px;">
    <?= $lang === 'ne'
      ? 'तपाईंको भिसा आवेदन प्राप्त भएको छ। तलको सन्दर्भ नम्बर सुरक्षित राख्नुहोस्।'
      : 'Your visa application has been received. Please keep your reference number safe.' ?>
  </p>

  <div class="confirm-ref"><?= h($application['reference_number']) ?></div>

  <div class="alert alert-info" style="text-align:left;margin-top:16px;">
    <?= $lang === 'ne'
      ? 'पुष्टिकरण इमेल र SMS ' . h($application['email']) . ' र ' . h($application['phone']) . ' मा पठाइएको छ।'
      : 'A confirmation email and SMS have been sent to ' . h($application['email']) . ' and ' . h($application['phone']) . '.' ?>
  </div>

  <div class="confirm-detail">
    <p><strong><?= $lang === 'ne' ? 'नाम:' : 'Name:' ?></strong> <?= h($application['full_name']) ?></p>
    <p><strong><?= $lang === 'ne' ? 'भिसा प्रकार:' : 'Visa Type:' ?></strong> <?= h($application['visa_type']) ?></p>
    <p><strong><?= $lang === 'ne' ? 'प्रवेश मिति:' : 'Entry Date:' ?></strong> <?= h(date('d M Y', strtotime($application['entry_date']))) ?></p>
    <p><strong><?= $lang === 'ne' ? 'बसाइको अवधि:' : 'Duration:' ?></strong> <?= h($application['duration_days']) ?> <?= $lang === 'ne' ? 'दिन' : 'days' ?></p>
    <p><strong><?= $lang === 'ne' ? 'पेश मिति:' : 'Submitted:' ?></strong> <?= h(date('d M Y, H:i', strtotime($application['submitted_at']))) ?></p>
    <p><strong><?= $lang === 'ne' ? 'अवस्था:' : 'Status:' ?></strong>
      <?php $badge = statusBadge($application['status']); ?>
      <span class="status-badge" style="background:<?= $badge['bg'] ?>;color:<?= $badge['color'] ?>;"><?= h($application['status']) ?></span>
    </p>
  </div>

  <div style="display:flex;gap:12px;justify-content:center;margin-top:28px;flex-wrap:wrap;">
    <a href="track.php?ref=<?= urlencode($ref) ?>" class="btn btn-primary">
      <?= $lang === 'ne' ? 'आवेदन ट्र्याक गर्नुहोस्' : 'Track Application' ?>
    </a>
    <a href="../index.php" class="btn btn-outline">
      <?= $lang === 'ne' ? 'गृहपृष्ठमा फर्कनुहोस्' : 'Return to Homepage' ?>
    </a>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
