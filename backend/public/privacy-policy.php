<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/SiteConfig.php';

use Sandroses\Quran\SiteConfig;

$privacy = SiteConfig::privacyMetadata();
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sandroses Quran Privacy Policy</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 860px; margin: 2rem auto; line-height: 1.65; padding: 0 1rem; }
        h1, h2 { color: #1f2937; }
        code { background: #f3f4f6; padding: 0.15rem 0.35rem; border-radius: 4px; }
    </style>
</head>
<body>
<h1>Privacy Policy</h1>
<p>Effective date: April 24, 2026</p>

<h2>Who we are</h2>
<p><?= htmlspecialchars($privacy['controller'], ENT_QUOTES, 'UTF-8') ?></p>

<h2>How the app works</h2>
<p>
    The mobile app is a secure wrapper for <code><?= htmlspecialchars(SiteConfig::BASE_QURAN_URL, ENT_QUOTES, 'UTF-8') ?></code>.
    It is designed to present Quran content while applying mobile-platform security controls.
</p>

<h2>Data processing</h2>
<p><?= htmlspecialchars($privacy['data_use'], ENT_QUOTES, 'UTF-8') ?></p>
<p><?= htmlspecialchars($privacy['retention'], ENT_QUOTES, 'UTF-8') ?></p>

<h2>Contact</h2>
<p>Email: <a href="mailto:<?= htmlspecialchars($privacy['email'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($privacy['email'], ENT_QUOTES, 'UTF-8') ?></a></p>

<h2>Store compliance notice</h2>
<p>
    Apple App Privacy labels and Google Play Data safety disclosures must accurately reflect your production integrations
    (analytics, crash reporting, ads, sign-in, payments, etc.). Update this policy when those integrations change.
</p>
</body>
</html>
