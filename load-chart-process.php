<?php

include "connection.php";

$dateRs = Database::search(" SELECT DATE(`order_date`) as date,`id` FROM `order_history` ");

$dates = [];
$sales = [];
$revenues = [];

while ($row = $dateRs->fetch_assoc()) {
    $dates[] = $row['date'];
    $saleRs = Database::search(" SELECT SUM(`price`) as total FROM `order_item` WHERE `oh_id` = '$row[id]' ");
    $sale = $saleRs->fetch_assoc();
    $sales[] = $sale['total'];
    $revenueRs = Database::search(" SELECT SUM(`cost`) as total FROM `order_item` WHERE `oh_id` = '$row[id]' ");
    $revenue = $revenueRs->fetch_assoc();
    $revenues[] = $sale['total'] - $revenue['total'];
}

$json = [];
$json["sales"] = $sales;
$json["revenues"] = $revenues;
$json["dates"] = $dates;

echo json_encode($json);
