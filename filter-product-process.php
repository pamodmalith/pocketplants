<?php include "connection.php"; ?>
<?php
$category = $_POST['category'];
$size = $_POST['size'];
$color = $_POST['color'];
$pf = $_POST['priceFrom'];
$pt = $_POST['priceTo'];
$search = $_POST['search'];
?>


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

                    <option value="<?php echo ($d['id']); ?>" <?php if ($category == $d['id']) {
                                                                    echo ("selected");
                                                                } ?>><?php echo ($d['cat_name']); ?></option>
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

                    <option value="<?php echo ($d['id']); ?>" <?php if ($size == $d['id']) {
                                                                    echo ("selected");
                                                                } ?>><?php echo ($d['size_name']); ?></option>
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

                    <option value="<?php echo ($d['id']); ?>" <?php if ($color == $d['id']) {
                                                                    echo ("selected");
                                                                } ?>><?php echo ($d['color_name']); ?></option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="mb-2">
            <div class="fs-6 mb-1 fw-bold">
                <span data-bs-toggle="collapse" data-bs-target="#priceFrom" aria-expanded="true" class="cursor-pointer">Price From</span>
            </div>
            <input id="priceFrom" value="<?php echo ($pf); ?>" type="text" class="form-control">
        </div>
        <div class="mb-2">
            <div class="fs-6 mb-1 fw-bold">
                <span data-bs-toggle="collapse" data-bs-target="#priceTo" aria-expanded="true" class="cursor-pointer">Price To</span>
            </div>
            <input id="priceTo" value="<?php echo ($pt); ?>" type="text" class="form-control">
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

    <div class="row">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 mt-0">
            <?php

            $page = 1;
            if (isset($_POST['page']) && 1 < $_POST['page']) {
                $page = $_POST['page'];
            }

            $query = "SELECT * FROM `stock_details` ";

            $conditions = [];

            // filter by text
            if (!empty($search)) {
                $conditions[] = "`name` LIKE '%$search%' ";
            }

            // filter by category
            if ($category != 0) {
                $conditions[] = "`cat_id` = '$category'";
            }

            // filter by size
            if ($size != 0) {
                $conditions[] = "`size_id` = '$size'";
            }

            // filter by color
            if ($color != 0) {
                $conditions[] = "`color_id` = '$color'";
            }

            // filter by price from
            if (!empty($pf) && empty($pt)) {
                $conditions[] = "`price` >= '$pf'";
            }

            // filter by price from
            if (!empty($pt) && empty($pf)) {
                $conditions[] = "`price` <= '$pt'";
            }

            // filter by price range
            if (!empty($pf) && !empty($pt)) {
                $conditions[] = " `price` BETWEEN '$pf' AND '$pt' ";
            }

            // filter by price from
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $rs = Database::search(($query));
            $num = $rs->num_rows;

            $resultsPerPage = 12;
            $noOfPages = ceil($num / $resultsPerPage);
            $pageResults = ($page - 1) * $resultsPerPage;

            $query .= " LIMIT $resultsPerPage OFFSET $pageResults";
            $rs2 = Database::search($query);
            $num2 = $rs2->num_rows;

            if ($num2 > 0) {
                for ($x = 0; $x < $num2; $x++) {
                    $row = $rs2->fetch_assoc();
            ?>

                    <!-- products -->
                    <div class="col">
                        <div class="card product-card h-100">
                            <a href="single-product-view.php?name=<?php echo ($row['name']); ?>&product=<?php echo ($row['product_id']); ?>" class="stretched-link">
                                <img src="<?php echo ($row['img']); ?>" class="card-img-top" />
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title m-0 mb-2"><?php echo ($row['name']); ?></h5>
                                <p class="card-text p-0 m-0">Rs.<?php echo ($row['price']); ?>.00</p>
                                <p class="card-text p-0 m-0 mb-2"><?php echo ($row['qty']); ?>&nbsp;Items Available</p>
                            </div>
                            <div class="card-footer bg-gradient">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button style="z-index: 1024;" class="btn btn-success" onclick="addToCart(<?php echo ($row['stock_id']); ?>);">Add to Cart</button>
                                    <a href="" style="z-index: 1024;" class="btn btn-outline-success"><i class="bi bi-heart-fill"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- products -->

                <?php
                }
                ?>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    if ($num2 > 0) {
    ?>
        <!-- Pagination -->
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item ">
                    <span class="page-link cursor-pointer" <?php if ($page > 1) { ?> onclick="filter(<?php echo ($page - 1); ?>);" <?php } ?>>Previous</span>
                </li>
                <?php
                for ($i = 1; $i <= $noOfPages; $i++) {
                    if ($i == $page) {
                ?>
                        <li class="page-item active"><span class="page-link cursor-pointer" onclick="search(<?php echo ($i); ?>);"><?php echo ($i); ?></span></li>

                    <?php
                    } else {
                    ?>
                        <li class="page-item"><span class="page-link cursor-pointer" onclick="search(<?php echo ($i); ?>);"><?php echo ($i); ?></span></li>
                <?php
                    }
                }
                ?>
                <li class="page-item">
                    <span class="page-link cursor-pointer" <?php if ($page < $noOfPages) { ?> onclick="filter(<?php echo ($page + 1); ?>);" <?php } ?>>Next</span>
                </li>
            </ul>
        </nav>
        <!-- Pagination -->
    <?php
    } else {
    ?>
        <!-- empty product -->
        <div class="text-center p-5 col-12">
            <div class="empty-cart-icon">
                <i class="bi bi-exclamation-circle text-warning"></i>
            </div>
            <p class="fs-4 mb-4 text-muted">No Products Found!</p>
            <p class="fs-4 mb-4 text-muted">Let's find something amazing for you!</p>
        </div>
        <!-- empty product -->

    <?php
    }
    ?>
</div>