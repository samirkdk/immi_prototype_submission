<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'help';
$pageTitle = ($lang === 'ne' ? 'नागरिक बडापत्र' : 'Citizen Charter') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [['label' => $lang === 'ne' ? 'सहायता र FAQ' : 'Help & FAQ', 'url' => 'faq.php'], ['label' => $lang === 'ne' ? 'नागरिक बडापत्र' : 'Citizen Charter']];
require_once __DIR__ . '/../includes/header.php';
?>
<div class="page-wrap">
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
    <div class="section-bar"></div>
    <h1 style="font-size:24px;font-weight:700;color:#1a1a2e;"><?= $lang === 'ne' ? 'नागरिक बडापत्र' : 'Citizen Charter' ?></h1>
  </div>
  <div class="alert alert-info" style="margin-bottom:24px;">
    <?= $lang === 'ne'
      ? 'यो नागरिक बडापत्र अध्यागमन विभागले नागरिकहरूलाई प्रदान गर्ने सेवाहरूको मानक र समयसीमा निर्दिष्ट गर्दछ।'
      : 'This Citizen Charter specifies the standards and timelines for services provided by the Department of Immigration to citizens.' ?>
  </div>
  <?php
  $services = [
    ['service_en' => 'Tourist Visa on Arrival', 'service_ne' => 'पर्यटक भिसा (आगमनमा)', 'time_en' => 'Immediate (same visit)', 'time_ne' => 'तुरुन्त (सोही भ्रमणमा)', 'fee_en' => 'As per fee schedule', 'fee_ne' => 'शुल्क तालिका अनुसार'],
    ['service_en' => 'Visa Extension', 'service_ne' => 'भिसा विस्तार', 'time_en' => 'Same day (if submitted before 2:30 PM)', 'time_ne' => 'सोही दिन (दिउँसो २:३० अघि दर्ता भएमा)', 'fee_en' => 'As per fee schedule', 'fee_ne' => 'शुल्क तालिका अनुसार'],
    ['service_en' => 'Visa Conversion', 'service_ne' => 'भिसा रूपान्तरण', 'time_en' => '1-3 working days', 'time_ne' => '१–३ कार्य दिन', 'fee_en' => 'As per fee schedule', 'fee_ne' => 'शुल्क तालिका अनुसार'],
    ['service_en' => 'Arrival/Departure Certification', 'service_ne' => 'आगमन/प्रस्थान प्रमाणीकरण', 'time_en' => 'Same day', 'time_ne' => 'सोही दिन', 'fee_en' => 'Free', 'fee_ne' => 'निःशुल्क'],
    ['service_en' => 'Individual Trekking Permit', 'service_ne' => 'व्यक्तिगत ट्रेकिङ अनुमति', 'time_en' => 'Same day (if submitted before 2:30 PM)', 'time_ne' => 'सोही दिन (दिउँसो २:३० अघि दर्ता भएमा)', 'fee_en' => 'As per area and duration', 'fee_ne' => 'क्षेत्र र अवधि अनुसार'],
  ];
  ?>
  <div class="card">
    <table style="width:100%;font-size:13px;border-collapse:collapse;">
      <thead>
        <tr style="background:#003893;">
          <th style="padding:12px 14px;color:#fff;text-align:left;font-size:12px;"><?= $lang === 'ne' ? 'सेवा' : 'Service' ?></th>
          <th style="padding:12px 14px;color:#fff;text-align:left;font-size:12px;"><?= $lang === 'ne' ? 'सेवा समय' : 'Processing Time' ?></th>
          <th style="padding:12px 14px;color:#fff;text-align:left;font-size:12px;"><?= $lang === 'ne' ? 'शुल्क' : 'Fee' ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($services as $i => $s): ?>
          <tr style="background:<?= $i%2===0 ? '#fff' : '#f7f8fa' ?>;border-bottom:1px solid #f0f4f8;">
            <td style="padding:12px 14px;font-weight:600;color:#1a1a2e;"><?= h($lang === 'ne' ? $s['service_ne'] : $s['service_en']) ?></td>
            <td style="padding:12px 14px;color:#718096;"><?= h($lang === 'ne' ? $s['time_ne'] : $s['time_en']) ?></td>
            <td style="padding:12px 14px;color:#718096;"><?= h($lang === 'ne' ? $s['fee_ne'] : $s['fee_en']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
