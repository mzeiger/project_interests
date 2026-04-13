<?php

/**
 * Copy to reset_mail_config.php and set values for your server.
 * Without reset_mail_config.php, reset emails use PHP mail() with a default From address.
 */

return [
    'from' => [
        'name' => 'Kiwanis Project Interests',
        'address' => 'noreply@yourdomain.org',
    ],
    'smtp' => [
        'enabled' => false,
        'host' => 'smtp.example.com',
        'port' => 587,
        'user' => '',
        'pass' => '',
        'secure' => 'tls',
    ],
];
