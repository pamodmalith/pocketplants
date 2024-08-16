<?php

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

$email = $_GET["email"];


if (empty($email)) {
    echo ("Please enter your email address");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email` ='$email'");
    $num = $rs->num_rows;

    if ($num > 0) {

        $row = $rs->fetch_assoc();
        $vcode = uniqid();

        Database::iud("UPDATE `user` SET `vcode` = '$vcode' WHERE `id` = '" . $row["id"] . "'");

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom($smtp_username, 'Pamod Malith');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reset your account password';
            $mail->Body = ' <body style="font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0;">
                                <table width="100%" border="0" style="max-width: 600px;">
                                    <tr>
                                        <td style="padding: 40px;">
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tr>
                                                    <td style="text-align: left;">
                                                        <img src="https://raw.githubusercontent.com/pamodmalith/pocketplants/main/assets/img/logo.png"
                                                            alt="Pocket Plants Logo" style="max-width: 100%;height: auto;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding: 20px 0;">
                                                        <h1 style="color: #4CAF50; margin: 10px 0;">Password Reset</h1>
                                                        <p style="color: #555; line-height: 1.6;">Dear ' . $row['fname'] . ',</p>
                                                        <p style="color: #555; line-height: 1.6;">We\'ve received a request to reset the password for
                                                            your Pocket Plants account. To proceed, click the button below:</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;">
                                                        <table cellspacing="0" cellpadding="0" border="0" align="left">
                                                            <tr>
                                                                <td style="border-radius: 5px;">
                                                                    <a href="http://localhost/pocketplant/reset-password.php?code=' . $vcode . '&email=' . $email . '"
                                                                        style="display: inline-block; background-color: #4CAF50; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 5px; transition: background-color 0.3s; font-size: 16px;">Reset
                                                                        Your Password</a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; padding: 20px 0;">
                                                        <p style="color: #555; line-height: 1.6;">If you didn\'t request a password reset, please
                                                            ignore this email. Your password will remain unchanged.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <hr style="margin: 0;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; color: #777; font-size: 0.9em;">
                                                        <p>Regards,<br>The Pocket Plants Team</p>
                                                        <p>This is an automated message. <span style="font-weight: bold;">Please do not reply.</span></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </body>';

            $mail->send();
            echo 'msgsent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo ("User does not exist");
    }
}
