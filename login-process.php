<?php
require "connection.php";
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

if (empty($email)) {
    echo ("Please enter your email address");
} else if (empty($password)) {
    echo ("Please enter your password");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'");
    $num = $rs->num_rows;

    if ($num > 0) {

        $row = $rs->fetch_assoc();

        if ($row["status"] == 1) {

            $_SESSION["user"] = $row;

            if ($_POST["rememberMe"] == "true") {
                setcookie("email", $email, time() + (60 * 60 * 24 * 7));
                setcookie("password", $password, time() + (60 * 60 * 24 * 7));
            } else {
                setcookie("email", "", time() - 3600);
                setcookie("password", "", time() - 3600);
            }
            echo ("success");
        } else {
            echo ("User has been blocked");
        }
    } else {
        echo ("Invalid Email or password");
    }
}
