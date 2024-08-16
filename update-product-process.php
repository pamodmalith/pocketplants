<?php
include "connection.php";

$id = $_POST['id'];
$name = $_POST['name'];
$category = $_POST['cat'];
$size = $_POST['size'];
$desc = $_POST['desc'];
$cost = $_POST['cost'];
$price = $_POST['price'];
$color = $_POST['color'];


if (empty($name)) {
    echo ("Please enter the product name");
} else if (empty($category)) {
    echo ("Please select category");
} else if (empty($size)) {
    echo ("Please select size");
} else if (empty($desc)) {
    echo ("Please enter the product description");
} elseif (empty($cost)) {
    echo ("Please enter the cost");
} else if (empty($price)) {
    echo ("Please enter the price");
} else if (empty($color)) {
    echo ("Please select color");
} else {

    $rs = Database::search(" SELECT * FROM  `product` WHERE `id` != '$id' AND (`name` = '$name' AND `size_id` = '$size' AND `category_id` = '$category' AND `color_id` = '$color') ");
    $num = $rs->num_rows;

    // print_r( $rs->fetch_assoc());

    if ($num > 0) {
        echo "The product already in the list";
    } else {

        $rs2 = Database::search(" SELECT * FROM `product` WHERE `id`='$id' ");
        $data = $rs2->fetch_assoc();

        $imgPath = $data['img'];

        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = $_FILES['img']['type'];

        if (in_array($fileType, $allowedTypes)) {

            $imgPath = "assets/products/" . uniqid() . $_FILES['img']['name'];

            if (!empty($_FILES['img']) && !empty($data['img'])) {
                unlink($data['img']);
                move_uploaded_file($_FILES['img']['tmp_name'], $imgPath);
            } else {
                move_uploaded_file($_FILES['img']['tmp_name'], $imgPath);
            }
        } else {
            echo "Invalid file type.";
            exit();
        }

        Database::iud(" UPDATE `product` SET `name`='$name', `category_id`='$category', `size_id`='$size', `description`='$desc', `cost`='$cost', `price`='$price', `color_id`='$color', `img`='$imgPath' WHERE `id`='$id' ");
        echo "success";
    }
}
