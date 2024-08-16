<?php
session_start();
if ($_SESSION['admin']) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/admin-panel.png" type="image/x-icon">
        <title>User Management - Pocket Plant</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="admin-style.css" rel="stylesheet">
    </head>

    <body onload="loadUsers(1);">

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
                        <!-- <li class="breadcrumb-item">
                            <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Library</a>
                        </li> -->
                        <li class="breadcrumb-item active" aria-current="page">
                            User Management
                        </li>
                    </ol>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h2 class="">User Management</h2>
                    </div>

                    <!-- Table -->
                    <div class="container-fluid">
                        <div class="bg-light rounded p-4">
                            <div class="table-responsive" id="content">

                            
                                                            
                            </div>
                        </div>
                    </div>




                </main>
                <!-- Main Body -->

            </div>
            
        </div>

        <?php include "admin-footer.php" ?>

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