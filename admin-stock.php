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
        <title>Stock Management - Pocket Plant</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="admin-style.css" rel="stylesheet">
    </head>

    <body onload="loadStocks(1);">

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
                            Stock Management
                        </li>
                    </ol>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <div class="col-12 col-sm-8">
                            <h2 class="">Stock Management</h2>
                        </div>
                        <div class="col-12 col-sm-4 d-flex justify-content-sm-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStock">Add Stock</button>
                        </div>
                    </div>


                    <!-- Stock List Table -->
                    <div class="container" id="content">

                    </div>
                    <!-- Stock Table -->
                     
                </main>
                <!-- Main Body -->



                <!-- Add Stock Modal -->
                <div class="modal fade" id="addStock" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Add Stock</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="product" class="form-label">Product</label>
                                    <select onchange="changeImgStock();" id="product" class="form-select">
                                        <option value="0">Select Product</option>
                                        <?php
                                        $rs = Database::search(" SELECT * FROM `product_details` WHERE `status` ='1' ");
                                        $num = $rs->num_rows;

                                        for ($i = 0; $i < $num; $i++) {
                                            $row = $rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo ($row['id']); ?>"><?php echo ($row['id'] . " - " . $row['name'] . " - " . $row['color_name'] . " - " . $row['size_name']); ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="qty" class="form-label">Qty</label>
                                    <input id="qty" type="text" class="form-control">
                                </div>
                                <div class="mb-3 d-flex justify-content-start d-none" id="stockImgDiv">
                                    <div class="col-5">
                                        <img src="" id="stockImg" class="img-fluid" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="addNewStock();" type="button" class="btn btn-primary">Add Stock</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Stock Modal -->

            </div>
        </div>


        <?php include "admin-footer.php" ?>


        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script src="script.js"></script>
    </body>

<?php
} else {
    header("Location: admin-login.php");
}
?>