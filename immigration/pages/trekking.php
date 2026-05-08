<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'trekking';
$action = $_GET['action'] ?? 'info';
$pageTitle = ($lang === 'ne' ? 'ट्रेकिङ अनुमति' : 'Trekking Permit') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [['label' => $lang === 'ne' ? 'ट्रेकिङ' : 'Trekking']];
require_once __DIR__ . '/../includes/header.php';
?>
<div class="page-wrap wide">
  <div style="display:flex;gap:8px;margin-bottom:28px;border-bottom:2px solid #f0f4f8;padding-bottom:0;">
    <?php foreach ([['apply', 'Apply for Permit', 'अनुमतिको लागि आवेदन'], ['check', 'Check Permit', 'अनुमति जाँच'], ['info', 'Permit Information', 'अनुमति जानकारी']] as [$t, $en, $ne]): ?>
      <a href="?action=<?= $t ?>"
        style="padding:10px 20px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:3px solid <?= $action === $t ? '#DC143C' : 'transparent' ?>;color:<?= $action === $t ? '#DC143C' : '#718096' ?>;margin-bottom:-2px;">
        <?= $lang === 'ne' ? $ne : $en ?>
      </a>
    <?php endforeach; ?>
  </div>

  <?php if ($action === 'apply'): ?>
    <div class="card">
      <div class="card-title">
        <?= $lang === 'ne' ? 'व्यक्तिगत ट्रेकिङ अनुमतिको लागि आवेदन' : 'Apply for Individual Trekking Permit' ?>
      </div>
      <div class="card-sub">
        <?= $lang === 'ne' ? 'प्रतिबन्धित क्षेत्रहरूको लागि अनुमति। कृपया फारम भर्नुहोस्।' : 'Permits for restricted trekking areas. Please complete the form below.' ?>
      </div>
      <div class="alert alert-info">
        <?= $lang === 'ne' ? 'तपाईंले यो अनुमति व्यक्तिगत रूपमा अध्यागमन विभागमा वा अधिकृत ट्रेकिङ एजेन्सी मार्फत पनि प्राप्त गर्न सक्नुहुन्छ।' : 'You can also obtain this permit in person at the Department of Immigration or through an authorized trekking agency.' ?>
      </div>
      <p style="font-size:13px;color:#718096;margin-top:8px;">
        <?= $lang === 'ne' ? 'अनलाइन आवेदन सुविधा छिट्टै उपलब्ध हुनेछ।' : 'Online application for trekking permits is coming soon. Please visit the Department of Immigration office in person.' ?>
      </p>
      <div style="margin-top:20px;"><a href="contact.php"
          class="btn btn-primary"><?= $lang === 'ne' ? 'सम्पर्क गर्नुहोस्' : 'Contact Us' ?></a></div>
    </div>

  <?php elseif ($action === 'check'): ?>
    <div class="card">
      <div class="card-title"><?= $lang === 'ne' ? 'ट्रेकिङ अनुमति जाँच गर्नुहोस्' : 'Check Trekking Permit' ?></div>
      <div class="card-sub">
        <?= $lang === 'ne' ? 'नेपालद्वारा जारी अनुमतिको स्थिति प्रमाणित गर्नुहोस्।' : 'Verify the status of a trekking permit issued by Nepal.' ?>
      </div>
      <div style="display:flex;gap:10px;margin-top:4px;">
        <input type="text" placeholder="<?= $lang === 'ne' ? 'अनुमति नम्बर प्रविष्ट गर्नुहोस्' : 'Enter permit number' ?>"
          style="flex:1;">
        <button class="btn btn-primary"><?= $lang === 'ne' ? 'जाँच्नुहोस्' : 'Check' ?></button>
      </div>
    </div>

  <?php else: ?>
    <div class="card">
      <div class="card-title"><?= $lang === 'ne' ? 'कसलाई ट्रेकिङ अनुमति चाहिन्छ?' : 'Who Needs a Trekking Permit?' ?>
      </div>
      <p style="font-size:14px;color:#718096;line-height:1.8;margin-top:12px;">
        <?= $lang === 'ne'
          ? 'प्रतिबन्धित र संरक्षित क्षेत्रहरूमा ट्रेकिङ गर्न चाहने सबै विदेशी नागरिकहरूलाई अध्यागमन विभागबाट विशेष ट्रेकिङ अनुमति आवश्यक छ।'
          : 'All foreign nationals wishing to trek in restricted and protected areas require a special trekking permit from the Department of Immigration.' ?>
      </p>
    </div>
    <div class="card" style="margin-top:16px;">
      <div class="card-title"><?= $lang === 'ne' ? 'प्रतिबन्धित क्षेत्रहरू' : 'Restricted Areas Requiring Permit' ?></div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:16px;">
        <?php foreach (['Upper Mustang', 'Upper Dolpo', 'Manaslu Circuit', 'Tsum Valley', 'Humla – Simikot', 'Kangchenjunga', 'Nar Phu Valley', 'Dolpo (Lower)', 'Mugu – Rara'] as $area): ?>
          <div
            style="background:#f7f8fa;border-radius:8px;padding:12px 14px;font-size:13px;color:#2d3748;font-weight:500;display:flex;align-items:center;gap:8px;">
            <div style="width:6px;height:6px;border-radius:50%;background:#DC143C;flex-shrink:0;"></div>
            <?= h($area) ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>