<?php

include "connection.php";
session_start();

if (!isset($_SESSION['user'])) {
    echo "You need to login first";
    exit();
}

$userId = $_SESSION['user']['id'];

$stockId = $_GET['stock'];
$qty = $_GET['qty'];

if (empty($stockId)) {
    echo "Invalid stock";
} else if (empty($qty)) {
    echo "Quantity cannot be empty";
} else if ($qty < 1) {
    echo "Quantity cannot be less than 1";
} else {

    $sRs = Database::search(" SELECT * FROM `stock` WHERE `id` = '$stockId' ");
    $sRow = $sRs->fetch_assoc();

    $rs = Database::search(" SELECT * FROM `cart` WHERE `user_id` = '$userId' AND `stock_id` = '$stockId' ");
    $num = $rs->num_rows;

    if ($num > 0) {
        $row = $rs->fetch_assoc();
        $cartId = $row['id'];

        $newQty = $row['qty'] + $qty;

        if ($sRow['qty'] >= $newQty) {
            Database::iud(" UPDATE `cart` SET `qty`='$newQty' WHERE `id`='$cartId' ");
            echo "success";
        } else {
            echo "Quantity exceeded !";
        }
    } else {

        if ($sRow['qty'] >= $qty) {
            Database::iud(" INSERT INTO `cart` (`user_id`, `stock_id`, `qty`) VALUES ('$userId','$stockId','$qty') ");
            echo "success";

        } else {
            echo "Quantity exceeded !";
        }
    }
}
