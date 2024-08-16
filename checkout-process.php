<?php
session_start();
require "connection.php";
$userId = $_SESSION['user']['id'];
$errors = [];

if (isset($_POST['payment'])) {

    $payment = json_decode($_POST['payment'], true);

    $date = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $date->setTimezone($tz);

    $time = $date->format("Y-m-d H:i:s");

    // INSERT order history
    Database::iud(" INSERT INTO `order_history` (`order_id`,`order_date`,`amount`,`user_id`) VALUES ('" . $payment['order_id'] . "','$time','" . $payment['amount'] . "', '$userId') ");

    $ohId = Database::$connection->insert_id;

    $cartRs = Database::search("SELECT * FROM `cart` WHERE `user_id` = '$userId' ");
    $num = $cartRs->num_rows;

    for ($x = 0; $x < $num; $x++) {
        $row = $cartRs->fetch_assoc();

        $stocktRs = Database::search("SELECT * FROM `stock` WHERE `id` = '" . $row['stock_id'] . "' ");
        $stock = $stocktRs->fetch_assoc();

        $productRs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $stock['product_id'] . "' ");
        $product = $productRs->fetch_assoc();

        if ($stock['qty'] >= $row['qty']) {
            Database::iud(" INSERT INTO `order_item` (`qty`, `price`, `cost`, `oh_id`, `stock_id`) VALUES  ('" . $row['qty'] . "', '" . $product['price'] . "', '" . $product['cost'] . "', '$ohId','" . $stock['id'] . "') ");

            $newQty = $stock['qty'] - $row['qty'];
            Database::iud(" UPDATE `stock` SET `qty`='$newQty' WHERE `id`='" . $stock['id'] . "' ");
        } else {
            $errors[0] = "Insuffucuant Quantity!";
        }
    }

    Database::iud(" INSERT INTO `order_address` (`order_history_id`,`address`) VALUES ('$ohId','" . $payment['address'] . "') ");
    Database::iud(" DELETE FROM `cart` WHERE `user_id`='$userId' ");
} else {
    $errors[0] = "Invalid Request";
}

$json = [];

if (empty($errors)) {
    $json['status'] = "success";
    $json['ohId'] = $ohId;
} else {
    $json['status'] = "error";
    $json['error'] = $errors[0];
}

echo json_encode($json);
