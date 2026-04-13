<?php

require('db_connect.php');

try {

    $post = $_POST;

    $first_name = $post['first_name']  ?? "";
    $last_name = $post['last_name']  ?? "";
    $dob_month = $post['dob_month']  ?? "";
    $dob_day = $post['dob_day'] ?? 0;
    $spouse = $post['spouse']  ?? "";
    $address = $post['address']  ?? "";
    $city = $post['city']  ?? "";
    $state = $post['state']  ?? "CO";
    $zip = $post['zip']  ?? "";
    $home_phone = $post['home_phone']  ?? "";
    $cell_phone = $post['cell_phone']   ?? "";
    $home_email = $post['home_email'] ?? "";
    $sponsor = $post['sponsor']   ?? "";
    $business_name = $post['business_name']   ?? "";
    $job_title = $post['job_title']  ?? "";
    $business_address = $post['business_address'] ?? "";
    $business_email = $post['business_email'] ?? "";
    $bio = $post['bio'] ?? "";
    $skills = $post['skills']  ?? "";

    $saw_ads = $post['saw_ads'] ?? 0;
    if ($saw_ads == 'on') {
        $saw_ads = 1;
    }
    $saw_website = $post['saw_website'] ?? 0;
    if ($saw_website == 'on') {
        $saw_website = 1;
    }
    $saw_facebook = $post['saw_facebook'] ?? 0;
    if ($saw_facebook == 'on') {
        $saw_facebook = 1;
    }
    $saw_friend = $post['saw_friend'] ?? 0;
    if ($saw_friend == 'on') {
        $saw_friend = 1;
    }

    $captcha_verified = $post['captcha_verified'] ?? "false";

    if ($captcha_verified !== "true") {
        echo "Please complete the verification slider.";
        exit;
    }




    $original_email = $post['original_email'] ?? "";

    $ary = [
        ":first_name" => $first_name,
        ":last_name" => $last_name,
        ":dob_month" => $dob_month,
        ":dob_day" => $dob_day,
        ":spouse" => $spouse,
        ":address" => $address,
        ":city" => $city,
        ":state" => $state,
        ":zip" => $zip,
        ":home_phone" => $home_phone,
        ":cell_phone" => $cell_phone,
        ":home_email" => $home_email,
        ":sponsor" => $sponsor,
        ":business_name" => $business_name,
        ":job_title" => $job_title,
        ":business_address" => $business_address,
        ":business_email" => $business_email,
        ":bio" => $bio,
        ":skills" => $skills,
        ":saw_ads" => $saw_ads,
        ":saw_website" => $saw_website,
        ":saw_facebook" => $saw_facebook,
        ":saw_friend" => $saw_friend
    ];

    if ($original_email !== "") {
        $sql = "UPDATE `application` SET `first_name`=:first_name, `last_name`=:last_name, `dob_month`=:dob_month, `dob_day`=:dob_day, `spouse`=:spouse, `address`=:address, `city`=:city, `state`=:state, `zip`=:zip, `home_phone`=:home_phone, `cell_phone`=:cell_phone, `home_email`=:home_email , `sponsor`=:sponsor, `business_name`=:business_name, `job_title`=:job_title, `business_address`=:business_address, `business_email`=:business_email, `bio`=:bio, `skills`=:skills, `saw_ads`=:saw_ads, `saw_website`=:saw_website, `saw_facebook`=:saw_facebook, `saw_friend`=:saw_friend WHERE `home_email`=:original_email";
        $ary[":original_email"] = $original_email;
        $query = $dbh->prepare($sql);
        $query->execute($ary);
    } else {
        $sql = "INSERT INTO `application`(`first_name`, `last_name`, `dob_month`, `dob_day`, `spouse`, `address`, `city`, `state`, `zip`,
       `home_phone`, `cell_phone`, `home_email`, `sponsor`, `business_name`, `job_title`, `business_address`, `business_email`, `bio`,
       `skills`, `saw_ads`, `saw_website`, `saw_facebook`, `saw_friend`) VALUES (:first_name, :last_name, :dob_month, :dob_day, :spouse, :address, :city,
        :state, :zip, :home_phone, :cell_phone, :home_email , :sponsor, :business_name, :job_title, :business_address, :business_email, :bio,
       :skills, :saw_ads, :saw_website, :saw_facebook, :saw_friend)";

        $query = $dbh->prepare($sql);
        $query->execute($ary);
    }

    echo "true";
} catch (Exception $e) {
    echo $e->getMessage();
}
