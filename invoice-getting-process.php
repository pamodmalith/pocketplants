<?php

include "connection.php";
session_start();

if (!isset($_SESSION['user']) || !isset($_POST['ohId'])) {
    exit();
}

$user = $_SESSION['user'];
$ohId = $_POST['ohId'];

$ohRs = Database::search(" SELECT * FROM `order_history` WHERE `id`='$ohId' ");
$num = $ohRs->num_rows;

$oh = $ohRs->fetch_assoc();

$userAddressRs = Database::search(" SELECT * FROM `order_address` WHERE `order_history_id` = '$ohId' ");
$userAddressData = $userAddressRs->fetch_assoc();

?>

<div style="max-width: 800px; margin: auto; padding: 30px; border: 1px solid #ddd; background: #fff; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); border-radius: 10px;">
    <table cellpadding="0" cellspacing="0" style="width: 100%; line-height: inherit; text-align: left;">
        <tr style="border-bottom: 1px solid #eee;">
            <td colspan="4" style="padding-bottom: 20px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="font-size: 35px; line-height: 35px; color: #333;">
                            <img src="https://raw.githubusercontent.com/pamodmalith/pocketplants/main/assets/img/logo.png" style="width: 100%; max-width: 150px;">
                        </td>
                        <td style="text-align: right;">
                            <span style="font-size: 24px; font-weight: bold; color: #333;">Invoice</span><br>
                            <span style="color: #999;">#<?php echo $oh['order_id'] ?></span><br>
                            <span style="color: #999;"><?php echo date("Y-m-d", strtotime($oh['order_date'])) ?></span><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-bottom: 1px solid #eee;">
            <td colspan="4" style="padding: 20px 0;">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <span style="font-weight: bold; color: #333;">Pocket Plants, Inc.</span><br>
                            <span style="color: #666;">info@pocketplants.lk</span><br>
                            <span style="color: #666;">+94 076 645 0529</span>
                        </td>
                        <td style="text-align: right;">
                            <span style="font-weight: bold; color: #333;"><?php echo $user['fname'] . " " . $user['lname'] ?></span><br>
                            <span style="color: #666;"><?php echo $userAddressData['address']; ?></span><br>
                            <span style="color: #666;"><?php echo $user['email'] ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="background: #f7f7f7; border-bottom: 1px solid #ddd;">
            <td style="padding: 10px; font-weight: bold; color: #333;">
                Item
            </td>
            <td style="padding: 10px; font-weight: bold; color: #333;">
                Price
            </td>
            <td style="padding: 10px; font-weight: bold; color: #333;">
                Quantity
            </td>
            <td style="padding: 10px; text-align: right; font-weight: bold; color: #333;">
                Total
            </td>
        </tr>
        <?php
        $oiRs = Database::search(" SELECT `order_item`.`price`, `order_item`.`qty`, `stock_details`.`name` FROM `order_item` JOIN `stock_details` ON `order_item`.`stock_id` = `stock_details`.`stock_id`  WHERE `oh_id`='$ohId' ");

        $total = 0;
        for ($x = 0; $x < $oiRs->num_rows; $x++) {
            $oi = $oiRs->fetch_assoc();
            $total += $oi['price'] * $oi['qty'];
        ?>

            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 10px;">
                    <?php echo $oi['name']; ?>
                </td>
                <td style="padding: 10px;">
                    Rs.<?php echo $oi['price']; ?>.00
                </td>
                <td style="padding: 10px;">
                    <?php echo $oi['qty']; ?>
                </td>
                <td style="padding: 10px; text-align: right;">
                    Rs.<?php echo $oi['qty'] * $oi['price']; ?>.00
                </td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px; text-align: right; color: #333;">
                Sub Total:
            </td>
            <td style="padding: 10px; text-align: right; color: #333;">
                Rs.<?php echo $total; ?>.00
            </td>
        </tr>
        <tr></tr>
        <tr>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px; text-align: right; color: #333;">
                Delivery:
            </td>
            <td style="padding: 10px; text-align: right; color: #333;">
                Rs.500.00
            </td>
        </tr>
        <tr>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px; text-align: right; font-weight: bold; color: #333;">
                Total:
            </td>
            <td style="padding: 10px; text-align: right; font-weight: bold; color: #333;">
                Rs.<?php echo $oh['amount'] ?>.00
            </td>
        </tr>
    </table>
</div>