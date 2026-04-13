<?php

session_start();

require __DIR__ . '/db_connect.php';

header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['person_id'])) {
    echo json_encode([]);
    exit;
}

$personId = (int) $_SESSION['person_id'];

$sql = "select projectId from interest where personId = :personId";
$query = $dbh->prepare($sql);
$query->execute([':personId' => $personId]);
$projectIds = $query->fetchAll(PDO::FETCH_ASSOC);

$ar = [];
foreach ($projectIds as $projectId) {
    $ar[] = 'cb-' . $projectId['projectId'];
}
echo json_encode($ar);
