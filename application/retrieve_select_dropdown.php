    <?php
    require("db_connect.php");

    $sql = 'select home_email from application order by application_date DESC';
    $query = $dbh->prepare($sql);
    $query->execute();
    $emails = $query->fetchAll(PDO::FETCH_ASSOC);
    $rv = "";
    foreach ($emails as $email) {
        $rv .= '<option value="' . $email['home_email'] .  '">' . $email['home_email']  . '</option>' . " ";
    }
    echo $rv;
    ?>