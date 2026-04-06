<?php

require('db_connect.php');

$email = $_POST['applicant_email'];

$sql = "select first_name, last_name from application where home_email = :home_email";
$query = $dbh->prepare($sql);
$query->execute([":home_email" => $email]);
$rows = $query->fetchAll(PDO::FETCH_ASSOC);
$fullName = sprintf('%s %s', 
    htmlspecialchars($rows[0]['first_name'], ENT_QUOTES, 'UTF-8'), 
    htmlspecialchars($rows[0]['last_name'], ENT_QUOTES, 'UTF-8')
);
echo $fullName;
