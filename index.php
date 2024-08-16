<?php
session_start();
require "connection.php";

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
</head>

<body>

    <div class="container">
        <?php
        include "header.php";
        ?>
    </div>


    <!-- Hero Section -->
    <div class="hero body-56">
        <div class="hero-content">
            <h1 class="mb-2">Discover Your Perfect Table Plant</h1>
            <p class="fs-5 mb-5">Find the best indoor plants to brighten up your space.</p>
            <form class="search-bar d-flex" action="shop.php" method="GET">
                <input class="form-control me-2" id="search" type="search" name="search" placeholder="Search for plants..." aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    <!-- Hero Section -->

    <!-- Featured Start -->
    <div class="container pt-4">
        <div class="row px-xl-5 pb-3">
            <div class="col-6  col-lg-3 pb-1">
                <div class="d-flex justify-content-around justify-md-content-evenly py-3 px-sm-5 px-md-0 rounded align-items-center border mb-4">
                    <h1 class="fa-solid fa-star text-success m-0 "></h1>
                    <div class="p-0 m-0">
                        <h5 class="font-weight-semi-bold m-0">Best Ratings</h5>
                        <p class="p-0 m-0 small">High user ratings</p>
                    </div>
                </div>
            </div>
            <div class="col-6  col-lg-3 pb-1">
                <div class="d-flex justify-content-around justify-md-content-evenly py-3 px-sm-5 px-md-0 rounded align-items-center border mb-4">
                    <h1 class="fa fa-shipping-fast text-success m-0 "></h1>
                    <div class="p-0 m-0">
                        <h5 class="font-weight-semi-bold m-0">Safe Delivery</h5>
                        <p class="p-0 m-0 small">You are safe hand</p>
                    </div>
                </div>
            </div>
            <div class="col-6  col-lg-3 pb-1">
                <div class="d-flex justify-content-around justify-md-content-evenly py-3 px-sm-5 px-md-0 rounded align-items-center border mb-4">
                    <h1 class="fa-solid fa-box-open text-success m-0 "></h1>
                    <div class="p-0 m-0">
                        <h5 class="font-weight-semi-bold m-0">Best Products</h5>
                        <p class="p-0 m-0 small">Quality Products</p>
                    </div>
                </div>
            </div>
            <div class="col-6  col-lg-3 pb-1">
                <div class="d-flex justify-content-around justify-md-content-evenly py-3 px-sm-5 px-md-0 rounded align-items-center border mb-4">
                    <h1 class="fa fa-phone-volume text-success m-0 "></h1>
                    <div class="p-0 m-0">
                        <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                        <p class="p-0 m-0 small">Anytime Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    <!-- Product Highlights Section -->
    <div class="container py-2" id="products">
        <h2 class="text-center">Featured Plants</h2>
        <div class="row">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php

                $rs = Database::search(" SELECT * FROM `stock_details` ORDER BY `stock_details`.`stock_id` DESC LIMIT 8 ");
                $num = $rs->num_rows;

                for ($x = 0; $x < $num; $x++) {
                    $row = $rs->fetch_assoc();
                ?>
                    <div class="col">
                        <div class="card product-card h-100">
                            <a href="single-product-view.php?name=<?php echo ($row['name']); ?>&product=<?php echo ($row['stock_id']); ?>" class="stretched-link">
                                <img src="<?php echo ($row['img']); ?>" class="card-img-top" />
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title m-0 mb-2"><?php echo ($row['name']); ?></h5>
                                <p class="card-text p-0 m-0">Rs.<?php echo ($row['price']); ?>.00</p>
                                <p class="card-text p-0 m-0 mb-2"><?php echo ($row['qty']); ?>&nbsp;Items Available</p>
                            </div>
                            <div class="card-footer bg-gradient">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button style="z-index: 1024;" class="btn btn-success" onclick="addToCart(<?php echo $row['stock_id']; ?>,<?php echo $row['qty']; ?>);">Add to Cart</button>
                                    <a href="" style="z-index: 1024;" class="btn btn-outline-success"><i class="bi bi-heart-fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>

            </div>

        </div>
    </div>
    <!-- Product Highlights Section -->

    <!-- Featured Categories Section -->
    <div class="container py-4" id="categories">
        <h2 class="text-center mb-4">Shop by Category</h2>
        <div class="row">
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="card category-card">
                    <img src="assets\products\66a2519ba9789sweese cheese s b b.jpg" class="card-img-top" alt="Indoor Plants">
                    <div class="card-body text-center">
                        <h5 class="card-title">Indoor Plants</h5>
                        <a href="#" class="btn btn-outline-success">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="card category-card">
                    <img src="assets\img\banner.jpg" class="card-img-top" alt="Indoor Plants">
                    <div class="card-body text-center">
                        <h5 class="card-title">Indoor Plants</h5>
                        <a href="#" class="btn btn-outline-success">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-4">
                <div class="card category-card">
                    <img src="assets\products\66a2519ba9789sweese cheese s b b.jpg" class="card-img-top" alt="Indoor Plants">
                    <div class="card-body text-center">
                        <h5 class="card-title">Indoor Plants</h5>
                        <a href="#" class="btn btn-outline-success">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured Categories Section -->

    <!-- Popular Products Carousel -->
    <!-- <div class="container py-3">
        <h2 class="text-center mb-4">Popular Plants</h2>
        <div id="popularProductsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/banner.jpg" class="d-block" alt="Popular Plant 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Peace Lily</h5>
                        <p>$25.00</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/products/66a252d6a3944sweese cheese b b.jpg" class="d-block " alt="Popular Plant 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Snake Plant</h5>
                        <p>$20.00</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#popularProductsCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#popularProductsCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </div> -->
    <!-- Popular Products Carousel -->

    <?php
    include "footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="header.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>