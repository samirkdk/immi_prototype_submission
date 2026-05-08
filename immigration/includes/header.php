<?php
if (!isset($lang)) $lang = getLang();
$isHome = ($currentPage ?? '') === 'home';
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'ne' ? 'ne' : 'en' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($pageTitle ?? 'Department of Immigration, Nepal') ?></title>
  <link rel="stylesheet" href="<?= $rootPath ?? '' ?>assets/css/main.css">
</head>
<body data-lang="<?= $lang === 'ne' ? 'ne' : 'en' ?>">
<a href="#main-content" class="skip-link"><?= $lang === 'ne' ? 'मुख्य सामग्रीमा जानुहोस्' : 'Skip to main content' ?></a>

<!-- HEADER -->
<header class="site-header">
  <div class="header-inner">
    <a href="<?= $rootPath ?? '' ?>index.php" class="brand">
      <div class="seal">
        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5">
          <circle cx="12" cy="12" r="9"/>
          <path d="M12 3v4M12 17v4M3 12h4M17 12h4"/>
          <circle cx="12" cy="12" r="3" fill="rgba(255,255,255,0.15)"/>
        </svg>
      </div>
      <div class="brand-text">
        <span class="b-top"><?= $lang === 'ne' ? 'नेपाल सरकार · गृह मन्त्रालय' : 'Government of Nepal · Ministry of Home Affairs' ?></span>
        <span class="b-main"><?= $lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration' ?></span>
      </div>
    </a>
    <div class="header-right">
      <div class="lang-toggle">
        <a href="?lang=en" class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>" aria-current="<?= $lang === 'en' ? 'true' : 'false' ?>">EN</a>
        <a href="?lang=ne" class="lang-btn <?= $lang === 'ne' ? 'active' : '' ?>" aria-current="<?= $lang === 'ne' ? 'true' : 'false' ?>">नेपाली</a>
      </div>
    </div>
  </div>
</header>

