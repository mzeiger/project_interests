<?php

//echo $_POST['email'];
//echo "<br/>";

require('db_connect.php') ;

$person = explode(':', $_POST['email_list']);
$personId = $person[0] ;

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