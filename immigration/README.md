# Nepal Department of Immigration — Prototype Setup Guide

## Requirements
- XAMPP (Apache + MySQL + PHP 8.x)
- Composer (for PHPMailer and Twilio SDK)
- A Gmail account with App Password enabled, and a Twilio account if you enable SMS

---

## Step 1 — Extract and place files
Extract the zip into your XAMPP htdocs folder:
```
C:/xampp/htdocs/immigration/   (Windows)
/Applications/XAMPP/htdocs/immigration/   (Mac)
```

---

## Step 2 — Install dependencies with Composer
Open a terminal inside the `immigration/` folder and run:
```bash
composer install
```
This installs PHPMailer and the Twilio SDK into the `vendor/` folder.

---

## Step 3 — Create the database
1. Start Apache and MySQL in XAMPP Control Panel
2. Open phpMyAdmin at http://localhost/phpmyadmin
3. Click "Import" and upload `config/setup.sql`
4. This creates the `immigration_db` database and all tables

---

## Step 4 — Configure database credentials
Edit `config/db.php` if your MySQL credentials differ:
```php
define('DB_USER', 'root');   // Your MySQL username
define('DB_PASS', '');       // Your MySQL password (empty by default in XAMPP)
```

---

## Step 5 — Configure email
Edit `config/mail.php`:
```php
define('MAIL_USERNAME', 'your-gmail@gmail.com');
define('MAIL_PASSWORD', 'your-16-char-app-password');
```

To get a Gmail App Password:
1. Go to your Google Account > Security
2. Enable 2-Step Verification
3. Go to App Passwords and create one for "Mail"

---

## Step 6 — Configure SMS
Edit `config/mail.php` with your Twilio credentials:
```php
define('TWILIO_SID', 'ACxxxxxxxxxxxxxxxx');
define('TWILIO_TOKEN', 'your-auth-token');
define('TWILIO_FROM', '+1234567890');
```
Set `SEND_SMS` to `true` when you are ready to send real SMS (trial or paid numbers).

---

## Step 7 — Run the prototype
Visit: http://localhost/immi_prototype_submission/immigration/admin/login.php

Admin panel: http://localhost/immi_prototype_submission/immigration/admin/login.php


After setup, generate your own password hash and update the `admin_users.password` field before first login.

---

## Project Structure
```
immigration/
  index.php              Homepage
  composer.json          Dependency manifest
  config/
    db.php               Database credentials
    mail.php             Email and SMS credentials
    setup.sql            Database setup script
  includes/
    functions.php        Shared utility functions
    header.php           Navigation and header
    footer.php           Footer
    notifications.php    Email and SMS sending
  assets/
    css/main.css         Stylesheet
    js/main.js           JavaScript
  pages/
    apply.php            Visa application form
    confirmation.php     Post-submission confirmation
    track.php            Application tracking
    faq.php              Frequently asked questions
    contact.php          Contact information
    about.php            Mission, vision, directors
    trekking.php         Trekking permits
    resources.php        Acts, publications, offices
    charter.php          Citizen charter
  admin/
    login.php            Admin login
    index.php            Admin dashboard
    logout.php           Session logout
  vendor/                Auto-created by Composer
```

---


