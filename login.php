<?php

session_start();

require __DIR__ . '/db_connect.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$email = strtolower(trim($_POST['email'] ?? ''));
$pwd = $_POST['pwd'] ?? '';

if ($email === '' || $pwd === '') {
    echo json_encode(['ok' => false, 'error' => 'Email and password are required.']);
    exit;
}

try {
    $sql = 'SELECT id, email, pwd FROM person WHERE email = :email LIMIT 1';
    $query = $dbh->prepare($sql);
    $query->execute([':email' => $email]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if (!$row || !password_verify($pwd, $row['pwd'])) {
        echo json_encode(['ok' => false, 'error' => 'Invalid email or password.']);
        exit;
    }

    $_SESSION['person_id'] = (int) $row['id'];
    $_SESSION['person_email'] = $row['email'];

    echo json_encode(['ok' => true, 'email' => $row['email']]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Sign-in failed. Please try again.']);
}
