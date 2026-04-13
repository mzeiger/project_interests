<?php

/**
 * Copy to password_reset_local.override.php (gitignored) to force behavior:
 *
 * use_browser_link true  — never send email; API always returns dev_reset_url (use on LAN IP, etc.)
 * use_browser_link false — always send email, even on localhost
 */

return [
    // Set true if you open the site by machine name/LAN IP and still want the on-screen link (do not use on public servers).
    'use_browser_link' => false,
];
