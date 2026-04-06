    <?php
    require("db_connect.php");

    $sql = 'select home_email from application order by application_date DESC';
    $query = $dbh->prepare($sql);
    $query->execute();
    $emails = $query->fetchAll(PDO::FETCH_ASSOC);
    $rv = "";
    foreach ($emails as $email) {
        $safe_email = htmlspecialchars($email['home_email'], ENT_QUOTES, 'UTF-8');
        $rv .= '<option value="' . $safe_email .  '">' . $safe_email  . '</option>' . " ";
    }
    echo $rv;
    ?>