<?php

declare(strict_types=1);

/**
 * One-shot: copy the club logo from the Windows Desktop into assets/.
 * Run: php tools/copy_mhk_logo_from_desktop.php
 */
$destDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets';
$dest = $destDir . DIRECTORY_SEPARATOR . 'mhk_std_logo_transparent_640.png';
$home = getenv('USERPROFILE') ?: getenv('HOME') ?: '';
$candidates = [];
foreach (
    [
        $home . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . 'mhk_std_logo_transparent 640.png',
        $home . DIRECTORY_SEPARATOR . 'OneDrive' . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . 'mhk_std_logo_transparent 640.png',
        $home . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . 'mhk_std_logo_transparent_640.png',
    ] as $p
) {
    if ($p !== '' && is_file($p)) {
        $candidates[] = $p;
    }
}
if ($candidates === [] && $home !== '') {
    foreach (glob($home . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . '*mhk*640*.png') ?: [] as $p) {
        $candidates[] = $p;
    }
    foreach (glob($home . DIRECTORY_SEPARATOR . 'OneDrive' . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . '*mhk*640*.png') ?: [] as $p) {
        $candidates[] = $p;
    }
}

if (!is_dir($destDir) && !mkdir($destDir, 0755, true)) {
    fwrite(STDERR, "Cannot create directory: {$destDir}\n");
    exit(1);
}

if ($candidates !== []) {
    $src = $candidates[0];
    if (!copy($src, $dest)) {
        fwrite(STDERR, "Copy failed: {$src} -> {$dest}\n");
        exit(1);
    }
    echo "Copied logo to {$dest}\n";
    exit(0);
}

fwrite(STDERR, "Logo not found on Desktop. Place mhk_std_logo_transparent 640.png on your Desktop and run again.\n");
exit(1);
