<?php
require 'db_connect.php';

$id = $_GET['id'];

$sql = "select fullDescription from project where id = :id";
$query = $dbh->prepare($sql);
$query->execute([":id" => $id]);
echo $query->fetchColumn();
