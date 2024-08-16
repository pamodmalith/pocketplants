<?php
include "connection.php";
session_start();


if (isset($_SESSION['user'])) {

    $user = $_SESSION['user'];
    $userId = $user['id'];

    $error = "";

    $stockList = [];
    $qtyList = [];

    if (isset($_POST['cart']) && $_POST['cart'] == "true") {

        $rs = Database::search(" SELECT * FROM `cart` WHERE `user_id` = '$userId' ");
        $num = $rs->num_rows;

        for ($i = 0; $i < $num; $i++) {
            $row = $rs->fetch_assoc();

            $stockList[] = $row['stock_id'];
            $qtyList[] = $row['qty'];
        }
    } else {

        $stockList[] = $_POST["stockId"];
        $qtyList[] = $_POST["qty"];
    }

    require __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();


    $merchantId = $_ENV['MERCHANT_ID'];
    $merchantSecret = $_ENV['MERCHANT_SECRET'];
    $items = [];
    $netTotal = 0;
    $currency = "LKR";
    $orderId = uniqid();

    for ($x = 0; $x < sizeof($stockList); $x++) {
        $stockRs = Database::search(" SELECT * FROM `stock_details` WHERE `stock_id` = '" . $stockList[$x] . "' ");
        $stock =  $stockRs->fetch_assoc();

        $stockQty = $stock['qty'];
        if ($stockQty >= $qtyList[$x]) {
            $items[] = $stock['name'];
            $netTotal += intval($stock['price']) * intval($qtyList[$x]);
        } else {
            $error = "Insufficient Quantity";
        }
    }

    $netTotal += 500;

    $hash = strtoupper(
        md5(
            $merchantId .
                $orderId .
                number_format($netTotal, 2, '.', '') .
                $currency .
                strtoupper(md5($merchantSecret))
        )
    );

    $payment = [];

    $payment["sandbox"] = true;
    $payment["merchant_id"] = $merchantId;
    $payment["return_url"] = "http://localhost/pocketplant";
    $payment["cancel_url"] = "http://localhost/pocketplant";
    $payment["notify_url"] = "http://localhost/pocketplant/notify";
    $payment["order_id"] = $orderId;
    $payment["items"] = implode(", ", $items);
    $payment["amount"] = number_format($netTotal, 2, '.', '');
    $payment["currency"] = $currency;
    $payment["hash"] = $hash;
    $payment["first_name"] = $user["fname"];
    $payment["last_name"] = $user["lname"];
    $payment["email"] = $user["email"];
    $payment["phone"] = $user["mobile"];

    $addressRs = Database::search("SELECT * FROM `user_address` WHERE `user_id`='$userId'");
    $num = $addressRs->num_rows;

    if ($num > 0) {
        $address = $addressRs->fetch_assoc();
        $payment["address"] = $address['no'] . " " . $address['street'] . " " . $address['city'];
        $payment['city'] = $address['city'];
        $payment['province'] = $address['province'];
        $payment['country'] = "Sri Lanka";
    } else {
        $error = "Please Update Your Address";
    }

    $json = [];
    if (empty($error)) {
        $json['status'] = "success";
        $json['payment'] = $payment;
    } else {
        $json['status'] = "error";
        $json['error'] = $error;
    }
} else {
    $json['status'] = "error";
    $json['error'] = "Please login to proceed";
}

echo json_encode($json);
