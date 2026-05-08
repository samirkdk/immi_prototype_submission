<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'resources';
$tab = $_GET['tab'] ?? 'acts';
$pageTitle = ($lang === 'ne' ? 'स्रोतहरू' : 'Resources') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [['label' => $lang === 'ne' ? 'स्रोतहरू' : 'Resources']];
require_once __DIR__ . '/../includes/header.php';
?>
<div class="page-wrap wide">
  <div style="display:flex;gap:8px;margin-bottom:28px;border-bottom:2px solid #f0f4f8;padding-bottom:0;">
    <?php foreach ([['acts','Acts & Regulations','ऐन र नियमहरू'],['publications','Publications & Reports','प्रकाशन र प्रतिवेदनहरू'],['offices','Immigration Offices','अध्यागमन कार्यालयहरू']] as [$t,$en,$ne]): ?>
      <a href="?tab=<?= $t ?>" style="padding:10px 20px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:3px solid <?= $tab===$t ? '#DC143C' : 'transparent' ?>;color:<?= $tab===$t ? '#DC143C' : '#718096' ?>;margin-bottom:-2px;">
        <?= $lang === 'ne' ? $ne : $en ?>
      </a>
    <?php endforeach; ?>
  </div>

  <?php if ($tab === 'acts'): ?>
    <div class="card">
      <div class="card-title"><?= $lang === 'ne' ? 'ऐन र नियमहरू' : 'Acts & Regulations' ?></div>
      <div class="card-sub"><?= $lang === 'ne' ? 'अध्यागमन सम्बन्धी कानूनी कागजातहरू' : 'Legal documents related to immigration' ?></div>
      <?php
      $acts = [
        ['title' => 'Nepal Immigration Act, 2049 (1992)', 'date' => '1992', 'type' => 'Act'],
        ['title' => 'Nepal Immigration Rules, 2051 (1994)', 'date' => '1994', 'type' => 'Regulation'],
        ['title' => 'Non-Resident Nepali Act, 2064 (2008)', 'date' => '2008', 'type' => 'Act'],
        ['title' => 'Trekking Permit Directive, 2079', 'date' => '2022', 'type' => 'Directive'],
        ['title' => 'Foreign Nationals Management Working Procedure, 2079', 'date' => '2022', 'type' => 'Working Procedure'],
      ];
      foreach ($acts as $a): ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid #f0f4f8;">
          <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:36px;height:36px;border-radius:8px;background:#E6F1FB;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
            </div>
            <div>
              <div style="font-size:13px;font-weight:600;color:#1a1a2e;"><?= h($a['title']) ?></div>
              <div style="font-size:11px;color:#a0aec0;margin-top:2px;"><?= h($a['type']) ?> · <?= h($a['date']) ?></div>
            </div>
          </div>
          <span style="font-size:12px;color:#003893;font-weight:600;cursor:pointer;">PDF ↓</span>
        </div>
      <?php endforeach; ?>
    </div>

  <?php elseif ($tab === 'publications'): ?>
    <div class="card">
      <div class="card-title"><?= $lang === 'ne' ? 'प्रकाशन र प्रतिवेदनहरू' : 'Publications & Reports' ?></div>
      <div class="card-sub"><?= $lang === 'ne' ? 'आगमन तथ्याङ्क, बुलेटिन र प्रतिवेदनहरू' : 'Arrival statistics, bulletins and reports' ?></div>
      <?php
      $pubs = [
        ['title' => 'Annual Immigration Report 2080/81 (2023/24)', 'date' => 'March 2025', 'type' => 'Annual Report'],
        ['title' => 'Monthly Arrival/Departure Report — Falgun 2081', 'date' => 'February 2025', 'type' => 'Monthly Report'],
        ['title' => 'Monthly Arrival/Departure Report — Magh 2081', 'date' => 'January 2025', 'type' => 'Monthly Report'],
        ['title' => 'Immigration Bulletin — 2080', 'date' => 'December 2024', 'type' => 'Bulletin'],
        ['title' => 'Right to Information Annual Report 2080', 'date' => 'November 2024', 'type' => 'RTI Report'],
      ];
      foreach ($pubs as $p): ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid #f0f4f8;">
          <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:36px;height:36px;border-radius:8px;background:#EAF3DE;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#27500A" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
            </div>
            <div>
              <div style="font-size:13px;font-weight:600;color:#1a1a2e;"><?= h($p['title']) ?></div>
              <div style="font-size:11px;color:#a0aec0;margin-top:2px;"><?= h($p['type']) ?> · <?= h($p['date']) ?></div>
            </div>
          </div>
          <span style="font-size:12px;color:#003893;font-weight:600;cursor:pointer;">PDF ↓</span>
        </div>
      <?php endforeach; ?>
    </div>

  <?php else: ?>
    <div class="card">
      <div class="card-title"><?= $lang === 'ne' ? 'अध्यागमन कार्यालयहरू' : 'Immigration Offices' ?></div>
      <div class="card-sub"><?= $lang === 'ne' ? 'नेपालभरका अध्यागमन कार्यालयहरूको सम्पर्क विवरण' : 'Contact details for immigration offices across Nepal' ?></div>
      <?php
      $offices = [
        ['name' => 'Department of Immigration (Head Office)', 'location' => 'Kathmandu, Nepal', 'phone' => '01-5550000', 'email' => 'info@example.com'],
        ['name' => 'Immigration Office — Tribhuwan International Airport', 'location' => 'Kathmandu, Nepal', 'phone' => '01-5550001', 'email' => 'office1@example.com'],
        ['name' => 'Immigration Office — Pokhara International Airport', 'location' => 'Kathmandu, Nepal', 'phone' => '01-5550002', 'email' => 'office2@example.com'],
        ['name' => 'Immigration Office — Gautambuddha International Airport', 'location' => 'Kathmandu, Nepal', 'phone' => '01-5550003', 'email' => 'office3@example.com'],
        ['name' => 'Immigration Office — Biratnagar', 'location' => 'Kathmandu, Nepal', 'phone' => '01-5550004', 'email' => 'office4@example.com'],
        ['name' => 'Immigration Office — Pashupatinagar', 'location' => 'Kathmandu, Nepal', 'phone' => '01-5550005', 'email' => 'office5@example.com'],
      ];
      foreach ($offices as $o): ?>
        <div style="padding:16px 0;border-bottom:1px solid #f0f4f8;">
          <div style="font-size:14px;font-weight:700;color:#1a1a2e;margin-bottom:4px;"><?= h($o['name']) ?></div>
          <div style="font-size:13px;color:#718096;"><?= h($o['location']) ?></div>
          <div style="display:flex;gap:16px;margin-top:8px;">
            <a href="tel:<?= h($o['phone']) ?>" style="font-size:12px;color:#003893;text-decoration:none;">&#x260E; <?= h($o['phone']) ?></a>
            <a href="mailto:<?= h($o['email']) ?>" style="font-size:12px;color:#003893;text-decoration:none;">&#x2709; <?= h($o['email']) ?></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
