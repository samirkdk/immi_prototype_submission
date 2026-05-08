<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'help';
$pageTitle = ($lang === 'ne' ? 'सम्पर्क' : 'Contact Us') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [['label' => $lang === 'ne' ? 'सहायता र FAQ' : 'Help & FAQ', 'url' => 'faq.php'], ['label' => $lang === 'ne' ? 'सम्पर्क' : 'Contact Us']];
require_once __DIR__ . '/../includes/header.php';
?>
<div class="page-wrap wide">
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:28px;">
    <div class="section-bar"></div>
    <h1 style="font-size:24px;font-weight:700;color:#1a1a2e;"><?= $lang === 'ne' ? 'सम्पर्क गर्नुहोस्' : 'Contact Us' ?></h1>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;margin-bottom:32px;">
    <div class="card" style="text-align:center;">
      <div style="width:48px;height:48px;border-radius:50%;background:#E6F1FB;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.88 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.82 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 5.91 5.91l.98-.98a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      </div>
      <div style="font-size:14px;font-weight:700;color:#1a1a2e;margin-bottom:6px;"><?= $lang === 'ne' ? 'फोन' : 'Phone' ?></div>
      <a href="tel:015550000" style="color:#003893;text-decoration:none;font-size:15px;font-weight:600;">01-5550000</a>
      <p style="font-size:12px;color:#a0aec0;margin-top:6px;"><?= $lang === 'ne' ? 'आइत–बिही, बिहान १०–साँझ ५' : 'Sun–Thu, 10am–5pm' ?></p>
    </div>
    <div class="card" style="text-align:center;">
      <div style="width:48px;height:48px;border-radius:50%;background:#E6F1FB;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      </div>
      <div style="font-size:14px;font-weight:700;color:#1a1a2e;margin-bottom:6px;"><?= $lang === 'ne' ? 'इमेल' : 'Email' ?></div>
      <a href="mailto:info@example.com" style="color:#003893;text-decoration:none;font-size:13px;font-weight:600;">info@example.com</a>
      <p style="font-size:12px;color:#a0aec0;margin-top:6px;"><?= $lang === 'ne' ? 'सामान्यतया २४ घण्टाभित्र जवाफ' : 'Usually responds within 24 hours' ?></p>
    </div>
    <div class="card" style="text-align:center;">
      <div style="width:48px;height:48px;border-radius:50%;background:#E6F1FB;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      </div>
      <div style="font-size:14px;font-weight:700;color:#1a1a2e;margin-bottom:6px;"><?= $lang === 'ne' ? 'कार्यालय ठेगाना' : 'Office Address' ?></div>
      <p style="font-size:13px;color:#718096;"><?= $lang === 'ne' ? 'काठमाडौं, नेपाल' : 'Kathmandu, Nepal' ?></p>
    </div>
  </div>
  <div class="card">
    <div class="card-title"><?= $lang === 'ne' ? 'कार्यालय समय' : 'Office Hours' ?></div>
    <table style="width:100%;font-size:13px;margin-top:12px;border-collapse:collapse;">
      <?php
      $hours = [
        ['day_en' => 'Sunday – Thursday', 'day_ne' => 'आइतबार – बिहीबार', 'hrs' => '10:00 AM – 5:00 PM'],
        ['day_en' => 'Friday', 'day_ne' => 'शुक्रबार', 'hrs' => '10:00 AM – 3:00 PM'],
        ['day_en' => 'Saturday & Public Holidays (Tourist Visa only)', 'day_ne' => 'शनिबार र सार्वजनिक बिदा (पर्यटक भिसा मात्र)', 'hrs' => '11:00 AM – 1:00 PM'],
        ['day_en' => 'Application submission window', 'day_ne' => 'आवेदन दर्ता समय', 'hrs' => '10:30 AM – 2:30 PM'],
      ];
      foreach ($hours as $h): ?>
        <tr style="border-bottom:1px solid #f0f4f8;">
          <td style="padding:10px 0;color:#2d3748;font-weight:500;"><?= h($lang === 'ne' ? $h['day_ne'] : $h['day_en']) ?></td>
          <td style="padding:10px 0;color:#003893;font-weight:600;text-align:right;"><?= h($h['hrs']) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
