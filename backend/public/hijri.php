<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$timestamp = isset($_GET['timestamp']) ? (int) $_GET['timestamp'] : time();
$timezone = isset($_GET['tz']) ? (string) $_GET['tz'] : 'UTC';
$locale = isset($_GET['locale']) ? (string) $_GET['locale'] : 'en_US';
$adjustDays = isset($_GET['adjust_days']) ? max(-2, min(2, (int) $_GET['adjust_days'])) : 0;

try {
    $dateTimeZone = new DateTimeZone($timezone);
} catch (Throwable $exception) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid timezone']);
    exit;
}

$effectiveTimestamp = $timestamp + ($adjustDays * 86400);
$gregorian = new DateTimeImmutable('@' . $effectiveTimestamp);
$gregorian = $gregorian->setTimezone($dateTimeZone);

$calendar = IntlCalendar::createInstance($dateTimeZone, $locale . '@calendar=islamic');
$calendar->setTime((float) ($effectiveTimestamp * 1000));

$hijriYear = $calendar->get(IntlCalendar::FIELD_YEAR);
$hijriMonth = $calendar->get(IntlCalendar::FIELD_MONTH) + 1;
$hijriDay = $calendar->get(IntlCalendar::FIELD_DAY_OF_MONTH);
$weekday = $calendar->get(IntlCalendar::FIELD_DAY_OF_WEEK);

$hijriFormatter = new IntlDateFormatter(
    $locale . '@calendar=islamic',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    $timezone,
    IntlDateFormatter::TRADITIONAL,
    'EEEE, d MMMM y G'
);

$gregorianFormatter = new IntlDateFormatter(
    $locale,
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    $timezone,
    IntlDateFormatter::GREGORIAN,
    'EEEE, d MMMM y'
);

$hijriHuman = $hijriFormatter->format($gregorian);
$gregorianHuman = $gregorianFormatter->format($gregorian);

if ($hijriHuman === false || $gregorianHuman === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to format date']);
    exit;
}

echo json_encode([
    'timestamp' => $timestamp,
    'effective_timestamp' => $effectiveTimestamp,
    'timezone' => $timezone,
    'locale' => $locale,
    'adjust_days' => $adjustDays,
    'gregorian' => [
        'iso8601' => $gregorian->format(DateTimeInterface::ATOM),
        'human' => $gregorianHuman,
    ],
    'hijri' => [
        'year' => $hijriYear,
        'month' => $hijriMonth,
        'day' => $hijriDay,
        'weekday' => $weekday,
        'human' => $hijriHuman,
    ],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
