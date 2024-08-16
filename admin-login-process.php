<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email)) {
    echo ("Please enter your email address");
} else if (empty($password)) {
    echo ("Please enter your password");
} else {

    require "connection.php";
    $rs = Database::search(" SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password' AND `user_type_id` = '1' ");
    $num = $rs->num_rows;

    if ($num == 1) {
        $data = $rs->fetch_assoc();
        $_SESSION["admin"] = $data;
        echo ("success");
    } else {
        echo "Invalid Email or Password";
    }
}