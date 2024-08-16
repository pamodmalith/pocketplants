<?php

include "connection.php";
session_start();

if (isset($_SESSION['user'])) {

    $uid = $_SESSION['user']['id'];

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobile = $_POST['mobile'];

    if (empty($fname)) {
        echo "Please enter your first name";
    } else if (strlen($fname) > 20) {
        echo "You first name must be less than 20 characters";
    } else if (empty($lname)) {
        echo "Please enter your last name";
    } else if (strlen(($lname)) > 20) {
        echo "You last name must be less than 20 characters";
    } else if (empty($mobile)) {
        echo "Please enter your mobile number";
    } else if (strlen($mobile) != 10) {
        echo "Your mobile number must be 10 digits";
    } else {
        
        Database::iud(" UPDATE `user` SET `fname`='$fname', `lname`='$lname', `mobile`='$mobile' WHERE `id`='$uid' ");

        echo "success";
    }
}else {
    echo "Please login first";
    exit();
}
