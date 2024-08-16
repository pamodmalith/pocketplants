<?php
include "connection.php";

$size = $_POST["size"];

if (empty($size)) {
    echo ("Please enter a size");
} else {

    $rs = Database::search(" SELECT * FROM `size` WHERE `size_name` = '$size' ");
    $num = $rs->num_rows;

    if ($num > 0) {
        echo ("Size Already Exists");
    } else {
        Database::iud(" INSERT INTO `size` (`size_name`) VALUES ('$size') ");
        echo ("success");
    }
}
