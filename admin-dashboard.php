<?php
session_start();
require "connection.php";
if ($_SESSION['admin']) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/admin-panel.png" type="image/x-icon">
        <title>Admin Dashboard - Pocket Plant</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="admin-style.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/ddab9ff985.js" crossorigin="anonymous"></script>
    </head>

    <body onload="chart();">

        <!-- Header -->
        <?php include "admin-header.php" ?>
        <!-- Header -->

        <div class="container-fluid admin-body">
            <div class="row">

                <!-- Nav Bar -->
                <?php include "admin-navbar.php" ?>
                <!-- Nav Bar End -->

                <!-- Main Body -->
                <main class=" ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h2 class="">Dashboard</h2>
                    </div>

                    <!-- Basic Info -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4">
                            <?php
                            $todaySalesRs = Database::search(" SELECT SUM(`price`) as total FROM `order_item` WHERE `oh_id` IN (SELECT `id` FROM `order_history` WHERE DATE(`order_history`.`order_date`) = CURDATE()) ");
                            $todaySales = $todaySalesRs->fetch_assoc();
                            ?>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                                    <div class="ms-3 text-end">
                                        <p class="mb-2">Today Sale</p>
                                        <h6 class="mb-0">RS.<?php echo $todaySales['total'] ?>.00</h6>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $totalSalesRs = Database::search(" SELECT SUM(`price`) as total FROM `order_item` ");
                            $totalSales = $totalSalesRs->fetch_assoc();
                            ?>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                                    <div class="ms-3 text-end">
                                        <p class="mb-2">Total Sale</p>
                                        <h6 class="mb-0">RS.<?php echo $totalSales['total'] ?>.00</h6>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $todayRevenueRs = Database::search(" SELECT SUM(`cost`) as total FROM `order_item` WHERE `oh_id` IN (SELECT `id` FROM `order_history` WHERE DATE(`order_history`.`order_date`) = CURDATE()) ");
                            $todayRevenue = $todayRevenueRs->fetch_assoc();
                            ?>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                                    <div class="ms-3 text-end">
                                        <p class="mb-2">Today Revenue</p>
                                        <h6 class="mb-0">RS.<?php echo $todaySales['total'] - $todayRevenue['total'] ?>.00</h6>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $totalRevenueRs = Database::search(" SELECT SUM(`cost`) as total FROM `order_item` ");
                            $totalRevenue = $totalRevenueRs->fetch_assoc();
                            ?>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                                    <div class="ms-3 text-end">
                                        <p class="mb-2">Total Revenue</p>
                                        <h6 class="mb-0">RS.<?php echo $totalSales['total'] - $totalRevenue['total'] ?>.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Basic Info -->

                    <!-- Charts -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4 p-2">
                            <div class="bg-light text-center rounded p-4">
                                <div class="mb-4">
                                    <h6 class="mb-0">Product Stock</h6>
                                </div>
                                <canvas class="w-100" id="chart" style="display: block; box-sizing: border-box;"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- Charts -->

                    <!-- Recent Sales Start -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Recent Orders</h6>
                                <a href="admin-sales-report.php">Show All</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <thead>
                                        <tr class="text-dark">
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Invoice</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ordersRs = Database::search(" SELECT * FROM `order_history` ORDER BY `order_date` DESC LIMIT 5 ");
                                        $orderNum = $ordersRs->num_rows;
                                        for ($i = 0; $i < $orderNum; $i++) {
                                            $order = $ordersRs->fetch_assoc();
                                            $userRs = Database::search(" SELECT * FROM `user` WHERE `id` = '$order[user_id]' ");
                                            $user = $userRs->fetch_assoc();
                                        ?>
                                            <tr>
                                                <td><?php echo $i + 1 ?></td>
                                                <td><?php echo date("Y-m-d", strtotime($order['order_date'])) ?></td>
                                                <td><?php echo $order['order_id'] ?></td>
                                                <td><?php echo $user['fname'] . " " . $user['lname'] ?></td>
                                                <td>Rs.<?php echo $order['amount'] ?>.00</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Recent Sales End -->
                </main>
                <!-- Main Body -->

                <?php include "admin-footer.php" ?>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

<?php
} else {
    header("Location: admin-login.php");
}
?>