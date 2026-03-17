<?php

   require("db_connect.php");

   try {
       $email = strtolower(trim($_POST['email']));
       $fname = $_POST['fname'];
       $lname = $_POST['lname'];

       $sql = 'select * from person where email = :email';
       $query = $dbh->prepare($sql);
       $query->execute([':email'=>$email]);
       $row = $query->fetchAll(PDO::FETCH_ASSOC);
       if (empty($row)) {
           $sql = "INSERT INTO `person`(`email`, `lname`, `fname`, `pwd`) VALUES (:email, :lname, :fname, :pwd)";
            $query = $dbh->prepare($sql);
            $query->execute([":email"=>$email, ":lname"=>$lname, ":fname"=>$fname, ":pwd"=>'']);
            $insertedId = $dbh->lastInsertId();
           echo 'true' . ':' . $insertedId;   // this must start with "t" as in "true"
       } else {
           echo "false";
       }
   } catch (Execption $e) {
      echo $e->getMessage();
   }

?>