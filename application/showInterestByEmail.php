<?php

require 'db_connect.php';

$email = $_POST['email'];

$sql = "select projectName, fname, lname, projectDescription from v_project_person where email = :email order by projectName";
$query = $dbh->prepare($sql);
$query->execute([":email" => $email]);
$projects = $query->fetchAll(PDO::FETCH_ASSOC);
if (count($projects) == 0) {
    $txt = '<h1>Interests</h1>';
    $txt .= '<p style="font-weight:bold;">No interests found for this applicant</p>';
    echo $txt;
    return;
}

$txt = "";
$txt .= '<div>';
$txt .= '<h1>Interests</h1>';

$txt .= '<div>';
$txt .= '<table>';
foreach ($projects as $project) {
    $txt .= sprintf('<tr><td>%s</td ><td>%s</td></tr>', $project['projectName'], $project['projectDescription']);
}
$txt .= '</table>';
$txt .= '</div>';
$txt .= '</div>';

echo $txt;
