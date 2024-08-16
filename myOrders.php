<?php
session_start();
require "connection.php";

if (isset($_SESSION['user'])) {

    $uid = $_SESSION['user']['id'];
    $rs = Database::search(" SELECT * FROM `user` WHERE `id`='$uid' ");

    if ($rs->num_rows < 1) {
        header("Location: signin.php");
    }

    $user = $rs->fetch_assoc();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Orders - Pocket Plants</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body onload="loadOrderHistory();">
        <?php include "header.php"; ?>

        <div class="container body-56">
            <div class="row">

                <div class="col-md-4 col-lg-3 p-3">
                    <!-- Manage Account left tab -->
                    <?php include "profile-navbar.php"; ?>
                    <!-- Manage Account left tab -->
                </div>

                <div class="col-md-8 col-lg-9 pt-3">
                    <div class="container">

                        <!-- Breadcrumb -->
                        <ol class="breadcrumb p-3 bg-body-tertiary rounded-3 m-0 mb-2" style="--bs-breadcrumb-divider: '>';">
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis" href="./">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="profile.php">Account</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Orders</li>
                        </ol>

                        <!-- Filters -->
                        <div class="bg-light rounded">
                            <!-- Option Form -->
                            <div class="d-flex align-items-center ps-2 py-2">
                                <div class="">
                                    <h6 class="m-0 p-0">Show :&nbsp;</h6>
                                </div>
                                <div class="d-grid">
                                    <select id="filterOrders" onchange="loadOrderHistory();" class="form-select">
                                        <option selected value="0">Last 5 Orders</option>
                                        <option value="1">Last 15 Orders</option>
                                        <option value="3">All Orders</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- Filters -->

                        <div id="content">



                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manage Account left tab -->
        <?php include "footer.php"; ?>
        <!-- Manage Account left tab -->



    </body>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>

    </html>
<?php
} else {
    header("Location:login.php");
}
?>