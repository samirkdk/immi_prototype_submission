<?php

function normalizeText(string $value): string
{
    $value = trim($value);
    return preg_replace('/\s+/', ' ', $value) ?? $value;
}

function normalizePhone(string $value): string
{
    $value = trim($value);
    $value = str_replace([' ', '-', '(', ')'], '', $value);
    return $value;
}

function normalizePassport(string $value): string
{
    $value = strtoupper(trim($value));
    return preg_replace('/\s+/', '', $value) ?? $value;
}

function validateName(string $name): ?string
{
    $name = normalizeText($name);
    if ($name === '') return 'Full name is required.';
    if (mb_strlen($name) < 2 || mb_strlen($name) > 150) return 'Full name must be between 2 and 150 characters.';
    if (!preg_match('/^[\p{L}\p{M}\s\.\'\-]+$/u', $name)) return 'Full name contains invalid characters.';
    return null;
}

function validateNationality(string $nationality): ?string
{
    $nationality = normalizeText($nationality);
    if ($nationality === '') return 'Nationality is required.';
    if (mb_strlen($nationality) < 2 || mb_strlen($nationality) > 100) return 'Nationality must be between 2 and 100 characters.';
    return null;
}

function validateEmailAddress(string $email): ?string
{
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) return 'A valid email address is required.';
    if (mb_strlen($email) > 150) return 'Email is too long.';
    return null;
}

function validatePhoneNumber(string $phone): ?string
{
    $phone = normalizePhone($phone);
    if ($phone === '') return 'Phone number is required.';
    if (!preg_match('/^\+[1-9]\d{7,14}$/', $phone)) return 'Use international format (e.g. +9779800000000).';
    return null;
}

function validatePassportNumber(string $passport): ?string
{
    $passport = normalizePassport($passport);
    if ($passport === '') return 'Passport number is required.';
    if (!preg_match('/^[A-Z0-9]{5,20}$/', $passport)) return 'Passport number must be 5-20 letters/numbers.';
    return null;
}

function validatePastDate(string $date, string $label): ?string
{
    if (!isValidDate($date)) return "A valid {$label} is required.";
    if ($date >= date('Y-m-d')) return ucfirst($label) . ' must be in the past.';
    return null;
}

function validateEntryDateValue(string $date): ?string
{
    if (!isValidDate($date)) return 'A valid entry date is required.';
    if ($date < date('Y-m-d')) return 'Entry date cannot be in the past.';
    return null;
}

function validatePassportExpiryValue(string $passportExpiry, string $entryDate): ?string
{
    if (!isValidDate($passportExpiry)) return 'A valid passport expiry date is required.';
    if ($passportExpiry <= date('Y-m-d')) return 'Passport must be valid in the future.';
    if (isValidDate($entryDate)) {
        $required = date('Y-m-d', strtotime($entryDate . ' +6 months'));
        if ($passportExpiry < $required) return 'Passport must be valid for at least 6 months after entry date.';
    }
    return null;
}

function validateDurationDays($days): ?string
{
    $allowed = [15, 30, 60, 90];
    $days = (int) $days;
    if (!in_array($days, $allowed, true)) return 'Duration must be one of: 15, 30, 60, or 90 days.';
    return null;
}
