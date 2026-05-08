<?php
require_once __DIR__ . '/../includes/functions.php';
$lang = getLang();
$rootPath = '../';
$currentPage = 'help';
$pageTitle = ($lang === 'ne' ? 'बारम्बार सोधिने प्रश्नहरू' : 'Frequently Asked Questions') . ' — ' . ($lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration');
$breadcrumbs = [['label' => $lang === 'ne' ? 'सहायता र FAQ' : 'Help & FAQ', 'url' => '#'], ['label' => $lang === 'ne' ? 'बारम्बार सोधिने प्रश्नहरू' : 'FAQ']];

$faqs = [
  ['q_en' => 'How do I apply for a tourist visa to Nepal?', 'q_ne' => 'नेपालको पर्यटक भिसाको लागि कसरी आवेदन गर्ने?', 'a_en' => 'You can apply for a tourist visa on arrival at Tribhuwan International Airport, Pokhara International Airport, or Gautambuddha International Airport. Alternatively, apply online through this portal before arrival or visit a Nepalese embassy or consulate in your country.', 'a_ne' => 'तपाईं त्रिभुवन अन्तर्राष्ट्रिय विमानस्थल, पोखरा अन्तर्राष्ट्रिय विमानस्थल, वा गौतमबुद्ध अन्तर्राष्ट्रिय विमानस्थलमा आगमनमा पर्यटक भिसाको लागि आवेदन दिन सक्नुहुन्छ।'],
  ['q_en' => 'How long can I stay in Nepal on a tourist visa?', 'q_ne' => 'पर्यटक भिसामा नेपालमा कति समय बस्न सकिन्छ?', 'a_en' => 'Tourist visas are issued for 15, 30, or 90 days. You may apply for an extension if needed. The maximum stay for most nationalities is 150 days per visa year (January to December).', 'a_ne' => 'पर्यटक भिसा १५, ३०, वा ९० दिनको लागि जारी गरिन्छ। आवश्यक परेमा विस्तारको लागि आवेदन दिन सक्नुहुन्छ।'],
  ['q_en' => 'How do I track my visa application?', 'q_ne' => 'मेरो भिसा आवेदन कसरी ट्र्याक गर्ने?', 'a_en' => 'After submitting your application, you will receive a unique reference number by email and SMS. Visit the Track Application page and enter your reference number to see the current status.', 'a_ne' => 'आवेदन पेश गरेपछि, तपाईंले इमेल र SMS द्वारा एउटा अनन्य सन्दर्भ नम्बर प्राप्त गर्नुहुनेछ। आवेदन ट्र्याक पृष्ठमा जानुहोस् र वर्तमान स्थिति हेर्न सन्दर्भ नम्बर प्रविष्ट गर्नुहोस्।'],
  ['q_en' => 'What documents do I need for a visa application?', 'q_ne' => 'भिसा आवेदनको लागि कुन कागजातहरू चाहिन्छन्?', 'a_en' => 'You will need a valid passport (minimum 6 months validity), a completed application form, a passport-size photograph, and the applicable visa fee. Additional documents may be required depending on the visa type.', 'a_ne' => 'तपाईंलाई वैध राहदानी (न्यूनतम ६ महिना), भरिएको आवेदन फारम, पासपोर्ट साइज फोटो र लागू भिसा शुल्क चाहिनेछ।'],
  ['q_en' => 'How do I extend my visa?', 'q_ne' => 'मेरो भिसा कसरी विस्तार गर्ने?', 'a_en' => 'Visit the Department of Immigration in Kathmandu, Nepal or any regional immigration office before your current visa expires. You can also apply online through this portal. Bring your passport, current visa, and a passport-size photograph.', 'a_ne' => 'तपाईंको हालको भिसा म्याद सकिनुभन्दा पहिले काठमाडौं, नेपालस्थित अध्यागमन विभाग वा कुनै पनि क्षेत्रीय अध्यागमन कार्यालयमा जानुहोस्।'],
  ['q_en' => 'Do I need a trekking permit for all trekking areas?', 'q_ne' => 'के सबै ट्रेकिङ क्षेत्रहरूको लागि ट्रेकिङ अनुमति चाहिन्छ?', 'a_en' => 'Not all trekking areas require a permit from the Department of Immigration. However, restricted areas such as Mustang, Manaslu, Dolpo, and Humla require a special permit. Most national park areas require a separate TIMS card and national park entry fee.', 'a_ne' => 'सबै ट्रेकिङ क्षेत्रहरूलाई अध्यागमन विभागको अनुमति आवश्यक पर्दैन। तर मुस्ताङ, मनास्लु, डोल्पो र हुम्ला जस्ता प्रतिबन्धित क्षेत्रहरूको लागि विशेष अनुमति चाहिन्छ।'],
  ['q_en' => 'What are the office hours for the Department of Immigration?', 'q_ne' => 'अध्यागमन विभागको कार्यालय समय के हो?', 'a_en' => 'Sunday to Thursday: 10:00 AM – 5:00 PM. Friday: 10:00 AM – 3:00 PM. Tourist visa services on Saturday and public holidays: 11:00 AM – 1:00 PM. Application submission hours: 10:30 AM – 2:30 PM.', 'a_ne' => 'आइतबार देखि बिहीबार: बिहान १०:०० – साँझ ५:००। शुक्रबार: बिहान १०:०० – दिउँसो ३:००। शनिबार र सार्वजनिक बिदा: ११:०० – १:०० (पर्यटक भिसा)।'],
];

require_once __DIR__ . '/../includes/header.php';
?>
<div class="page-wrap wide">
  <div style="margin-bottom:32px;">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
      <div class="section-bar"></div>
      <h1 style="font-size:24px;font-weight:700;color:#1a1a2e;"><?= $lang === 'ne' ? 'बारम्बार सोधिने प्रश्नहरू' : 'Frequently Asked Questions' ?></h1>
    </div>
    <p style="color:#718096;font-size:14px;"><?= $lang === 'ne' ? 'भिसा, ट्रेकिङ अनुमति र अध्यागमन सेवाहरूसम्बन्धी सामान्य प्रश्नहरूका जवाफ।' : 'Answers to common questions about visas, trekking permits, and immigration services.' ?></p>
  </div>

  <?php foreach ($faqs as $i => $faq): ?>
    <div class="card" style="margin-bottom:12px;padding:20px 24px;cursor:pointer;" onclick="this.querySelector('.faq-ans').style.display=this.querySelector('.faq-ans').style.display==='none'?'block':'none'">
      <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;">
        <div style="font-size:14px;font-weight:600;color:#1a1a2e;"><?= h($lang === 'ne' ? $faq['q_ne'] : $faq['q_en']) ?></div>
        <div style="font-size:20px;color:#003893;flex-shrink:0;">+</div>
      </div>
      <div class="faq-ans" style="display:none;margin-top:12px;font-size:13px;color:#718096;line-height:1.7;border-top:1px solid #f0f4f8;padding-top:12px;">
        <?= h($lang === 'ne' ? $faq['a_ne'] : $faq['a_en']) ?>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="card" style="margin-top:24px;background:#f7f8fa;text-align:center;">
    <p style="font-size:14px;color:#718096;margin-bottom:12px;"><?= $lang === 'ne' ? 'आफ्नो प्रश्नको जवाफ भेट्टाउन सक्नुभएन?' : "Can't find the answer to your question?" ?></p>
    <a href="contact.php" class="btn btn-primary"><?= $lang === 'ne' ? 'हामीलाई सम्पर्क गर्नुहोस्' : 'Contact Us' ?></a>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
