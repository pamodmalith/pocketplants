<?php

include "connection.php";

$cartId = $_GET['id'];
$qty = $_GET['qty'];

if (empty($cartId)) {
    echo "Invalid request";
} else if ($qty < 1) {
    echo "Invalid Quantity";
} else {

    $cartRs = Database::search("SELECT * FROM `cart` WHERE `id`='$cartId' ");
    $cartNum = $cartRs->num_rows;

    if ($cartNum > 0) {
        $cartRow = $cartRs->fetch_assoc();
        $stockId = $cartRow['stock_id'];

        $stockRs = Database::search(" SELECT * FROM `stock_details` WHERE `stock_id`='$stockId' ");
        $stock = $stockRs->fetch_assoc();

        if ($stock['qty'] >= $qty) {
            Database::iud(" UPDATE `cart` SET `qty`='$qty' WHERE `id`='$cartId' ");
            echo "success";
        } else {
            echo "Quantity Exceeded!";
        }
    } else {
        echo "Cart item not found!";
    }
}
