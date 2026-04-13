<?php

session_start();

require __DIR__ . '/db_connect.php';

header('Content-Type: text/plain; charset=utf-8');

if (empty($_SESSION['person_id'])) {
    echo 'You must be signed in to save your projects.';
    exit;
}

$personId = (int) $_SESSION['person_id'];

//delete all the interests for this email
$sql = "delete from interest where personId = :personId";
$query = $dbh->prepare($sql) ;
$query->execute([":personId" => $personId]);


if (isset( $_POST['items'])) {
    $sql = "INSERT INTO interest (personId, projectId) VALUES (:personId, :projectId)";
    $query = $dbh->prepare($sql);

    $items = $_POST['items'];
    foreach ($items as $item) {
        $project = explode(":", $item);
        $projectId = $project[1];
        $query->execute([":personId" => $personId, ":projectId" => $projectId]) ;
        }
    echo "Projects successfully updated" ;
    } else {
        echo "No projects have been chosen";
    }

?>