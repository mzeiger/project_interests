<?php

require('db_connect.php');

$email = $_POST['applicant_email'];

$sql = "select first_name, last_name from application where home_email = :home_email";
$query = $dbh->prepare($sql);
$query->execute([":home_email" => $email]);
$rows = $query->fetchAll(PDO::FETCH_ASSOC);
$fullName = sprintf('%s %s', $rows[0]['first_name'], $rows[0]['last_name']);
echo $fullName;
