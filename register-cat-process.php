<?php
include "connection.php";

$cat = $_POST["cat"];

if (empty($cat)) {
    echo ("Please enter a category");
} else {

    $rs = Database::search(" SELECT * FROM `category` WHERE `cat_name` = '$cat' ");
    $num = $rs->num_rows;

    if ($num > 0) {
        echo ("Category Already Exists");
    } else {
        Database::iud(" INSERT INTO `category` (`cat_name`) VALUES ('$cat') ");
        echo ("success");
    }
}
