<?php

declare(strict_types=1);

/**
 * Local dev: show reset URL in the browser instead of sending email (no mail server needed).
 * Triggers when the browser hits the site on localhost/127.0.0.1 from the same machine.
 *
 * Optional override file password_reset_local.override.php (gitignored) may return:
 *   ['use_browser_link' => true]  — always show link, never send email
 *   ['use_browser_link' => false] — always send email (even on localhost)
 */

function password_reset_use_browser_link(): bool
{
    $path = __DIR__ . '/password_reset_local.override.php';
    if (file_exists($path)) {
        $o = include $path;
        if (is_array($o) && array_key_exists('use_browser_link', $o)) {
            return (bool) $o['use_browser_link'];
        }
    }

    $addr = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!in_array($addr, ['127.0.0.1', '::1'], true)) {
        return false;
    }

    $h = strtolower($_SERVER['HTTP_HOST'] ?? '');
    if ($h === 'localhost' || $h === '127.0.0.1') {
        return true;
    }
    if (preg_match('/^127\.\d+\.\d+\.\d+(:\d+)?$/', $h)) {
        return true;
    }

    return str_ends_with($h, '.localhost');
}
