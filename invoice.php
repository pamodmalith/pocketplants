<?php

include "connection.php";
session_start();

if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    header("Location: index.php");
}

$user = $_SESSION['user'];
$ohId = $_GET['id'];

$ohRs = Database::search(" SELECT * FROM `order_history` WHERE `id`='$ohId' ");
$num = $ohRs->num_rows;

if ($num < 1) {
    header("Location: index.php");
}

$oh = $ohRs->fetch_assoc();

$userAddressRs = Database::search(" SELECT * FROM `order_address` WHERE `order_history_id` = '$ohId' ");
$userAddressData = $userAddressRs->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?php echo $oh['order_id'] ?> - Pocket Plants</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary rounded fixed-top">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <a class="d-lg-none col-4 me-0" href="#"><img src="assets/img/logo.png" class="img-fluid"></a>
                <button class="navbar-toggler" type="button" id="navibut" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse d-lg-flex" id="navigation">
                <a class="col-lg-3 me-0 d-none d-lg-block" href="./"><img src="assets/img/logo.png" class="img-fluid px-md-4" /></a>
                <ul class="col-lg-6 d-flex justify-content-center navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contactSection">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav d-flex align-items-lg-center justify-content-center justify-content-md-end col-lg-3">

                    <a class="text-decoration-none text-dark me-md-3" href="cart.php"><i class="bi bi-cart2 fw-bold fs-5"></i></a>

                    <li class="nav-item dropdown d-none d-lg-block" id="dropmd">
                        <button class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if (isset($_SESSION['user'])) {
                                echo $_SESSION['user']['fname'] . " " . $_SESSION['user']['lname'];
                            } else { ?>Login/Register<?php } ?>
                        </button>
                        <ul class="dropdown-menu" id="dropdownmenu">
                            <?php
                            if (!isset($_SESSION['user'])) {
                            ?>
                                <li class="text-center"><a class="btn btn-outline-warning" href="login.php">Sign In / Sign Up</a></li>
                            <?php
                            } else {
                            ?>
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="myOrders.php">My Orders</a></li>
                                <li><a class="dropdown-item" href="#">Wishlist</a></li>
                                <li><a class="dropdown-item" href="signout.php">Sign out</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown d-lg-none">
                        <button class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if (isset($_SESSION['user'])) {
                                echo $_SESSION['user']['fname'] . " " . $_SESSION['user']['lname'];
                            } else { ?>Login/Register<?php } ?>
                        </button>
                        <ul class="dropdown-menu">
                            <?php
                            if (!isset($_SESSION['user'])) {
                            ?>
                                <li class="text-center"><a class="btn btn-outline-warning" href="login.php">Sign In / Sign Up</a></li>
                            <?php
                            } else {
                            ?>
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="myOrders.php">My Orders</a></li>
                                <li><a class="dropdown-item" href="#">Wishlist</a></li>
                                <li><a class="dropdown-item" href="signout.php">Sign out</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container body-56">
        
        <div class="row justify-content-center">
            <div class="d-print-none col-lg-9 mt-4">
                <div class="float-end">
                    <button onclick="history.back();" class="btn btn-secondary">Back</button>
                    <button onclick="printInvoice();" class="btn btn-success">Print</button>
                </div>
            </div>
        </div>

        <div class="row py-md-5 justify-content-center">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body" id="printArea">
                        <div class="">
                            <div class="mb-4 text-center">
                                <img src="assets/img/logo.png" class="img-fluid w-50" />
                            </div>
                            <h4 class="float-end font-size-15">Invoice #<?php echo $oh['order_id'] ?></h4>
                            <div class="text-muted">
                                <p class="mb-1">Pocket Plants, Inc.</p>
                                <p class="mb-1"><i class="bi bi-envelope-fill"></i>&nbsp;info@pocketplants.lk</p>
                                <p><i class="bi bi-telephone-fill"></i>&nbsp;+94 076 645 0529</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2"><?php echo $user['fname'] . " " . $user['lname'] ?></h5>
                                    <p class="mb-1"><?php echo $userAddressData['address']; ?></p>
                                    <p class="mb-1"><?php echo $user['email'] ?></p>
                                    <p><?php echo $user['mobile'] ?></p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                        <p>#<?php echo $oh['order_id'] ?></p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p><?php echo date("Y-m-d", strtotime($oh['order_date'])) ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead><!-- end thead -->
                                    <tbody>
                                        <?php
                                        $oiRs = Database::search(" SELECT `order_item`.`price`, `order_item`.`qty`, `stock_details`.`name` FROM `order_item` JOIN `stock_details` ON `order_item`.`stock_id` = `stock_details`.`stock_id`  WHERE `oh_id`='$ohId' ");

                                        $total = 0;
                                        for ($x = 0; $x < $oiRs->num_rows; $x++) {
                                            $oi = $oiRs->fetch_assoc();
                                            $total += $oi['price'] * $oi['qty'];
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $x + 1; ?></th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14 mb-1"><?php echo $oi['name']; ?></h5>
                                                    </div>
                                                </td>
                                                <td>Rs.<?php echo $oi['price']; ?>.00</td>
                                                <td><?php echo $oi['qty']; ?></td>
                                                <td class="text-end">Rs.<?php echo $oi['qty'] * $oi['price']; ?>.00</td>
                                            </tr>
                                            <!-- end tr -->
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                            <td class="text-end">Rs.<?php echo $total; ?>.00</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Discount :</th>
                                            <td class="border-0 text-end">- Rs.0.00</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Delivery Charge :</th>
                                            <td class="border-0 text-end">Rs.500.00</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 fs-5 text-end">Total:</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold">Rs.<?php echo $oh['amount'] ?>.00</h4>
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div><!-- end table responsive -->

                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="header.js"></script>
    <script src="script.js"></script>
</body>

</html>