<?php

include "connection.php";
session_start();

if (isset($_SESSION['user'])) {

    $uid = $_SESSION['user']['id'];

    $no = $_POST['no'];
    $pcode = $_POST['pcode'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $street = $_POST['street'];

    //validation

    //Update User address
    $rs = Database::search("SELECT * FROM `user_address` WHERE `user_id`='$uid' ");
    $num = $rs->num_rows;

    if ($num > 0) {
        //Update
        Database::iud(" UPDATE `user_address` SET `no` = '$no', `street` = '$street', `city`='$city',`postal_code`='$pcode', `province` = '$province' WHERE `user_id`='$uid' ");
    } else {
        //Insert
        Database::iud(" INSERT INTO `user_address` VALUES ('$uid','$no', '$street', '$city', '$province', '$pcode' ) ");
    }
    echo "success";
}
