<?php

declare(strict_types=1);

require __DIR__ . '/db_connect.php';
require_once __DIR__ . '/password_reset_schema.php';

try {
    password_reset_ensure_table($dbh);
} catch (Throwable $e) {
    error_log('password_reset_ensure_table: ' . $e->getMessage());
    header('Location: reset_password.php?err=' . rawurlencode(
        'Could not set up password reset. Run password_reset_token.sql or grant CREATE on the database.'
    ));
    exit;
}

$token = trim($_POST['token'] ?? '');
$pwd = $_POST['pwd'] ?? '';
$pwd2 = $_POST['pwd2'] ?? '';

function reset_fail(string $msg): void
{
    header('Location: reset_password.php?token=' . rawurlencode($_POST['token'] ?? '') . '&err=' . rawurlencode($msg));
    exit;
}

if ($token === '' || !preg_match('/^[a-f0-9]{64}$/i', $token)) {
    header('Location: reset_password.php?err=' . rawurlencode('Invalid reset link.'));
    exit;
}

if ($pwd === '' || $pwd !== $pwd2) {
    reset_fail('Passwords must match and cannot be empty.');
}

if (strlen($pwd) < 8) {
    reset_fail('Password must be at least 8 characters.');
}

$tokenHash = hash('sha256', $token);

try {
    $stmt = $dbh->prepare(
        'SELECT pr.person_id FROM password_reset_token pr
         WHERE pr.token_hash = :th AND pr.expires_at > NOW() LIMIT 1'
    );
    $stmt->execute([':th' => $tokenHash]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        header('Location: reset_password.php?err=' . rawurlencode('This reset link is invalid or has expired. Request a new one from the sign-in page.'));
        exit;
    }

    $personId = (int) $row['person_id'];
    $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
    if ($pwdHash === false || strlen($pwdHash) > 200) {
        reset_fail('Could not set password. Please try again.');
    }

    $dbh->prepare('UPDATE person SET pwd = :p WHERE id = :id')->execute([
        ':p' => $pwdHash,
        ':id' => $personId,
    ]);
    $dbh->prepare('DELETE FROM password_reset_token WHERE person_id = :id')->execute([':id' => $personId]);

    header('Location: index.php?reset=1');
    exit;
} catch (Throwable $e) {
    error_log('password_reset_complete: ' . $e->getMessage());
    reset_fail('Reset failed. The database may need the password_reset_token table.');
}
