<?php
session_start();
require "connection.php";

if (isset($_SESSION['user'])) {

    $uid = $_SESSION['user']['id'];

    $rs = Database::search(" SELECT * FROM `user` WHERE `id`='$uid' ");

    if ($rs->num_rows > 0) {
        $row = $rs->fetch_assoc();

        if (isset($_FILES['img'])) {
            $img = $_FILES['img'];
        }
        if (isset($img['error']) && $img['error'] === UPLOAD_ERR_OK) {

            $allowedTypes = ['image/jpeg', 'image/png'];
            $fileType = $img['type'];

            if (in_array($fileType, $allowedTypes)) {
                // File type is allowed
                $imgPath = "assets/profile/" . uniqid() . "_" . $img['name'];

                if (isset($_SESSION['user']['profile'])) {
                    // already have a profile image
                    if (file_exists($row['profile'])) {
                        // check if the file already exists
                        unlink($row['profile']);
                    }
                    move_uploaded_file($_FILES['img']['tmp_name'], $imgPath);
                    Database::iud(" UPDATE `user` SET `profile`='$imgPath' WHERE `id`='$uid' ");
                    echo "success";
                } else {
                    // already haven't a profile image
                    move_uploaded_file($_FILES['img']['tmp_name'], $imgPath);
                    Database::iud(" UPDATE `user` SET `profile`='$imgPath' WHERE `id`='$uid' ");
                    echo "success";
                }
            } else {
                echo "Invalid file type.";
            }
        } else {
            echo 'Please select profile image';
        }
    } else {
        echo "user not found";
        exit();
    }
} else {
    echo "Please Login First";
    exit();
}
