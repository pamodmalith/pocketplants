<?php require "connection.php"; ?>

<div class="row">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 mt-0">
        <?php
        $search = $_GET['search'];

        $page = 1;
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $page = $_GET['page'];
        }
        $rs = Database::search(" SELECT * FROM `stock_details` WHERE `name` LIKE '%$search%' AND `status`='1' ");
        $num = $rs->num_rows;

        $resultPerPage = 12;
        $noOfPages = ceil($num / $resultPerPage);
        $pageResults = ($page - 1) * $resultPerPage;

        $rs2 = Database::search(" SELECT * FROM `stock_details` WHERE `name` LIKE '%$search%' AND `status`='1' LIMIT $resultPerPage OFFSET $pageResults ");
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
                <span class="page-link cursor-pointer" <?php if ($page > 1) { ?> onclick="search(<?php echo ($page - 1); ?>);" <?php } ?> >Previous</span>
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
                <span class="page-link cursor-pointer" <?php if ($page < $noOfPages) { ?> onclick="search(<?php echo ($page + 1); ?>);" <?php } ?>>Next</span>
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