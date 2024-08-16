<?php

require "connection.php";

$email = $_POST["email"];
$pw = $_POST["pw"];
$cpw = $_POST["cpw"];
$vcode = $_POST["vcode"];

if (empty($pw)) {
    echo "Please enter your password";
} else if (empty($cpw)) {
    echo "Please Confirm Password";
}else if ($pw != $cpw) {
    echo "Password does not match";
} else if (empty($vcode) || empty($email)) {
    echo "Please check your link is correct";
} else {
    $rs = Database::search("SELECT * FROM `user` WHERE `vcode` = '$vcode' AND `email`='$email'");
    $num = $rs->num_rows;

    if ($num > 0) {
        $row = $rs->fetch_assoc();

        Database::iud(" UPDATE `user` SET `password` =  '$pw', `vcode` = NULL WHERE `id` = '" . $row["id"] . "' ");
        echo "success";
    } else {
        echo "User not found";
    }
}