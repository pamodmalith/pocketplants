<?php
session_start();
include "connection.php";

require "vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "vendor/phpmailer/phpmailer/src/SMTP.php";
require "vendor/phpmailer/phpmailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$smtp_password = $_ENV['SMTP_PASSWORD'];
$smtp_username = $_ENV['SMTP_USERNAME'];


$emailbody = $_POST["mailbody"];
$ohId = $_POST["ohId"];

$ohRs = Database::search(" SELECT * FROM `order_history` WHERE `id`='$ohId' ");
$oh = $ohRs->fetch_assoc();

$user = $_SESSION['user'];
$email = $user['email'];

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_username; //smtp username
    $mail->Password = $smtp_password; //smtp password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom($smtp_username, 'Pamod Malith');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your Pocket Plants Receipt' . " " . $oh['order_id'];
    $mail->Body = $emailbody;

    $mail->send();
    echo 'msgsent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
