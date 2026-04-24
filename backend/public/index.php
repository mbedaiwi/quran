<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/SiteConfig.php';

use Sandroses\Quran\SiteConfig;

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'name' => 'Sandroses Quran mobile backend',
    'base_url' => SiteConfig::BASE_QURAN_URL,
    'allowed_hosts' => SiteConfig::allowedHosts(),
    'privacy' => SiteConfig::privacyMetadata(),
    'endpoints' => [
        '/privacy-policy.php',
        '/.well-known/apple-app-site-association',
        '/.well-known/assetlinks.json',
        '/hijri.php',
        '/hijri-demo.php',
    ],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
