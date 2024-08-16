<?php
include "connection.php";

$name = $_POST['name'];
$category = $_POST['category'];
$size = $_POST['size'];
$desc = $_POST['desc'];
$productCost = $_POST['productCost'];
$sellPrice = $_POST['sellPrice'];
$color = $_POST['color'];
$img = $_FILES['img'];

if (empty($name)) {
    echo "Please enter the product name";
} else if (empty($category)) {
    echo "Please select a category";
} elseif (empty($size)) {
    echo "Please select a size";
} else if (empty($desc)) {
    echo "Please enter the product description";
} else if (empty($productCost)) {
    echo "Please enter the product cost";
} else if (empty($sellPrice)) {
    echo "Please enter the selling Price";
} else if (empty($color)) {
    echo "Please select a color";
} else if (empty($_FILES['img'])) {
    echo "Please select a product image";
} else {

    $rs = Database::search(" SELECT * FROM  `product` WHERE `name` = '$name' AND `size_id` = '$size' AND `category_id` = '$category' AND `color_id` = '$color' ");
    $num = $rs->num_rows;

    if ($num > 0) {
        echo "Product Already Exists";
    } else {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = $img['type'];

        if (in_array($fileType, $allowedTypes)) {
            $imgPath = "assets/products/" . uniqid() . $_FILES['img']['name'];
            move_uploaded_file($_FILES['img']['tmp_name'], $imgPath);
        } else {
            echo "Invalid file type.";
            exit();
        }

        Database::iud(" INSERT INTO `product` (`name`, `description`, `img`, `price`, `cost`, `category_id`, `color_id`, `size_id`) VALUES ('$name', '$desc', '$imgPath', '$sellPrice', '$productCost', '$category', '$color', '$size') ");

        echo "success";
    }
}
