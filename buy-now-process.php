<?php
include "connection.php";
session_start();

$userId = $_SESSION["user"]["id"];
$errors = [];

if (isset($_POST["payment"]) && isset($_SESSION["user"])) {

    $payment = json_decode($_POST['payment'], true);

    $date = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $date->setTimezone($tz);

    $time = $date->format("Y-m-d H:i:s");

    // INSERT order history
    Database::iud(" INSERT INTO `order_history` (`order_id`,`order_date`,`amount`,`user_id`) VALUES ('" . $payment['order_id'] . "','$time','" . $payment['amount'] . "', '$userId') ");

    $ohId = Database::$connection->insert_id;

    $stockRs = Database::search(" SELECT * FROM `stock` WHERE `id`='" . $payment["stock_id"] . "' ");
    $stock = $stockRs->fetch_assoc();

    $productRs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $stock['product_id'] . "' ");
    $product = $productRs->fetch_assoc();

    if ($stock["qty"] >= $payment["qty"]) {

        Database::iud("INSERT INTO `order_item` (`qty`, `price`, `cost`, `oh_id`, `stock_id`) VALUES ('" . $payment["qty"] . "', '" . $product['price'] . "', '" . $product['cost'] . "', '$ohId', '" . $payment["stock_id"] . "')");

        $newQty = $stock["qty"] - $payment["qty"];
        Database::iud("UPDATE `stock` SET `qty`='$newQty' WHERE `id`='" . $payment["stock_id"] . "'");

        Database::iud(" INSERT INTO `order_address` (`order_history_id`,`address`) VALUES ('$ohId','" . $payment['address'] . "') ");
    } else {
        $errors[0] = "Insufficiant quantity";
    }
} else {
    $errors[0] = "Invalid Request";
}

$json = [];
if (empty($error)) {
    $json['status'] = "success";
    $json['ohId'] = $ohId;
} else {
    $json['status'] = "error";
    $json['error'] = $error;
}

echo json_encode($json);
