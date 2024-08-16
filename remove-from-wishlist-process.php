<?php
session_start();
require "connection.php";

if (!isset($_SESSION['user'])) {
    echo "You need to login first";
    exit();
} else {
    $userId = $_SESSION['user']['id'];
    $id = $_GET['id'];

    Database::iud(" DELETE FROM `wishlist` WHERE `user_id` = '$userId' AND `id` = '$id' ");
    echo "success";
}
