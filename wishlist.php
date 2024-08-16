<?php
session_start();
require "connection.php";

if (isset($_SESSION['user'])) {

    $userId = $_SESSION['user']['id'];
    $rs = Database::search(" SELECT * FROM `user` WHERE `id`='$userId' ");

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
        <title>WishList - Pocket Plants</title>
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
                            Wishlist
                        </li>
                    </ol>
                    <!-- breadcrumb -->

                    <div class="row">

                        <?php
                        $rs = Database::search(" SELECT * FROM `wishlist` WHERE `user_id` = '$userId' ");
                        $num = $rs->num_rows;
                        for ($i = 0; $i < $num; $i++) {
                            $row = $rs->fetch_assoc();
                            $productId = $row['product_id'];
                            $productRs = Database::search(" SELECT * FROM `product` WHERE `id` = '$productId' ");
                            $product = $productRs->fetch_assoc();
                        ?>
                            <div class="col-12 mb-4">
                                <div class="wishlist-item p-3 border rounded d-flex align-items-center">
                                    <a href="single-product-view.php?name=<?php echo ($product['name']); ?>&product=<?php echo ($product['id']); ?>">
                                        <img src="<?php echo $product['img'] ?>" alt="Plant Image" class="me-3" style="width: 100px; height: 100px; object-fit: cover;">
                                    </a>
                                    <div class="flex-grow-1 text-truncate me-2">
                                        <h5 class="mb-1"><?php echo $product['name'] ?></h5>
                                        <p class="mb-2 text-muted"><?php echo $product['description'] ?></p>
                                    </div>
                                    <button onclick="removeFromWishlist('<?php echo $row['id'] ?>');" class="btn btn-outline-danger btn-sm">Remove</button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="header.js"></script>
        <script src="script.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location:login.php");
}
?>