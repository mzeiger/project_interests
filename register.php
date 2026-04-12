<?php

require("db_connect.php");

try {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $pwdPlain = $_POST['pwd'] ?? '';

    if ($email === '' || $fname === '' || $lname === '' || $pwdPlain === '') {
        echo 'All fields including password are required.';
        exit;
    }

    if (strlen($email) > 50 || strlen($fname) > 20 || strlen($lname) > 30) {
        echo 'One or more fields exceed the maximum length allowed.';
        exit;
    }

    if (strlen($pwdPlain) < 8) {
        echo 'Password must be at least 8 characters.';
        exit;
    }

    $pwdHash = password_hash($pwdPlain, PASSWORD_DEFAULT);
    if ($pwdHash === false || strlen($pwdHash) > 200) {
        echo 'Could not set password. Please try again.';
        exit;
    }

    $sql = 'select * from person where email = :email';
    $query = $dbh->prepare($sql);
    $query->execute([':email' => $email]);
    $row = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($row)) {
        $sql = "INSERT INTO `person`(`email`, `lname`, `fname`, `pwd`) VALUES (:email, :lname, :fname, :pwd)";
        $query = $dbh->prepare($sql);
        $query->execute([
            ":email" => $email,
            ":lname" => $lname,
            ":fname" => $fname,
            ":pwd" => $pwdHash,
        ]);
        $insertedId = $dbh->lastInsertId();
        echo 'true' . ':' . $insertedId;   // this must start with "t" as in "true"
    } else {
        echo "false";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
