<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'track';
$pageTitle = ($lang === 'ne' ? 'आवेदन ट्र्याक' : 'Track Application') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [
  ['label' => $lang === 'ne' ? 'भिसा' : 'Visa', 'url' => $rootPath . 'pages/apply.php'],
  ['label' => $lang === 'ne' ? 'आवेदन ट्र्याक' : 'Track Application'],
];

$application = null;
$notFound = false;
$ref = strtoupper(trim($_GET['ref'] ?? $_POST['ref'] ?? ''));

if (!empty($ref)) {
  $application = getApplicationByRef($ref);
  if (!$application) $notFound = true;
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-wrap">
  <div class="card">
    <div class="card-title"><?= $lang === 'ne' ? 'आवेदन ट्र्याक गर्नुहोस्' : 'Track Your Application' ?></div>
    <div class="card-sub">
      <?= $lang === 'ne'
        ? 'पुष्टिकरण इमेल वा SMS बाट प्राप्त सन्दर्भ नम्बर प्रविष्ट गर्नुहोस्।'
        : 'Enter the reference number from your confirmation email or SMS.' ?>
    </div>

    <form method="GET" action="">
      <div class="form-grid" style="grid-template-columns:1fr auto;gap:12px;align-items:end;">
        <div class="form-group">
          <label for="reference_number"><?= $lang === 'ne' ? 'सन्दर्भ नम्बर' : 'Reference Number' ?></label>
          <input type="text" id="reference_number" name="ref" value="<?= h($ref) ?>"
            placeholder="<?= $lang === 'ne' ? 'उदाहरण: NI-20250409-A7X2K' : 'e.g. NI-20250409-A7X2K' ?>"
            style="text-transform:uppercase;letter-spacing:1px;" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary" style="height:44px;white-space:nowrap;">
          <?= $lang === 'ne' ? 'स्थिति जाँच्नुहोस्' : 'Check Status' ?>
        </button>
      </div>
    </form>

    <?php if ($notFound): ?>
      <div class="alert alert-error" style="margin-top:20px;">
        <?= $lang === 'ne'
          ? 'सन्दर्भ नम्बर <strong>' . h($ref) . '</strong> फेला परेन। कृपया पुष्टिकरण इमेल वा SMS जाँच गर्नुहोस्।'
          : 'Reference number <strong>' . h($ref) . '</strong> was not found. Please check your confirmation email or SMS.' ?>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($application): ?>
    <?php
    $step = statusStep($application['status']);
    $isRejected = $application['status'] === 'Rejected';
    $steps = [
      ['en' => 'Submitted', 'ne' => 'पेश भयो'],
      ['en' => 'Under Review', 'ne' => 'समीक्षाधीन'],
      ['en' => $isRejected ? 'Rejected' : 'Approved', 'ne' => $isRejected ? 'अस्वीकृत' : 'स्वीकृत'],
    ];
    ?>

    <div class="track-result">
      <div class="track-result-head">
        <h2><?= $lang === 'ne' ? 'आवेदन विवरण' : 'Application Details' ?></h2>
        <p><?= $lang === 'ne' ? 'सन्दर्भ: ' : 'Reference: ' ?><?= h($application['reference_number']) ?></p>
      </div>
      <div class="track-result-body">

        <!-- Status steps -->
        <div class="status-steps">
          <?php foreach ($steps as $i => $s): ?>
            <?php
            $stepNum = $i + 1;
            $isDone = $step > $stepNum;
            $isCurrent = $step === $stepNum;
            $circleClass = $isDone ? 'done' : ($isCurrent ? ($isRejected && $stepNum === 3 ? 'rejected' : 'current') : '');
            $labelClass = $isDone || $isCurrent ? 'done' : '';
            ?>
            <?php if ($i > 0): ?>
              <div class="step-line <?= $isDone ? 'done' : '' ?>"></div>
            <?php endif; ?>
            <div class="status-step">
              <div class="step-circle <?= $circleClass ?>">
                <?php if ($isDone): ?>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                <?php elseif ($isCurrent && $isRejected && $stepNum === 3): ?>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                <?php else: ?>
                  <?= $stepNum ?>
                <?php endif; ?>
              </div>
              <div class="step-label <?= $labelClass ?>"><?= $lang === 'ne' ? $s['ne'] : $s['en'] ?></div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Status badge -->
        <?php $badge = statusBadge($application['status']); ?>
        <div style="text-align:center;margin-bottom:20px;">
          <span class="status-badge" style="background:<?= $badge['bg'] ?>;color:<?= $badge['color'] ?>;font-size:14px;padding:6px 18px;">
            <?= $lang === 'ne'
              ? ['Submitted'=>'पेश भयो','Under Review'=>'समीक्षाधीन','Approved'=>'स्वीकृत','Rejected'=>'अस्वीकृत'][$application['status']] ?? $application['status']
              : $application['status'] ?>
          </span>
        </div>

        <!-- Details grid -->
        <div class="track-detail-grid">
          <div class="track-detail">
            <div class="td-label"><?= $lang === 'ne' ? 'पूरा नाम' : 'Full Name' ?></div>
            <div class="td-value"><?= h($application['full_name']) ?></div>
          </div>
          <div class="track-detail">
            <div class="td-label"><?= $lang === 'ne' ? 'भिसा प्रकार' : 'Visa Type' ?></div>
            <div class="td-value"><?= h($application['visa_type']) ?></div>
          </div>
          <div class="track-detail">
            <div class="td-label"><?= $lang === 'ne' ? 'राष्ट्रियता' : 'Nationality' ?></div>
            <div class="td-value"><?= h($application['nationality']) ?></div>
          </div>
          <div class="track-detail">
            <div class="td-label"><?= $lang === 'ne' ? 'प्रवेश मिति' : 'Entry Date' ?></div>
            <div class="td-value"><?= h(date('d M Y', strtotime($application['entry_date']))) ?></div>
          </div>
          <div class="track-detail">
            <div class="td-label"><?= $lang === 'ne' ? 'बसाइको अवधि' : 'Duration' ?></div>
            <div class="td-value"><?= h($application['duration_days']) ?> <?= $lang === 'ne' ? 'दिन' : 'days' ?></div>
          </div>
          <div class="track-detail">
            <div class="td-label"><?= $lang === 'ne' ? 'पेश मिति' : 'Submitted' ?></div>
            <div class="td-value"><?= h(date('d M Y', strtotime($application['submitted_at']))) ?></div>
          </div>
          <div class="track-detail">
            <div class="td-label"><?= $lang === 'ne' ? 'अन्तिम अद्यावधिक' : 'Last Updated' ?></div>
            <div class="td-value"><?= h(date('d M Y, H:i', strtotime($application['updated_at']))) ?></div>
          </div>
        </div>

        <?php if (!empty($application['admin_notes'])): ?>
          <div class="alert alert-info" style="margin-top:20px;">
            <strong><?= $lang === 'ne' ? 'नोट:' : 'Note:' ?></strong> <?= h($application['admin_notes']) ?>
          </div>
        <?php endif; ?>

        <div style="text-align:center;margin-top:24px;">
          <a href="../index.php" class="btn btn-outline"><?= $lang === 'ne' ? 'गृहपृष्ठमा फर्कनुहोस्' : 'Return to Homepage' ?></a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
