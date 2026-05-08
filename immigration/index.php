<?php
require_once __DIR__ . '/includes/functions.php';
$lang = getLang();
$currentPage = 'home';
$pageTitle = $lang === 'ne' ? 'अध्यागमन विभाग, नेपाल' : 'Department of Immigration, Nepal';
$isHome = true;
require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-tag">
      <span><?= $lang === 'ne' ? 'आधिकारिक अध्यागमन सेवा पोर्टल' : 'Official Immigration Services Portal' ?></span>
    </div>
    <h1 class="hero-h1">
      <?= $lang === 'ne' ? 'नेपालको ढोका, <em>सरल</em> बनाइएको।' : 'Your gateway to <em>Nepal</em>, made simple.' ?>
    </h1>
    <p class="hero-p">
      <?= $lang === 'ne'
        ? 'भिसा, ट्रेकिङ अनुमति र अध्यागमन सेवाहरू अनलाइन आवेदन गर्नुहोस्। सुरक्षित, पारदर्शी र २४/७ उपलब्ध।'
        : 'Apply for visas, trekking permits, and immigration services entirely online. Secure, transparent, and available 24/7 for international travellers.' ?>
    </p>
    <div class="task-row">
      <a href="#services" class="task-card primary">
        <div class="task-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
            <rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="13" y2="13"/>
          </svg>
        </div>
        <div>
          <div class="task-title"><?= $lang === 'ne' ? 'भिसाको लागि आवेदन' : 'Apply for a Visa' ?></div>
          <div class="task-desc"><?= $lang === 'ne' ? 'पर्यटक · व्यापार · ट्रान्जिट · विद्यार्थी' : 'Tourist · Business · Transit · Student' ?></div>
        </div>
      </a>
      <a href="pages/trekking.php" class="task-card">
        <div class="task-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
        </div>
        <div>
          <div class="task-title"><?= $lang === 'ne' ? 'ट्रेकिङ अनुमति' : 'Trekking Permit' ?></div>
          <div class="task-desc"><?= $lang === 'ne' ? 'प्रतिबन्धित क्षेत्रको व्यक्तिगत अनुमति' : 'Individual permit for restricted areas' ?></div>
        </div>
      </a>
      <a href="pages/track.php" class="task-card">
        <div class="task-icon">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
          </svg>
        </div>
        <div>
          <div class="task-title"><?= $lang === 'ne' ? 'आवेदन ट्र्याक' : 'Track Application' ?></div>
          <div class="task-desc"><?= $lang === 'ne' ? 'भिसा स्थिति जाँच्नुहोस्' : 'Check your visa status' ?></div>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- NOTICES & NEWS -->
