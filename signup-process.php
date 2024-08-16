<?php

include "connection.php";

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($fname)) {
    echo ("Please enter your first name");
} else if (strlen($fname) > 20) {
    echo ("You first name must be less than 20 characters");
} else if (empty($lname)) {
    echo ("Please enter your last name");
} else if (strlen(($lname)) > 20) {
    echo ("You last name must be less than 20 characters");
} else if (empty($mobile)) {
    echo ("Please enter your mobile number");
} else if (strlen(($mobile)) != 10) {
    echo ("Your mobile number must be 10 digits");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/", $mobile)) {
    echo ("Invalid mobile number");
} else if (empty($email)) {
    echo ("Please enter your email");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid email");
} else if (empty($password)) {
    echo ("Please enter your password");
} else if (strlen($password) < 3 || strlen($password) > 20) {
    echo ("Your password must be between 3 and 20 characters");
} else {

    $rs = Database::search(" SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password' AND `mobile` = '$mobile' ");
    $num = $rs->num_rows;

    $eRs = Database::search(" SELECT * FROM `user` WHERE `email` = '$email' ");
    $eNum = $eRs->num_rows;

    $mRs = Database::search(" SELECT * FROM `user` WHERE `mobile` = '$mobile' ");
    $mNum = $mRs->num_rows;

    if ($num > 0) {
        echo ("User already exists");
    } elseif ($eNum > 0) {
        echo ("User already exists with same email");
    } elseif ($mNum > 0) {
        echo ("User already exists with same mobile");
    } else {

        $date = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $date->setTimezone($tz);

        $time = $date->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user`(`fname`, `lname`, `mobile`, `email`, `password`, `register_date`, `user_type_id`) 
        VALUES ('$fname','$lname','$mobile','$email','$password','$time','2')");
        echo ("success");
    }
}
