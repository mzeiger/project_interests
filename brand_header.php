<?php

declare(strict_types=1);

/**
 * Shared club logo for full-page UIs. $assetDirPrefix is '' from project root,
 * '../' from application/, '../../' from application/print/.
 */
function mhk_brand_logo_src(string $assetDirPrefix = ''): string
{
    $p = str_replace('\\', '/', $assetDirPrefix);
    $p = rtrim($p, '/');
    $rel = ($p === '' ? '' : $p . '/') . 'images/mhk_std_logo_transparent%20640.png';

    return htmlspecialchars($rel, ENT_QUOTES, 'UTF-8');
}

function mhk_brand_logo(string $assetDirPrefix = '', ?string $homeHref = 'index.php', bool $wrapInLink = true): void
{
    $src = mhk_brand_logo_src($assetDirPrefix);
    echo '<div class="mhk-brand text-center py-2 px-2 mb-2">';
    if ($wrapInLink && $homeHref !== null && $homeHref !== '') {
        $h = htmlspecialchars($homeHref, ENT_QUOTES, 'UTF-8');
        echo '<a href="' . $h . '" class="d-inline-block text-decoration-none" title="Project Interests home">';
    }
    echo '<img src="' . $src . '" alt="Monument Hill Kiwanis" class="mhk-brand-logo" width="320" height="160" decoding="async">';
    if ($wrapInLink && $homeHref !== null && $homeHref !== '') {
        echo '</a>';
    }
    echo "</div>\n";
}
