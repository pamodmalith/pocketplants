<?php
include "connection.php";

$id = $_GET['id'];

$rs = Database::search(" SELECT * FROM `product` WHERE `id` = '$id' ");
$num = $rs->num_rows;

if ($num > 0) {
    $row = $rs->fetch_assoc();

    if ($row['status'] == 0) {
        Database::iud(" UPDATE `product` SET `status` = '1' WHERE `id` = '$id' ");
        echo "activated";
    } else {
        Database::iud(" UPDATE `product` SET `status` = '0' WHERE `id` = '$id' ");
        echo "deactivated";
    }
} else {
    echo ("Product not found");
}
