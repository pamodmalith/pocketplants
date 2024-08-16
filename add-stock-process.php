<?php
include "connection.php";

$product = $_POST["product"];
$qty = $_POST["qty"];

if ($product == "0") {
    echo ("Please select a product");
} else if (empty($qty)) {
    echo ("Please enter a quantity");
} else if ($qty < 1 || !is_numeric($qty)) {
    echo ("Invalid quantity");
} else {

    $rs = Database::search(" SELECT * FROM `stock` WHERE `product_id` = '$product' ");
    $num = $rs->num_rows;

    if ($num > 0) {
        $row = $rs->fetch_assoc();

        $newQty = $row['qty'] + $qty;
        Database::iud(" UPDATE `stock` SET `qty` = '$newQty' WHERE `id` = '" . $row['id'] . "' ");
    } else {
        Database::iud(" INSERT INTO `stock` (`product_id`, `qty`) VALUES ('$product', '$qty') ");
    }

    echo ("success");
}
