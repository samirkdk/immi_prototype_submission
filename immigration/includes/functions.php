<?php
require_once __DIR__ . '/../config/db.php';

// Generate unique reference number: NI-YYYYMMDD-XXXXX
function generateReference() {
    $db = getDB();
    do {
        $date = date('Ymd');
        $random = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5));
        $ref = "NI-{$date}-{$random}";
        $stmt = $db->prepare("SELECT id FROM visa_applications WHERE reference_number = ?");
        $stmt->execute([$ref]);
    } while ($stmt->fetch());
    return $ref;
}

// Sanitise output
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Validate date format YYYY-MM-DD
function isValidDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

// Get application by reference number
function getApplicationByRef($ref) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM visa_applications WHERE reference_number = ?");
    $stmt->execute([strtoupper(trim($ref))]);
    return $stmt->fetch();
}

// Status badge colours
function statusBadge($status) {
    $map = [
        'Submitted'    => ['bg' => '#E6F1FB', 'color' => '#0C447C', 'label' => 'Submitted'],
        'Under Review' => ['bg' => '#FAEEDA', 'color' => '#633806', 'label' => 'Under Review'],
        'Approved'     => ['bg' => '#EAF3DE', 'color' => '#27500A', 'label' => 'Approved'],
        'Rejected'     => ['bg' => '#FCEBEB', 'color' => '#791F1F', 'label' => 'Rejected'],
    ];
    return $map[$status] ?? $map['Submitted'];
}

// Status step index for progress bar
function statusStep($status) {
    $steps = ['Submitted' => 1, 'Under Review' => 2, 'Approved' => 3, 'Rejected' => 3];
    return $steps[$status] ?? 1;
}

// Current language helper
function getLang() {
    return ($_COOKIE['lang'] ?? 'en') === 'ne' ? 'ne' : 'en';
}
