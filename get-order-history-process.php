<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    exit();
}

$limit = '';

if ($_GET['limit'] > 0) {
    $limit = "LIMIT" . " " . $_GET['limit'];
}

$ohRs = Database::search(" SELECT * FROM `order_history` WHERE `user_id` = '$user[id]' ORDER BY `order_date` DESC $limit ");
$ohNum = $ohRs->num_rows;
for ($x = 0; $x < $ohNum; $x++) {
    $ohData = $ohRs->fetch_assoc();
?>
    <!-- Order Box -->

    <div class="bg-light rounded">
        <div class="mt-2 ps-2 py-1 d-flex justify-content-between align-items-center">
            <p class="m-0 fw-semibold">Delivered</p>
            <div class="d-flex align-items-center">
                <div>
                    <div class="col-12">
                        <p class="m-0 p-0 small fw-medium">Order Id:&nbsp;<span class="text-opacity-75 small fw-normal"><?php echo $ohData['order_id']; ?></span></p>
                    </div>
                    <div class="col-12">
                        <p class="m-0 p-0 small fw-medium">Date:&nbsp;<span class="text-opacity-75 small fw-normal"><?php echo date("d M Y H:i", strtotime($ohData['order_date'])); ?></span></p>
                    </div>
                </div>
                <div class="vr mx-2"></div>
                <div class="small"><a class="text-decoration-none" href="invoice.php?id=<?php echo $ohData['id']; ?>">Invoice&nbsp;<i class="bi bi-chevron-right"></i></a></div>
            </div>
        </div>
        <hr class="m-0 mt-1">

        <?php
        $oiRs = Database::search("SELECT * FROM `order_item` WHERE `oh_id` = '$ohData[id]' ");
        $oiNum = $oiRs->num_rows;
        for ($i = 0; $i < $oiNum; $i++) {
            $oiData = $oiRs->fetch_assoc();
            $productRs = Database::search(" SELECT * FROM `product` JOIN `stock` ON `product`.`id` = `stock`.`product_id` WHERE `stock`.`id` = '$oiData[stock_id]' ");
            $productData = $productRs->fetch_assoc();
        ?>
            <!-- Items -->
            <div class="col-12 d-flex justify-content-between">
                <div class="col-lg-1 m-3 col-2 d-flex align-items-center justify-content-center">
                    <img src="<?php echo $productData['img'] ?>" class="img-60-fluid">
                </div>
                <div class="col-4 my-3 d-flex align-items-center">
                    <p class="m-0 p-0"><?php echo $productData['name'] ?></p>
                </div>
                <div class="col-2 my-3 text-end align-self-center">
                    <p class="m-0 p-0 text-dark text-opacity-50">Qty :&nbsp;<span class="text-dark"><?php echo $oiData['qty']; ?></span></p>
                </div>
                <div class="col-2 my-3 text-end align-self-center">
                    <p class="m-0 p-0 pe-2">Rs.<?php echo $productData['price']; ?>.00</span></p>
                </div>
            </div>
            <!-- Items -->
        <?php
        }
        ?>

    </div>
<?php
}
?>