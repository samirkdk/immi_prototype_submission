// Nepal Department of Immigration — Main JS

const navMq = window.matchMedia('(max-width: 900px)');
const pageLang = document.body?.dataset?.lang === 'ne' ? 'ne' : 'en';
const i18n = {
  required: { en: 'This field is required.', ne: 'यो फिल्ड आवश्यक छ।' },
  email: { en: 'Enter a valid email address.', ne: 'मान्य इमेल ठेगाना प्रविष्ट गर्नुहोस्।' },
  phone: { en: 'Use international format, e.g. +9779800000000.', ne: 'अन्तर्राष्ट्रिय ढाँचा प्रयोग गर्नुहोस्, जस्तै +9779800000000।' },
  passport: { en: 'Passport number must be 5-20 letters/numbers.', ne: 'राहदानी नम्बर 5-20 अक्षर/अंक हुनुपर्छ।' },
  dobPast: { en: 'Date of birth must be in the past.', ne: 'जन्म मिति विगतको हुनुपर्छ।' },
  entryFuture: { en: 'Entry date cannot be in the past.', ne: 'प्रवेश मिति विगतमा हुन सक्दैन।' },
  duration: { en: 'Duration must be 15, 30, 60, or 90 days.', ne: 'अवधि 15, 30, 60 वा 90 दिन हुनुपर्छ।' }
};

function t(key) {
  return i18n[key]?.[pageLang] || i18n[key]?.en || key;
}

function initMobileNav() {
  const mainNav = document.getElementById('main-nav');
  const menuBtn = document.getElementById('nav-menu-btn');
  const navInner = document.getElementById('nav-inner');
  if (!mainNav || !menuBtn || !navInner) return;

  function closeSubmenus() {
    mainNav.querySelectorAll('.nav-item.is-expanded').forEach((item) => {
      item.classList.remove('is-expanded');
      const b = item.querySelector(':scope > button.nav-link');
      if (b) b.setAttribute('aria-expanded', 'false');
    });
  }

  function setMenuOpen(open) {
    mainNav.classList.toggle('nav-open', open);
    menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.classList.toggle('nav-open', open);
    if (!open) closeSubmenus();
  }

  menuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    if (!navMq.matches) return;
    setMenuOpen(!mainNav.classList.contains('nav-open'));
  });

  mainNav.querySelectorAll('.nav-item > button.nav-link').forEach((btn) => {
    btn.setAttribute('aria-expanded', 'false');
    btn.addEventListener('click', (e) => {
      if (!navMq.matches) return;
      e.preventDefault();
      e.stopPropagation();
      const item = btn.closest('.nav-item');
      if (!item) return;
      const willOpen = !item.classList.contains('is-expanded');
      mainNav.querySelectorAll('.nav-item.is-expanded').forEach((other) => {
        if (other !== item) {
          other.classList.remove('is-expanded');
          const ob = other.querySelector(':scope > button.nav-link');
          if (ob) ob.setAttribute('aria-expanded', 'false');
        }
      });
      item.classList.toggle('is-expanded', willOpen);
      btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
    });
  });

  document.addEventListener('click', (e) => {
    if (!navMq.matches || !mainNav.classList.contains('nav-open')) return;
    if (!mainNav.contains(e.target)) setMenuOpen(false);
  });

  navMq.addEventListener('change', () => {
    if (!navMq.matches) {
      setMenuOpen(false);
      closeSubmenus();
    }
  });

  navInner.addEventListener('click', (e) => {
    if (!navMq.matches) return;
    const link = e.target.closest('a.dd-link, a.nav-link');
    if (!link || !link.getAttribute('href')) return;
    const href = link.getAttribute('href');
    if (href.startsWith('#')) return;
    setMenuOpen(false);
  });
}

initMobileNav();

// Language toggle via cookie
document.querySelectorAll('.lang-btn').forEach(btn => {
  btn.addEventListener('click', function(e) {
    const url = new URL(window.location.href);
    const lang = this.href.includes('lang=ne') ? 'ne' : 'en';
    document.cookie = `lang=${lang};path=/;max-age=31536000`;
  });
});

function getInlineErrorEl(field) {
  if (!field || !field.parentElement) return null;
  return field.parentElement.querySelector('.error-msg');
}

function setFieldError(field, message) {
  const errorEl = getInlineErrorEl(field);
  if (message) {
    field.classList.add('error');
    field.setAttribute('aria-invalid', 'true');
    if (errorEl) errorEl.textContent = message;
    return false;
  }
  field.classList.remove('error');
  field.removeAttribute('aria-invalid');
  if (errorEl) errorEl.textContent = '';
  return true;
}

function validateField(field) {
  if (!field) return true;
  const value = field.value.trim();
  const name = field.name;
  if (field.hasAttribute('required') && !value) return setFieldError(field, t('required'));

  if (name === 'email' && value) {
    const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    if (!ok) return setFieldError(field, t('email'));
  }

  if (name === 'phone' && value) {
    const normalized = value.replace(/[\s\-()]/g, '');
    const ok = /^\+[1-9]\d{7,14}$/.test(normalized);
    if (!ok) return setFieldError(field, t('phone'));
  }

  if (name === 'passport_number' && value) {
    const normalized = value.replace(/\s+/g, '').toUpperCase();
    field.value = normalized;
    const ok = /^[A-Z0-9]{5,20}$/.test(normalized);
    if (!ok) return setFieldError(field, t('passport'));
  }

  if (name === 'date_of_birth' && value) {
    const today = new Date().toISOString().slice(0, 10);
    if (value >= today) return setFieldError(field, t('dobPast'));
  }

  if (name === 'entry_date' && value) {
    const today = new Date().toISOString().slice(0, 10);
    if (value < today) return setFieldError(field, t('entryFuture'));
  }

  if (name === 'duration_days' && value) {
    const allowed = ['15', '30', '60', '90'];
    if (!allowed.includes(value)) return setFieldError(field, t('duration'));
  }

  return setFieldError(field, '');
}

// Form validation helper
function validateForm(formId) {
  const form = document.getElementById(formId);
  if (!form) return true;
  let valid = true;
  const fields = form.querySelectorAll('input, select, textarea');
  fields.forEach(field => {
    if (!validateField(field)) valid = false;
  });
  return valid;
}

['visa-form', 'eligibility-form'].forEach((formId) => {
  const form = document.getElementById(formId);
  if (!form) return;
  const fields = form.querySelectorAll('input, select, textarea');
  fields.forEach((field) => {
    field.addEventListener('blur', () => validateField(field));
    field.addEventListener('input', () => {
      if (field.classList.contains('error')) validateField(field);
    });
  });
  form.addEventListener('submit', (e) => {
    if (!validateForm(formId)) e.preventDefault();
  });
});

// Auto-dismiss only non-critical alerts after 8 seconds
document.querySelectorAll('.alert-success, .alert-info').forEach(alert => {
  setTimeout(() => {
    alert.style.transition = 'opacity 0.5s';
    alert.style.opacity = '0';
    setTimeout(() => alert.remove(), 500);
  }, 8000);
});

// Track form — uppercase reference input
const refInput = document.getElementById('reference_number');
if (refInput) {
  refInput.addEventListener('input', function() {
    this.value = this.value.toUpperCase();
  });
}

// Confirm before status change in admin
document.querySelectorAll('.status-select').forEach(sel => {
  sel.addEventListener('change', function() {
    const ref = this.dataset.ref;
    if (!confirm(`Update status for ${ref} to "${this.value}"?`)) {
      this.value = this.dataset.original;
    }
  });
});
