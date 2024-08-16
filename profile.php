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
        <title>User Profile</title>
        <link href="bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="style.css">
        <script src="https://kit.fontawesome.com/ddab9ff985.js" crossorigin="anonymous"></script>
    </head>

    <body>

        <?php include "header.php" ?>

        <div class="container body-56">
            <div class="row">

                <div class="col-md-4 col-lg-3 p-3">
                    <!-- Manage Account left tab -->
                    <?php include "profile-navbar.php"; ?>
                    <!-- Manage Account left tab -->
                </div>

                <!-- Right Side -->
                <div class="col-md-8 col-lg-9 pt-3">

                    <!-- breadcrumb -->
                    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3 m-0 mb-2" style="--bs-breadcrumb-divider: '>';">
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis" href="./">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Account
                        </li>
                    </ol>
                    <!-- breadcrumb -->

                    <div class="row" id="overviewSec">
                        <div class="mb-3">
                            <div class="bg-white rounded shadow-sm px-2 py-2 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle">
                                        <img src="assets/profile/default.png" class="img-80-circle">
                                    </div>
                                    <h4 class="fw-bold">Pamod Malith</h4>
                                </div>
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-clock-history fs-1"></i>
                                        <a href="#" class="m-0 link-underline-opacity-0 link-underline-opacity-100-hover link-dark fw-medium">Viewed</a>
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-heart fs-1 fw-bold"></i>
                                        <a href="wishlist.php" class="m-0 link-underline-opacity-0 link-underline-opacity-100-hover link-dark fw-medium">Wish List</a>
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inboxes fs-1 fw-bold"></i>
                                        <a href="myOrders.php" class="m-0 link-underline-opacity-0 link-underline-opacity-100-hover link-dark fw-medium">Orders</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Personal Profile -->
                        <div class="col-lg-6 mb-3">
                            <div class="bg-white rounded shadow-sm px-3 py-4 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="mb-0">Personal Profile</h6>
                                    <div class="vr mx-1 bg-black"></div>
                                    <a href="user-profile.php" class="mb-0 p-0 small">Edit</a>
                                </div>
                                <div class="mt-3">
                                    <p class="m-0 p-0">Pamod Malith</p>
                                </div>
                                <div class="mt-1">
                                    <p class="m-0 p-0">pamodmalith@gmail.com</p>
                                </div>
                                <div class="mt-1">
                                    <p class="m-0 p-0">0774046363</p>
                                </div>
                                <div class="mt-1">
                                    <p class="m-0 p-0"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Personal Profile -->

                        <!-- Address Profile -->
                        <div class="col-lg-6 mb-3">
                            <div class="bg-white rounded shadow-sm px-3 py-4 h-100">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0">Address Book</h6>
                                    <div class="vr mx-1 bg-black"></div>
                                    <a href="user-address.php" class="mb-0 p-0 small">Edit</a>
                                </div>
                                <div class="mt-3">
                                    <p class="m-0 p-0 fw-bold">Pamod Malith</p>
                                    <p class="m-0 p-0 small">Galpola,Ilukhena</p>
                                    <p class="m-0 p-0 small">Kuliyapitiya</p>
                                    <p class="m-0 p-0 small">0774046363</p>
                                </div>
                            </div>
                        </div>
                        <!-- Address Profile -->
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <div class="bg-white rounded shadow-sm px-3 py-4 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="">Recent Order</h4>
                                    <a href="myOrders.php" class="text-muted p-0 m-0 fs-6 text-decoration-none">See All&nbsp;<i class="bi bi-chevron-right"></i></a>
                                </div>
                                <hr />
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead>
                                            <tr class="text-dark">
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-dark">
                                                <td>#</td>
                                                <td>Leon</td>
                                                <td>Christopher</td>
                                                <td>muvno@juz.eh</td>
                                                <td>0774547878</td>
                                                <td>Action</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Side -->

            </div>
        </div>

        <script src="header.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:login.php");
}
?>