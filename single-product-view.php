<?php
session_start();
require "connection.php";
if (!isset($_GET['product']) || empty(($_GET['product']))) {
    header("Location:index.php");
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

$id = $_GET['product'];

$rs = Database::search(" SELECT * FROM `stock_details` WHERE `stock_id` ='$id' ");
$num = $rs->num_rows;

if ($num < 1) {
?>
    <script>
        alert("Product Not Found");
        window.location = "index.php";
    </script>
<?php
}

$row = $rs->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_GET['name'] ?> - Pocket Plants</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>

    <?php include "header.php"; ?>

    <div class="container rounded-3 bg-body-tertiary p-3 text-center body-70">
        <ol class="breadcrumb m-0 p-0">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $_GET['name'] ?></li>
        </ol>
    </div>

    <div class="container mt-3">
        <div class="row rounded shadow-sm">
            <div class="col-lg-6">
                <div class="p-5 d-flex justify-content-center align-items-center h-100 overflow-hidden">
                    <img class="single-img rounded" src="<?php echo $row['img']; ?>" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="pt-3 h-100 d-flex flex-column justify-content-center">
                    <h4 class="title text-dark"><?php echo $_GET['name'] ?></h4>
                    <div class="d-flex flex-row my-3">
                        <span class="text-muted"><?php echo $row['qty']; ?></span>
                        <span class="text-success ms-2">In stock</span>
                    </div>

                    <div class="mb-3">
                        <span class="h5">Rs.<?php echo $row['price']; ?>.00</span>
                        <span class="text-muted"></span>
                    </div>

                    <div class="row">
                        <p class="col-3 fw-medium">Category:</p>
                        <p class="col-9"><?php echo $row['cat_name']; ?></p>

                        <p class="col-3 fw-medium">Color:</p>
                        <p class="col-9"><?php echo $row['color_name']; ?></p>

                        <p class="col-3 fw-medium">Size:</p>
                        <p class="col-9"><?php echo $row['size_name']; ?></p>
                    </div>

                    <hr class="mt-1" />

                    <div class="row mb-4">
                        <!-- col.// -->
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <label class="fw-medium">Quantity:&nbsp;</label>
                            <div class="col-3">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button onclick='qty_dec();' class="btn btn-sm btn-success rounded-0 rounded-start">
                                            <i class="bi bi-dash-lg fw-bold"></i>
                                        </button>
                                    </div>
                                    <input id="qty" oninput='check_value(<?php echo $row["qty"]; ?>);' type="text" value="1" class="form-control form-control-sm text-center" style="max-width: 50px;">
                                    <div class="input-group-btn">
                                        <button onclick='qty_inc(<?php echo $row["qty"]; ?>);' class="btn btn-sm btn-success rounded-0 rounded-end">
                                            <i class="bi bi-plus-lg fw-bold"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="-col-9">
                                <button onclick="addToCart(<?php echo $row['stock_id']; ?>,<?php echo $row['qty']; ?>);" class="btn btn-primary shadow-0"> <i class="me-1 fa fa-shopping-basket"></i> Add
                                    to cart</button>
                                <button onclick="buyNow(<?php echo $id; ?>);" class="btn btn-warning shadow-0"> Buy now </button>
                                <?php
                                if (isset($_SESSION['user'])) {
                                    $rs = Database::search(" SELECT * FROM `wishlist` WHERE `user_id` = '$user[id]' AND `product_id` = '$id' ");
                                    $num = $rs->num_rows;
                                    if ($num > 0) {
                                ?>
                                        <button onclick="addToWishlist('<?php echo $id; ?>');" class="btn btn-outline-success"><i class="bi bi-trash-fill"></i></button>
                                    <?php
                                    } else {
                                    ?>
                                        <button onclick="addToWishlist('<?php echo $id; ?>');" class="btn btn-outline-success"><i class="bi bi-heart-fill"></i></button>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <button onclick="addToWishlist('<?php echo $id; ?>');" class="btn btn-outline-success"><i class="bi bi-heart-fill"></i></button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="p-3 rounded shadow-sm min-vh-60">

                    <ul class="nav nav-pills mb-3 d-flex gap-3" id="pills-tab">
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-bs-toggle="pill" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="delivery-tab" data-bs-toggle="pill" href="#delivery" role="tab" aria-controls="delivery" aria-selected="false">Delivery</a>
                        </li>
                    </ul>


                    <div class="tab-content" id="pills-tabContent">

                        <!-- first tab -->
                        <div class="tab-pane fade show active" id="description" role="tabpane1">
                            <div class="card-body">
                                <?php echo $row["description"]; ?>
                            </div>
                        </div>
                        <!-- first tab -->

                        <!-- second tab -->
                        <div class="tab-pane fade active" id="delivery" role="tabpane2">
                            <div class="card-body">
                                <p class="my-0 ps-3">
                                    <i class="bi bi-truck"></i>
                                    Standard Delivery
                                </p>
                                <p style="font-size: 13px;" class="text-dark text-opacity-50 mb-2 ps-4">2-3 Days</p>
                                <p class="my-0 ps-3">
                                    <i class="bi bi-wallet2"></i>
                                    Cash On Deliver Available
                                </p>
                            </div>
                        </div>
                        <!-- second tab -->

                    </div>
                </div>
            </div>

            <!-- similar items -->
            <div class="col-lg-4 mt-3 m-lg-0">
                <div class="shadow-sm rounded">
                    <div class="p-3">
                        <h5 class="card-title">Similar items</h5>

                        <?php
                        $similarRs = Database::search(" SELECT * FROM `stock_details`  LIMIT 3 ");
                        $similarNum = $similarRs->num_rows;

                        for ($i = 0; $i < $similarNum; $i++) {
                            $similarData = $similarRs->fetch_assoc();
                        ?>
                            <div class="d-flex mt-3">
                                <a href="#" class="me-3">
                                    <img src="<?php echo $similarData['img'] ?>" style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                </a>
                                <div class="info">
                                    <a href="single-product-view.php?name=<?php echo ($similarData['name']); ?>&product=<?php echo ($similarData['product_id']); ?>" class="nav-link mb-1">
                                        <?php echo $similarData['name'] ?>
                                    </a>
                                    <strong class="text-dark"> Rs.<?php echo $similarData['price'] ?>.00</strong>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
            <!-- similar items -->
        </div>
    </div>

    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="header.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>