<?php
session_start();
require "connection.php";
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pocket Plants</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ddab9ff985.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body onload="search(1);">

    <div class="container">
        <?php
        include "header.php";
        ?>
    </div>

    <!-- top nav -->
    <div class="container body-70">
        <div class="bg-body-tertiary p-4 text-center rounded-4">
            <h1 class="fw-bold">Our Shop</h1>
            <nav aria-label="breadcrumb" class="justify-content-center d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
            </nav>
            <form class="search-bar d-flex" action="shop.php" method="GET">
                <input class="form-control me-2" id="search" value="<?php echo ($search); ?>" type="search" name="search" placeholder="Search for plants..." aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    <!-- top nav -->

    <div class="container main-content mt-4">
        <div class="row" id="allContent">

            <!-- filter -->
            <div class="col-md-4 col-lg-3 p-3">
                <div class="p-3 bg-white rounded shadow-sm mb-3 overflow-auto sticky-filter">
                    <h4 class="sticky-top bg-light-subtle">Filters</h4>

                    <!-- Category Filter -->
                    <div class="mb-2">
                        <div class="fs-6 mb-1 fw-bold">
                            <span data-bs-toggle="collapse" data-bs-target="#cat" aria-expanded="true" class="cursor-pointer">Category</span>
                        </div>
                        <select id="cat" class="collapse show form-select">

                            <option value="0">All Categories</option>

                            <?php
                            $rs = Database::search(" SELECT * FROM `category` ");
                            $num = $rs->num_rows;

                            for ($x = 0; $x < $num; $x++) {
                                $d = $rs->fetch_assoc();
                            ?>

                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['cat_name']); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Size Filter -->
                    <div class="mb-2">
                        <div class="fs-6 mb-1 fw-bold">
                            <span data-bs-toggle="collapse" data-bs-target="#size" aria-expanded="true" class="cursor-pointer">Size</span>
                        </div>
                        <select id="size" class="collapse show form-select">

                            <option value="0">All Sizes</option>

                            <?php
                            $rs = Database::search(" SELECT * FROM `size` ");
                            $num = $rs->num_rows;

                            for ($x = 0; $x < $num; $x++) {
                                $d = $rs->fetch_assoc();
                            ?>

                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['size_name']); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>



                    <!-- Color Filter -->
                    <div class="mb-2">
                        <div class="fs-6 mb-1 fw-bold">
                            <span data-bs-toggle="collapse" data-bs-target="#color" aria-expanded="true" class="cursor-pointer">Color</span>
                        </div>
                        <select id="color" class="collapse show form-select">

                            <option value="0">All Colors</option>

                            <?php
                            $rs = Database::search(" SELECT * FROM `color` ");
                            $num = $rs->num_rows;

                            for ($x = 0; $x < $num; $x++) {
                                $d = $rs->fetch_assoc();
                            ?>

                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['color_name']); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <div class="fs-6 mb-1 fw-bold">
                            <span data-bs-toggle="collapse" data-bs-target="#priceFrom" aria-expanded="true" class="cursor-pointer">Price From</span>
                        </div>
                        <input id="priceFrom" type="number" class="form-control">
                    </div>
                    <div class="mb-2">
                        <div class="fs-6 mb-1 fw-bold">
                            <span data-bs-toggle="collapse" data-bs-target="#priceTo" aria-expanded="true" class="cursor-pointer">Price To</span>
                        </div>
                        <input id="priceTo" type="number" class="form-control">
                    </div>

                    <div class="mb-2 d-flex justify-content-center">
                        <button onclick="filter(1);" class="btn btn-success w-50">Filter</button>
                    </div>

                </div>
                <!-- Sidebar Filters (Optional) -->
            </div>
            <!-- filter -->

            <div class="col-md-8 col-lg-9 pt-3">

                <!-- sort by section -->
                <div class="row align-items-center justify-content-end mb-2">
                    <div class="col-md-5 col-lg-3 d-flex justify-content-end">
                        <select id="sortBy" class="form-select" aria-label="Default select example">
                            <option value="0" disabled selected>Sort by</option>
                            <option value="1">Price: Low to High</option>
                            <option value="2">Price: High to Low</option>
                            <option value="3">Best Selling</option>
                        </select>
                    </div>
                </div>
                <!-- sort by section -->


                <!-- product load row-->
                <div id="content">

                

                </div>
                <!-- product load row-->




            </div>

        </div>
    </div>


    <?php
    include "footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="header.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>