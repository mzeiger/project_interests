<?php

require("db_connect.php");

$projectId = $_POST['projectId'];

$sql = 'Select lname, fname, projectName, estimatedTime, projectDescription, ';
$sql .= 'projectHead, email from v_project_person where interest_projectId = :projectId order by projectPosition';
$query = $dbh->prepare($sql);
$query->execute([":projectId" => $projectId]);
$rows = $query->fetchAll(PDO::FETCH_ASSOC);
if ($rows == false) {
    echo "false";
    return;
}

$txt = '<div style="text-align:center;">';
$txt .= '<p style="margin-top:2px;margin-bottom:2px;">' . 'Project: <span style="font-weight:bold;">' . $rows[0]['projectName'] . '</span></p>';
$txt .= '<p style="margin-top:2px;margin-bottom:2px;">' . 'Project Head: ' . $rows[0]['projectHead'] . '</p>';
$txt .= '<br/><br/>';
$txt .= '<span style="text-align:center;">People interested in this project</span>';
$txt .= '<table>';
$txt .= '<tr><th>Name</th><th>Email</th></tr>';
foreach ($rows as $row) {
    // fname + lname  projectName head
    $name = $row['fname'] . ' ' . $row['lname'];
    $email =  sprintf('<a href="mailto:%s">%s</a>', $row['email'], $row['email']);
    $txt .= sprintf('<tr><td>%s</td><td>%s</td></tr>', $name,  $email);
}
$txt .= '</table>';
$txt .= '</div>';
echo $txt;
