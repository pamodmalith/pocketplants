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
        <title>Admin Reports - Pocket Plant</title>
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

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h2 class="">Reports</h2>
                    </div>

                    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3 m-0">
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis" href="admin-dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Reports
                        </li>
                    </ol>

                    <div class="d-flex row justify-content-center gap-2 mt-5">
                        <a href="admin-user-report.php" class="col-lg-5 p-0 text-decoration-none text-dark">
                            <div class=" bg-secondary bg-opacity-50 text-center rounded">
                                <h4>User Report</h4>
                                <i class="bi bi-people-fill fs-1"></i>
                            </div>
                        </a>
                        <a href="admin-product-report.php" class="col-lg-5 p-0 text-decoration-none text-dark">
                            <div class=" bg-secondary bg-opacity-50 text-center rounded">
                                <h4>Product Report</h4>
                                <i class="bi bi-trello fs-1"></i>
                            </div>
                        </a>
                        <a href="admin-stock-report.php" class="col-lg-5 p-0 text-decoration-none text-dark">
                            <div class=" bg-secondary bg-opacity-50 text-center rounded">
                                <h4>Stock Report</h4>
                                <i class="bi bi-check2-circle fs-1"></i>
                            </div>
                        </a>
                        <a href="admin-sales-report.php" class="col-lg-5 p-0 text-decoration-none text-dark">
                            <div class="bg-secondary bg-opacity-50 text-center rounded">
                                <h4>Sales Report</h4>
                                <i class="bi bi-speedometer2 fs-1"></i>
                            </div>
                        </a>
                    </div>


                </main>
                <!-- Main Body -->

            </div>
        </div>

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