<!-- NAVIGATION -->
<nav class="main-nav" id="main-nav" aria-label="Main navigation">
  <button type="button" class="nav-menu-btn" id="nav-menu-btn" aria-expanded="false" aria-controls="nav-inner">
    <span class="nav-menu-bars" aria-hidden="true"></span>
    <span class="sr-only"><?= $lang === 'ne' ? 'मेनु खोल्नुहोस् वा बन्द गर्नुहोस्' : 'Open or close menu' ?></span>
  </button>
  <div class="nav-inner" id="nav-inner">
    <a href="<?= $rootPath ?? '' ?>index.php" class="nav-link <?= ($currentPage ?? '') === 'home' ? 'active' : '' ?>" aria-label="Home">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="#fff"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
    </a>

    <!-- VISA -->
    <div class="nav-item">
      <button class="nav-link <?= in_array($currentPage ?? '', ['apply','track','fees']) ? 'active' : '' ?>">
        <?= $lang === 'ne' ? 'भिसा' : 'Visa' ?> <span class="chevron">▾</span>
      </button>
      <div class="dropdown" style="min-width:300px;">
        <div class="dd-section">
          <div class="dd-label"><?= $lang === 'ne' ? 'आवेदन' : 'Apply' ?></div>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/apply.php?type=arrival">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'आगमनमा भिसा' : 'Visa on Arrival' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'विमानस्थल टर्मिनलमा आवेदन' : 'Apply at the airport terminal' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/apply.php?type=eta">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="9" x2="17" y2="9"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'इलेक्ट्रोनिक ट्राभेल अथराइजेसन' : 'Electronic Travel Authorization' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'आगमनभन्दा पहिले अनलाइन आवेदन' : 'Apply online before arriving' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/apply.php?type=mission">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 3a14 14 0 0 1 0 18M3 12h18"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'नेपाली नियोगबाट भिसा' : 'Visa from Nepalese Mission' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'दूतावास वा वाणिज्य दूतावासमा आवेदन' : 'Apply at an embassy or consulate' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/apply.php?type=entry">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'प्रवेश भिसा' : 'Entry Visa' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'प्रवेश पर्यटक भिसाको लागि आवेदन' : 'Apply for entry tourist visa' ?></div></div>
          </a>
        </div>
        <div class="dd-divider"></div>
        <div class="dd-section">
          <div class="dd-label"><?= $lang === 'ne' ? 'व्यवस्थापन' : 'Manage' ?></div>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/apply.php?type=extension">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'भिसा विस्तार' : 'Visa Extension' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'हालको भिसा विस्तार गर्नुहोस्' : 'Extend your current visa' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/apply.php?type=conversion">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><polyline points="7 16 3 12 7 8"/><polyline points="17 8 21 12 17 16"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'भिसा रूपान्तरण' : 'Visa Conversion' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'अर्को भिसा प्रकारमा रूपान्तरण' : 'Convert to another visa type' ?></div></div>
          </a>
        </div>
        <div class="dd-divider"></div>
        <div class="dd-section">
          <div class="dd-label"><?= $lang === 'ne' ? 'जाँच' : 'Check' ?></div>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/track.php">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'आवेदन ट्र्याक' : 'Track Application' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'सन्दर्भ नम्बर प्रविष्ट गर्नुहोस्' : 'Enter your reference number' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/faq.php">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'भिसा शुल्क र छुट' : 'Visa Fees & Exemptions' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'हालको शुल्क र भिसामुक्त देशहरू' : 'Current fees and visa-free countries' ?></div></div>
          </a>
        </div>
      </div>
    </div>

    <!-- TREKKING -->
    <div class="nav-item">
      <button class="nav-link <?= ($currentPage ?? '') === 'trekking' ? 'active' : '' ?>">
        <?= $lang === 'ne' ? 'ट्रेकिङ' : 'Trekking' ?> <span class="chevron">▾</span>
      </button>
      <div class="dropdown">
        <div class="dd-section">
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/trekking.php?action=apply">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'ट्रेकिङ अनुमतिको लागि आवेदन' : 'Apply for Trekking Permit' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'प्रतिबन्धित क्षेत्रको व्यक्तिगत अनुमति' : 'Individual permit for restricted areas' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/trekking.php?action=check">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M9 11l3 3L22 4"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'ट्रेकिङ अनुमति जाँच' : 'Check Trekking Permit' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'ट्रेकिङ अनुमतिको स्थिति प्रमाणित' : 'Verify a permit status' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/trekking.php?action=info">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'अनुमति जानकारी' : 'Permit Information' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'कसलाई र कहाँ अनुमति चाहिन्छ' : 'Who needs a permit and where' ?></div></div>
          </a>
        </div>
      </div>
    </div>

    <!-- RESOURCES -->
    <div class="nav-item">
      <button class="nav-link <?= ($currentPage ?? '') === 'resources' ? 'active' : '' ?>">
        <?= $lang === 'ne' ? 'स्रोतहरू' : 'Resources' ?> <span class="chevron">▾</span>
      </button>
      <div class="dropdown">
        <div class="dd-section">
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/resources.php?tab=acts">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'ऐन र नियमहरू' : 'Acts & Regulations' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'अध्यागमन कानून कागजातहरू' : 'Immigration law documents' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/resources.php?tab=publications">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'प्रकाशन र प्रतिवेदनहरू' : 'Publications & Reports' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'आगमन, बुलेटिन, तथ्याङ्क' : 'Arrivals, bulletins, statistics' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/resources.php?tab=offices">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'अध्यागमन कार्यालयहरू' : 'Immigration Offices' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'नजिकको कार्यालय फेला पार्नुहोस्' : 'Find your nearest office' ?></div></div>
          </a>
        </div>
      </div>
    </div>

    <!-- HELP & FAQ -->
    <div class="nav-item">
      <button class="nav-link <?= ($currentPage ?? '') === 'help' ? 'active' : '' ?>">
        <?= $lang === 'ne' ? 'सहायता र FAQ' : 'Help & FAQ' ?> <span class="chevron">▾</span>
      </button>
      <div class="dropdown">
        <div class="dd-section">
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/faq.php">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'बारम्बार सोधिने प्रश्नहरू' : 'Frequently Asked Questions' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'सामान्य प्रश्नहरूका जवाफ' : 'Common queries answered' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/contact.php">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.88 12"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'सम्पर्क गर्नुहोस्' : 'Contact Us' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'हाम्रो टोलीसँग सम्पर्क' : 'Get in touch with our team' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/charter.php">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'नागरिक बडापत्र' : 'Citizen Charter' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'हाम्रा सेवा प्रतिबद्धताहरू' : 'Our service commitments' ?></div></div>
          </a>
        </div>
      </div>
    </div>

    <!-- ABOUT US -->
    <div class="nav-item">
      <button class="nav-link <?= ($currentPage ?? '') === 'about' ? 'active' : '' ?>">
        <?= $lang === 'ne' ? 'हाम्रोबारे' : 'About Us' ?> <span class="chevron">▾</span>
      </button>
      <div class="dropdown">
        <div class="dd-section">
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/about.php?tab=mission">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'मिशन र भिजन' : 'Mission & Vision' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'हाम्रा लक्ष्य र मूल्यहरू' : 'Our goals and values' ?></div></div>
          </a>
          <a class="dd-link" href="<?= $rootPath ?? '' ?>pages/about.php?tab=directors">
            <div class="dd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#003893" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h6M9 13h4"/></svg></div>
            <div class="dd-text"><div class="dd-title"><?= $lang === 'ne' ? 'पूर्व महानिर्देशकहरू' : 'Previous Directors General' ?></div><div class="dd-sub"><?= $lang === 'ne' ? 'नेतृत्वको इतिहास' : 'History of leadership' ?></div></div>
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<?php if (!$isHome && isset($breadcrumbs)): ?>
<nav class="breadcrumb" aria-label="Breadcrumb">
  <a href="<?= $rootPath ?? '' ?>index.php"><?= $lang === 'ne' ? 'गृहपृष्ठ' : 'Home' ?></a>
  <?php foreach ($breadcrumbs as $crumb): ?>
    <span class="bc-sep">›</span>
    <?php if (isset($crumb['url'])): ?>
      <a href="<?= h($crumb['url']) ?>"><?= h($crumb['label']) ?></a>
    <?php else: ?>
      <span class="bc-current"><?= h($crumb['label']) ?></span>
    <?php endif; ?>
  <?php endforeach; ?>
</nav>
<?php endif; ?>
<main id="main-content" class="site-main" tabindex="-1">
