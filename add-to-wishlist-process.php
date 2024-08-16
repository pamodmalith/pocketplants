<?php
session_start();
require "connection.php";

if (!isset($_SESSION['user'])) {
    echo "You need to login first";
    exit();
} else {
    $userId = $_SESSION['user']['id'];
    $productId = $_GET['id'];

    $rs = Database::search(" SELECT * FROM `wishlist` WHERE `user_id` = '$userId' AND `product_id` = '$productId' ");
    $num = $rs->num_rows;

    if ($num > 0) {
        Database::iud(" DELETE FROM `wishlist` WHERE `user_id` = '$userId' AND `product_id` = '$productId' ");
        echo "remove";
        exit();
    } else {
        Database::iud(" INSERT INTO `wishlist` (`user_id`, `product_id`) VALUES ('$userId','$productId') ");
        echo "added";
        exit();
    }
}
