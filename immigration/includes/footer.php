<?php if (!isset($lang)) $lang = getLang(); ?>
</main>
<footer class="site-footer">
  <div class="footer-cols">
    <div class="fc">
      <div class="fbrand">
        <div class="seal-sm">
          <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5">
            <circle cx="12" cy="12" r="9"/>
            <path d="M12 3v4M12 17v4M3 12h4M17 12h4"/>
          </svg>
        </div>
        <div>
          <div class="fbrand-name"><?= $lang === 'ne' ? 'अध्यागमन विभाग' : 'Department of Immigration' ?></div>
          <div class="fbrand-sub"><?= $lang === 'ne' ? 'नेपाल सरकार' : 'Government of Nepal' ?></div>
        </div>
      </div>
      <p><?= $lang === 'ne' ? 'काठमाडौं, नेपाल' : 'Kathmandu, Nepal' ?></p>
      <a href="tel:015550000">&#x260E; 01-5550000</a>
      <a href="mailto:info@example.com">&#x2709; info@example.com</a>
    </div>
    <div class="fc">
      <h4><?= $lang === 'ne' ? 'संस्था लिङ्कहरू' : 'Organisation Links' ?></h4>
      <a href="https://opmcm.gov.np" target="_blank" rel="noopener" class="ext"><?= $lang === 'ne' ? 'प्रधानमन्त्री कार्यालय' : 'Office of the Prime Minister' ?></a>
      <a href="https://moha.gov.np" target="_blank" rel="noopener" class="ext"><?= $lang === 'ne' ? 'गृह मन्त्रालय' : 'Ministry of Home Affairs' ?></a>
      <a href="https://www.passport.gov.np" target="_blank" rel="noopener" class="ext"><?= $lang === 'ne' ? 'राहदानी विभाग' : 'Department of Passports' ?></a>
      <a href="https://tourism.gov.np" target="_blank" rel="noopener" class="ext"><?= $lang === 'ne' ? 'पर्यटन विभाग' : 'Department of Tourism' ?></a>
      <a href="https://mofa.gov.np" target="_blank" rel="noopener" class="ext"><?= $lang === 'ne' ? 'विदेशस्थ नेपाली नियोगहरू' : 'Nepalese Missions Abroad' ?></a>
    </div>
    <div class="fc">
      <h4><?= $lang === 'ne' ? 'कार्यालय समय' : 'Office Hours' ?></h4>
      <p><?= $lang === 'ne' ? 'आइत – बिही: बिहान १०:०० – साँझ ५:००' : 'Sun – Thu: 10:00 AM – 5:00 PM' ?></p>
      <p><?= $lang === 'ne' ? 'शुक्रबार: बिहान १०:०० – दिउँसो ३:००' : 'Friday: 10:00 AM – 3:00 PM' ?></p>
      <p><?= $lang === 'ne' ? 'पर्यटक भिसा (शनि र सार्वजनिक छुट्टी): ११:०० – १:००' : 'Tourist Visa (Sat & Holidays): 11:00 AM – 1:00 PM' ?></p>
      <p><?= $lang === 'ne' ? 'दर्ता समय: बिहान १०:३० – दिउँसो २:३०' : 'Submission: 10:30 AM – 2:30 PM' ?></p>
    </div>
    <div class="fc">
      <h4><?= $lang === 'ne' ? 'कर्मचारी पहुँच' : 'Staff Access' ?></h4>
      <p class="staff-note"><?= $lang === 'ne' ? 'दर्ता एजेन्सी र सरकारी कर्मचारीहरूका लागि मात्र' : 'For registered agencies and government staff only' ?></p>
      <a href="https://nepaliport.immigration.gov.np" target="_blank" rel="noopener" class="staff-link"><?= $lang === 'ne' ? 'ट्रेकिङ एजेन्सी पोर्टल' : 'Trekking Agency Portal' ?></a>
      
    </div>
  </div>
  <div class="footer-bar">
    <span><?= $lang === 'ne' ? '© २०२६ अध्यागमन विभाग, नेपाल। सर्वाधिकार सुरक्षित।' : '&copy; 2026 Department of Immigration, Nepal. All Rights Reserved.' ?></span>
    <span><?= $lang === 'ne' ? 'यो पृष्ठ लोड: ' : 'Page loaded: ' ?><?= date('d M Y, H:i') ?></span>
  </div>
</footer>
<script src="<?= $rootPath ?? '' ?>assets/js/main.js"></script>
</body>
</html>
