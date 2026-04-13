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

$txt = '<div class="text-center mb-3"><img src="assets/mhk_std_logo_transparent_640.png" alt="Monument Hill Kiwanis" style="max-height:64px;width:auto;height:auto;" width="320" height="160" decoding="async"></div>';
$txt .= '<div class="text-center mb-4">';
$txt .= '<h4>Project: <span class="fw-bold">' . $rows[0]['projectName'] . '</span></h4>';
$txt .= '<p>Project Head: ' . $rows[0]['projectHead'] . '</p>';
$txt .= '</div>';

$txt .= '<h5 class="text-center mb-3">People interested in this project</h5>';
$txt .= '<div class="table-responsive" style="max-width: 600px; margin: 0 auto;">';
$txt .= '<table class="table table-striped table-bordered">';
$txt .= '<thead class="table-dark">';
$txt .= '<tr><th>Name</th><th>Email</th></tr>';
$txt .= '</thead>';
$txt .= '<tbody>';
foreach ($rows as $row) {
    $name = $row['fname'] . ' ' . $row['lname'];
    $email = sprintf('<a href="mailto:%s">%s</a>', $row['email'], $row['email']);
    $txt .= sprintf('<tr><td>%s</td><td>%s</td></tr>', $name, $email);
}
$txt .= '</tbody>';
$txt .= '</table>';
$txt .= '</div>';
echo $txt;