<section class="nn-section" id="notices-news">
  <div class="section-head">
    <div class="section-head-left">
      <div class="section-bar"></div>
      <div>
        <div class="section-title"><?= $lang === 'ne' ? 'सूचना र समाचार' : 'Notices & News' ?></div>
        <div class="section-sub"><?= $lang === 'ne' ? 'ताजा अद्यावधिकहरूसँग जानकार रहनुहोस्' : 'Stay informed with the latest updates' ?></div>
      </div>
    </div>
  </div>
  <div class="nn-grid">
    <div class="nn-card" id="notices">
      <div class="nn-head notice-head">
        <span><?= $lang === 'ne' ? 'आधिकारिक सूचनाहरू' : 'Official Notices' ?></span>
        <a href="#notices"><?= $lang === 'ne' ? 'सबै हेर्नुहोस् →' : 'View all →' ?></a>
      </div>
      <?php
      $notices = [
        ['title_en' => 'Notice regarding trekking permits for restricted areas', 'title_ne' => 'प्रतिबन्धित क्षेत्रको ट्रेकिङ अनुमतिसम्बन्धी सूचना', 'meta' => '23 March 2025 · Administration Section'],
        ['title_en' => 'Revision of visa-on-arrival facility for Iranian nationals', 'title_ne' => 'इरानी नागरिकको भिसा-अन-अराइभल सुविधा संशोधन', 'meta' => '15 March 2025 · Visa Section'],
        ['title_en' => 'Visa services during the general election period', 'title_ne' => 'आम निर्वाचन अवधिमा भिसा सेवासम्बन्धी सूचना', 'meta' => '03 March 2025 · Administration Section'],
        ['title_en' => 'Public notice: Foreign Nationals Management Information System (FNMIS)', 'title_ne' => 'विदेशी नागरिक व्यवस्थापन सूचना प्रणाली (FNMIS)', 'meta' => '27 January 2025 · Administration Section'],
      ];
      foreach ($notices as $n): ?>
        <a class="nn-item" href="#notices">
          <div class="nn-dot notice"></div>
          <div>
            <div class="nn-title"><?= h($lang === 'ne' ? $n['title_ne'] : $n['title_en']) ?></div>
            <div class="nn-meta"><?= h($n['meta']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="nn-card" id="news">
      <div class="nn-head news-head">
        <span><?= $lang === 'ne' ? 'समाचार र अद्यावधिक' : 'News & Updates' ?></span>
        <a href="#news"><?= $lang === 'ne' ? 'सबै हेर्नुहोस् →' : 'View all →' ?></a>
      </div>
      <?php
      $news = [
        ['title_en' => 'Department launches new online payment system for visa applicants', 'title_ne' => 'विभागद्वारा नयाँ अनलाइन भुक्तानी प्रणाली सुरु', 'meta' => '05 April 2025'],
        ['title_en' => 'Inauguration of new immigration office building in Belhiya', 'title_ne' => 'बेलहिया अध्यागमन कार्यालयको नवनिर्मित भवन उद्घाटन', 'meta' => '18 March 2025'],
        ['title_en' => '5-day orientation training programme for immigration staff completed', 'title_ne' => '५ दिने अभिमुखीकरण तालिम कार्यक्रम सम्पन्न', 'meta' => '10 February 2025'],
        ['title_en' => 'Minister and Secretary visit to Department of Immigration', 'title_ne' => 'माननीय गृहमन्त्री र सचिवको अध्यागमन विभाग भ्रमण', 'meta' => '02 January 2025'],
      ];
      foreach ($news as $n): ?>
        <a class="nn-item" href="#news">
          <div class="nn-dot news"></div>
          <div>
            <div class="nn-title"><?= h($lang === 'ne' ? $n['title_ne'] : $n['title_en']) ?></div>
            <div class="nn-meta"><?= h($n['meta']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section" id="services">
  <div class="section-head">
    <div class="section-head-left">
      <div class="section-bar"></div>
      <div>
        <div class="section-title"><?= $lang === 'ne' ? 'हाम्रा सेवाहरू' : 'Our Services' ?></div>
        <div class="section-sub"><?= $lang === 'ne' ? 'आफ्नो अवस्थाअनुसार सही सेवा फेला पार्नुहोस्' : 'Find the right service for your situation' ?></div>
      </div>
    </div>
    <a href="#services" class="view-all"><?= $lang === 'ne' ? 'सबै सेवाहरू हेर्नुहोस्' : 'View all services' ?></a>
  </div>

  <div class="svc-group">
    <div class="svc-group-label"><?= $lang === 'ne' ? 'नेपाल प्रवेश' : 'Entering Nepal' ?></div>
    <div class="svc-row">
      <?php
      $entering = [
        ['icon' => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>', 'title_en' => 'Visa on Arrival', 'title_ne' => 'आगमनमा भिसा', 'desc_en' => 'Apply at airport terminal', 'desc_ne' => 'विमानस्थल टर्मिनलमा आवेदन', 'url' => 'pages/apply.php?type=arrival'],
        ['icon' => '<rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="9" x2="17" y2="9"/>', 'title_en' => 'Electronic Travel Auth.', 'title_ne' => 'इलेक्ट्रोनिक ट्राभेल अथराइजेसन', 'desc_en' => 'Apply online before arrival', 'desc_ne' => 'आगमनभन्दा पहिले अनलाइन आवेदन', 'url' => 'pages/apply.php?type=eta'],
        ['icon' => '<circle cx="12" cy="12" r="9"/><path d="M12 3a14 14 0 0 1 0 18M3 12h18"/>', 'title_en' => 'Visa from Mission', 'title_ne' => 'नेपाली नियोगबाट भिसा', 'desc_en' => 'Apply at embassy or consulate', 'desc_ne' => 'दूतावास वा वाणिज्य दूतावासमा आवेदन', 'url' => 'pages/apply.php?type=mission'],
        ['icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/>', 'title_en' => 'Entry Visa', 'title_ne' => 'प्रवेश भिसा', 'desc_en' => 'Apply for entry tourist visa', 'desc_ne' => 'प्रवेश पर्यटक भिसाको लागि आवेदन', 'url' => 'pages/apply.php?type=entry'],
      ];
      foreach ($entering as $s): ?>
        <a href="<?= h($s['url']) ?>" class="svc-card">
          <div class="svc-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><?= $s['icon'] ?></svg></div>
          <div class="svc-title"><?= h($lang === 'ne' ? $s['title_ne'] : $s['title_en']) ?></div>
          <div class="svc-desc"><?= h($lang === 'ne' ? $s['desc_ne'] : $s['desc_en']) ?></div>
          <div class="svc-arrow">›</div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="svc-group">
    <div class="svc-group-label"><?= $lang === 'ne' ? 'नेपालमा हुनुहुन्छ' : 'Already in Nepal' ?></div>
    <div class="svc-row">
      <?php
      $inNepal = [
        ['icon' => '<polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/>', 'title_en' => 'Visa Extension', 'title_ne' => 'भिसा विस्तार', 'desc_en' => 'Extend your current visa', 'desc_ne' => 'हालको भिसा विस्तार गर्नुहोस्', 'url' => 'pages/apply.php?type=extension'],
        ['icon' => '<polyline points="7 16 3 12 7 8"/><polyline points="17 8 21 12 17 16"/>', 'title_en' => 'Visa Conversion', 'title_ne' => 'भिसा रूपान्तरण', 'desc_en' => 'Convert to another visa type', 'desc_ne' => 'अर्को भिसा प्रकारमा रूपान्तरण', 'url' => 'pages/apply.php?type=conversion'],
        ['icon' => '<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>', 'title_en' => 'Track Application', 'title_ne' => 'आवेदन ट्र्याक', 'desc_en' => 'Check your application status', 'desc_ne' => 'आवेदनको वर्तमान स्थिति जाँच्नुहोस्', 'url' => 'pages/track.php'],
      ];
      foreach ($inNepal as $s): ?>
        <a href="<?= h($s['url']) ?>" class="svc-card">
          <div class="svc-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><?= $s['icon'] ?></svg></div>
          <div class="svc-title"><?= h($lang === 'ne' ? $s['title_ne'] : $s['title_en']) ?></div>
          <div class="svc-desc"><?= h($lang === 'ne' ? $s['desc_ne'] : $s['desc_en']) ?></div>
          <div class="svc-arrow">›</div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="svc-group">
    <div class="svc-group-label"><?= $lang === 'ne' ? 'ट्रेकिङ' : 'Trekking' ?></div>
    <div class="svc-row three">
      <?php
      $trekking = [
        ['icon' => '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>', 'title_en' => 'Individual Trekking Permit', 'title_ne' => 'व्यक्तिगत ट्रेकिङ अनुमति', 'desc_en' => 'Apply for permit to restricted areas', 'desc_ne' => 'प्रतिबन्धित क्षेत्रको अनुमतिको लागि आवेदन', 'url' => 'pages/trekking.php?action=apply'],
        ['icon' => '<path d="M9 11l3 3L22 4"/>', 'title_en' => 'Check Trekking Permit', 'title_ne' => 'ट्रेकिङ अनुमति जाँच', 'desc_en' => 'Verify a permit issued by Nepal', 'desc_ne' => 'नेपालद्वारा जारी अनुमति प्रमाणित', 'url' => 'pages/trekking.php?action=check'],
        ['icon' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>', 'title_en' => 'Permit Information', 'title_ne' => 'अनुमति जानकारी', 'desc_en' => 'Who needs a permit and where', 'desc_ne' => 'कसलाई र कहाँ अनुमति चाहिन्छ', 'url' => 'pages/trekking.php?action=info'],
      ];
      foreach ($trekking as $s): ?>
        <a href="<?= h($s['url']) ?>" class="svc-card">
          <div class="svc-icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2"><?= $s['icon'] ?></svg></div>
          <div class="svc-title"><?= h($lang === 'ne' ? $s['title_ne'] : $s['title_en']) ?></div>
          <div class="svc-desc"><?= h($lang === 'ne' ? $s['desc_ne'] : $s['desc_en']) ?></div>
          <div class="svc-arrow">›</div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- IMMIGRATION NETWORK -->
<section class="network-section">
  <div class="section-head">
    <div class="section-head-left">
      <div class="section-bar"></div>
      <div>
        <div class="section-title"><?= $lang === 'ne' ? 'अध्यागमन नेटवर्क' : 'Immigration Network' ?></div>
        <div class="section-sub"><?= $lang === 'ne' ? 'नेपालभरका क्षेत्रीय कार्यालयहरू' : 'Regional offices across Nepal' ?></div>
      </div>
    </div>
  </div>
  <div class="network-grid">
    <?php
    $offices = [
      ['en' => 'Tribhuwan International Airport', 'ne' => 'त्रिभुवन अन्तर्राष्ट्रिय विमानस्थल'],
      ['en' => 'Pokhara International Airport', 'ne' => 'पोखरा अन्तर्राष्ट्रिय विमानस्थल'],
      ['en' => 'Gautambuddha Int. Airport', 'ne' => 'गौतमबुद्ध अन्त. विमानस्थल'],
      ['en' => 'Biratnagar Immigration Office', 'ne' => 'विराटनगर अध्यागमन कार्यालय'],
      ['en' => 'Pashupatinagar Office', 'ne' => 'पशुपतिनगर कार्यालय'],
    ];
    foreach ($offices as $o): ?>
      <a href="pages/resources.php?tab=offices" class="net-card">
        <div class="net-pin">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
          </svg>
        </div>
        <div class="net-name"><?= h($lang === 'ne' ? $o['ne'] : $o['en']) ?></div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
