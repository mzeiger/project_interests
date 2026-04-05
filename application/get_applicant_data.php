<?php
require('db_connect.php');

$email = $_GET['email'] ?? '';

if (!$email) {
    echo json_encode(null);
    exit;
}

$sql = "SELECT * FROM application WHERE home_email = :home_email";
$query = $dbh->prepare($sql);
$query->execute([":home_email" => $email]);
$row = $query->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode($row);
} else {
    echo json_encode(null);
}
