<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'about';
$tab = $_GET['tab'] ?? 'mission';
$pageTitle = ($lang === 'ne' ? 'हाम्रोबारे' : 'About Us') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [['label' => $lang === 'ne' ? 'हाम्रोबारे' : 'About Us']];
require_once __DIR__ . '/../includes/header.php';
?>
<div class="page-wrap wide">
  <div style="display:flex;gap:8px;margin-bottom:28px;border-bottom:2px solid #f0f4f8;padding-bottom:0;">
    <?php foreach ([['mission','Mission & Vision','मिशन र भिजन'],['directors','Previous Directors General','पूर्व महानिर्देशकहरू']] as [$t,$en,$ne]): ?>
      <a href="?tab=<?= $t ?>" style="padding:10px 20px;font-size:13px;font-weight:600;text-decoration:none;border-bottom:3px solid <?= $tab===$t ? '#DC143C' : 'transparent' ?>;color:<?= $tab===$t ? '#DC143C' : '#718096' ?>;margin-bottom:-2px;">
        <?= $lang === 'ne' ? $ne : $en ?>
      </a>
    <?php endforeach; ?>
  </div>

  <?php if ($tab === 'mission'): ?>
    <div class="card">
      <div class="card-title"><?= $lang === 'ne' ? 'मिशन' : 'Mission' ?></div>
      <p style="font-size:14px;color:#718096;line-height:1.8;margin-top:12px;">
        <?= $lang === 'ne'
          ? 'नेपाल अध्यागमन विभागको मिशन देशको सार्वभौमसत्ता र सुरक्षालाई सम्मान गर्दै अन्तर्राष्ट्रिय यात्रुहरूलाई प्रभावकारी, पारदर्शी र सुलभ अध्यागमन सेवा प्रदान गर्नु हो।'
          : 'The mission of the Department of Immigration is to provide effective, transparent, and accessible immigration services to international travellers while upholding the sovereignty and security of Nepal.' ?>
      </p>
    </div>
    <div class="card" style="margin-top:16px;">
      <div class="card-title"><?= $lang === 'ne' ? 'भिजन' : 'Vision' ?></div>
      <p style="font-size:14px;color:#718096;line-height:1.8;margin-top:12px;">
        <?= $lang === 'ne'
          ? 'एउटा आधुनिक, प्रविधिमैत्री र नागरिककेन्द्रित अध्यागमन प्रणाली निर्माण गर्नु जसले नेपालको पर्यटन र आर्थिक विकासलाई टेवा दिन्छ।'
          : 'To build a modern, technology-driven, and citizen-centred immigration system that supports Nepal\'s tourism industry and economic development.' ?>
      </p>
    </div>
  <?php else: ?>
    <div class="card">
      <div class="card-title"><?= $lang === 'ne' ? 'पूर्व महानिर्देशकहरू' : 'Previous Directors General' ?></div>
      <p style="font-size:13px;color:#a0aec0;margin-top:4px;margin-bottom:20px;"><?= $lang === 'ne' ? 'अध्यागमन विभागको नेतृत्व इतिहास' : 'Leadership history of the Department of Immigration' ?></p>
      <table style="width:100%;font-size:13px;border-collapse:collapse;">
        <thead><tr style="background:#f7f8fa;">
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#374151;font-size:12px;"><?= $lang === 'ne' ? 'नाम' : 'Name' ?></th>
          <th style="padding:10px 14px;text-align:left;font-weight:600;color:#374151;font-size:12px;"><?= $lang === 'ne' ? 'कार्यकाल' : 'Tenure' ?></th>
        </tr></thead>
        <tbody>
          <?php
          $dgs = [['John Doe','2023 – Present'],['Jane Doe','2021 – 2023'],['Alex Doe','2019 – 2021'],['Chris Doe','2017 – 2019'],['Sam Doe','2015 – 2017']];
          foreach ($dgs as $i => $dg): ?>
            <tr style="border-bottom:1px solid #f0f4f8;">
              <td style="padding:12px 14px;color:#1a1a2e;font-weight:500;"><?= h($dg[0]) ?></td>
              <td style="padding:12px 14px;color:#718096;"><?= h($dg[1]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
