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
        <title>Sales Report - Pocket Plant</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="admin-style.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/ddab9ff985.js" crossorigin="anonymous"></script>
    </head>

    <body>

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

                    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3 m-0 mt-3 mb-2">
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis" href="admin-dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis fw-semibold text-decoration-none" href="reports.php">Reports</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Sales Report
                        </li>
                    </ol>

                    <div id="heading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h2 class="">Sales Report</h2>
                        <div class="d-flex gap-1 justify-content-end d-print-none">
                            <div class="">
                                <button onclick="printReport();" class="btn btn-sm btn-outline-dark"><i class="bi bi-printer"></i>&nbsp;Print</button>
                            </div>
                            <div class="">
                                <button onclick="exportToPdf('Order Report');" class="btn btn-sm btn-outline-danger"><i class="bi bi-filetype-pdf"></i>&nbsp;Export as a PDF</button>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Table -->
                    <div class="mt-3 rounded p-2 shadow-sm" id="printArea">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $rs = Database::search(" SELECT * FROM `order_history` ");
                                    $num = $rs->num_rows;

                                    for ($x = 0; $x < $num; $x++) {
                                        $order = $rs->fetch_assoc();
                                        $userRs = Database::search(" SELECT * FROM `user` WHERE `id` = '$order[user_id]' ");
                                        $user = $userRs->fetch_assoc();
                                    ?>
                                        <tr>
                                            <td><?php echo $x + 1 ?></td>
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



                </main>
                <!-- Main Body -->

            </div>
        </div>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

<?php
} else {
    header("Location: admin-login.php");
}
?>