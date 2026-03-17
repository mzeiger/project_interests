<?php


 require("db_connect.php");

 $cb =  explode(":", $_POST['cb']);
 $personId = $cb[0];

 $sql = "select projectId from interest where personId = :personId";
 $query = $dbh->prepare($sql);
 $query->execute([":personId" => $personId]);
 $projectIds = $query->fetchAll(PDO::FETCH_ASSOC);

 $ar = [];
 foreach($projectIds as $projectId) {
     array_push($ar,'cb-' . $projectId['projectId']);
 }
 header("Content-Type: application/json");
 echo json_encode($ar) ;

?>