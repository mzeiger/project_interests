<?php

$txt = "";

require('db_connect.php');

//$email = $_POST['applicant_email'];
$email = $_REQUEST['applicant_email'];

$sql = "select * from application where home_email = :home_email";
$query = $dbh->prepare($sql);
$query->execute([":home_email" => $email]);
$rows = $query->fetchAll(PDO::FETCH_ASSOC);
if (empty($rows)) {
    $txt .= '<p class="not_found">Applicant not found</p>' . "\n";
    $txt .= "</body>\n</html>\n";
    echo $txt;
    return;
}

$row = $rows[0];

$bio = "";
if (trim($row['bio']) == '') {
    $bio = "None supplied";
} else {
    $bio = $row['bio'];
}

$skills = "";
if (trim($row['skills']) == '') {
    $skills = "None supplied";
} else {
    $skills = $row['skills'];
}

//$txt .= '<div style="border:1px solid blue;padding:5px;">';
$txt .= '<h1>Member Application</h1>';
$txt .= '<table>';
$txt .= sprintf("<tr><td colspan='2'><span style='font-weight:bold;font-size:20pt;'>%s %s</span></td></tr>\n", $row['first_name'], $row['last_name']);

$txt .= sprintf("<tr><td>Email</td><td style=\"font-size:20px;\"><a style=\"text-decoration:none;\" href=\"mailto:%s\">%s</a></td></tr>\n", $row['home_email'], $row['home_email']);
$txt .= sprintf("<tr><td>Address</td><td>%s <br/>%s, %s %s</td></tr>", $row['address'], $row['city'], $row['state'], $row['zip']);
$txt .= sprintf("<tr><td>Home Phone</td><td>%s</td></tr>\n", $row['home_phone']);
$txt .= sprintf("<tr><td>Cell Phone</td><td>%s</td></tr>\n", $row['cell_phone']);
$txt .= sprintf("<tr><td>Birthday</td><td>%s %s</td><tr>\n", $row['dob_month'], $row['dob_day']);
$txt .= sprintf("<tr><td>Spouse</td><td>%s</td></tr>\n", $row['spouse']);
$txt .= sprintf("<tr><td>Sponsor</td><td>%s</td></tr>\n", $row['sponsor']);
$txt .= sprintf("<tr><td>Application Date</td><td>%s</td></tr>\n", date_format(date_create($row['application_date']), "d-M-Y"));

$txt .= "<tr style=\"background-color:black;\"><td colspan=\"2\"></td></tr>\n";

$txt .= sprintf("<tr><td>Business Name</td><td>%s</td></tr>\n", $row['business_name']);
$txt .= sprintf("<tr><td>Job Title</td><td>%s</td></tr>", $row['job_title']);
$txt .= sprintf("<tr><td>Business Address</td><td>%s</td></tr>", $row['business_address']);
$txt .= sprintf("<tr><td>Business Email</td><td>%s</td></tr>", $row['business_email']);

$txt .= "</table>\n";
$txt .= '<br/>';
$txt .= '<strong>BIO</strong><br/><br/>';
$txt .= sprintf('<div class="bio">%s</div>', $bio);
$txt .= '<br/>';
$txt .= '<strong>Skills</strong><br/><br/>';
$txt .= sprintf('<div class="skills">%s</div>', $skills);

$heard_about = '';
if ($row['saw_ads'] == 1) {
    $heard_about .= 'Saw an ad<br>';
}
if ($row['saw_website'] == 1) {
    $heard_about .= 'Saw website<br>';
}
if ($row['saw_facebook'] == 1) {
    $heard_about .= 'Saw Facebook<br>';
}
if ($row['saw_friend'] == 1) {
    $heard_about .= 'Heard from friend<br>';
}
if ($heard_about != '') {
    $txt .= '<br/><strong>How did applicant hear about us</strong></br></br>';
    $txt .= sprintf('<div style="border:solid 1px black;padding 3px;">%s</div>', $heard_about);
}

$txt .= '</div>'; // end of surround border
// $txt .= '<div class="no-print" style="text-align: center;">';

$txt .= '<br/>';
//$txt .= '<div class="no-print" style="display:flex;justify-content:center;">';

//$txt .= '<button onclick="window.print()">Print Page</button>';
//$txt .= '</div>';
echo $txt;
