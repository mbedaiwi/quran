<?php

declare(strict_types=1);

namespace Sandroses\Quran;

final class SiteConfig
{
    public const BASE_QURAN_URL = 'https://www.sandroses.com/quran';

    /**
     * Allowed hostnames for embedded browsing.
     *
     * @return array<int, string>
     */
    public static function allowedHosts(): array
    {
        return [
            'www.sandroses.com',
            'sandroses.com',
        ];
    }

    /**
     * Minimal privacy metadata used by app stores and legal pages.
     *
     * @return array<string, string>
     */
    public static function privacyMetadata(): array
    {
        return [
            'controller' => 'Sandroses Quran',
            'email' => 'privacy@sandroses.com',
            'data_use' => 'App acts as a secure container for Quran web content. No in-app account creation in this starter.',
            'retention' => 'Server logs retained for operational security and troubleshooting.',
        ];
    }
}
