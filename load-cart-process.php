<?php

include "connection.php";
session_start();

if (isset($_SESSION['user'])) {

    $userId = $_SESSION['user']['id'];

    $rs = Database::search(" SELECT * FROM `cart` WHERE `user_id` = '$userId' ");
    $num = $rs->num_rows;
?>

    <?php
    if ($num > 0) {
    ?>

        <div class="container bg-body-tertiary p-4 mt-3 text-center rounded-4 ">
            <h1 class="fw-bold">Your Shopping Cart</h1>
            <p class="text-muted fs-5">Review your selected items and proceed to checkout</p>
            <nav aria-label="breadcrumb" class="justify-content-center d-flex">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>

        <div class="col-xl-8 mt-5">
            <?php

            $netTotal = 0;

            for ($i = 0; $i < $num; $i++) {
                $row = $rs->fetch_assoc();
                $stockId = $row['stock_id'];

                $stockRs = Database::search(" SELECT * FROM `stock_details` WHERE `stock_id` = '$stockId' ");
                $stock = $stockRs->fetch_assoc();


            ?>

                <!-- items -->
                <div class="card border shadow-sm mb-3 overflow-auto">
                    <div class="card-body">
                        <div class="d-flex align-items-start border-bottom pb-3">
                            <div class="me-4">
                                <img src="<?php echo ($stock['img']); ?>" alt="" class="product-lg rounded">
                            </div>
                            <div class="flex-grow-1 align-self-center">
                                <div>
                                    <h5 class="text-truncate"><a href="#" class="text-dark"><?php echo ($stock['name']); ?></a></h5>
                                    <p class="mb-0 mt-1">Color : <span class="fw-medium"><?php echo ($stock['color_name']); ?></span></p>
                                    <p class="mb-0 mt-1">Size : <span class="fw-medium"><?php echo ($stock['size_name']); ?></span></p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <button onclick="removeFromCart(<?php echo ($row['id']); ?>);" class="btn bg-danger-subtle px-1">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <div class="row justify-content-evenly align-items-center">
                                <div class="col-4 col-md-3">
                                    <div class="mt-3 d-flex align-items-center">
                                        <h6 class=" p-0 m-0 text-muted">Price:&nbsp;</h6>
                                        <?php
                                        $pTotal = $stock['price'] * $row['qty'];
                                        $netTotal += $pTotal;
                                        ?>
                                        <h5 class="p-0 m-0">Rs.<?php echo $stock['price']; ?>.00</h5>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 d-flex justify-content-center">
                                    <div class="mt-3 d-flex align-items-center ">
                                        <p class="m-0 p-0 d-none d-md-block">Quantity:&nbsp;</p>
                                        <div class="input-group mr-3">
                                            <div class="input-group-btn">
                                                <button onclick="decrementCartQty(<?php echo $row['id']; ?>);" class="btn btn-sm btn-success rounded-0 rounded-start">
                                                    <i class="bi bi-dash-lg fw-bold"></i>
                                                </button>
                                            </div>
                                            <input id="qty-<?php echo $row['id']; ?>" type="text" value="<?php echo ($row['qty']); ?>" disabled class="form-control form-control-sm text-center" style="max-width: 50px;">
                                            <div class="input-group-btn">
                                                <button onclick="incrementCartQty(<?php echo $row['id']; ?>);" class="btn btn-sm btn-success rounded-0 rounded-end">
                                                    <i class="bi bi-plus-lg fw-bold"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-md-3">
                                    <div class="mt-3 d-flex align-items-center justify-content-end">
                                        <h6 class=" p-0 m-0 text-muted">Total:&nbsp;</h6>
                                        <h5 class="p-0 m-0">Rs.<?php echo $pTotal; ?>.00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- items -->

            <?php
            }
            ?>
        </div>

        <!-- chekout part -->
        <div class="col-xl-4 mt-5">
            <div class="mt-5 mt-lg-0 sticky-cart-checkout">
                <div class="card border shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3 px-4">
                        <h5 class="font-size-16 mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body p-4 pt-2">

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td>Sub Total :</td>
                                        <td class="text-end">Rs.<?php echo $netTotal; ?>.00</td>
                                    </tr>
                                    <tr>
                                        <td>Number of Items : </td>
                                        <td class="text-end"><?php echo $num; ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        $delivery = 500;
                                        $netTotal += $delivery;
                                        ?>
                                        <td>Delivery Charge :</td>
                                        <td class="text-end">Rs.<?php echo $delivery; ?>.00</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <th>Net Total :</th>
                                        <td class="text-end">
                                            <span class="fw-bold">
                                                Rs.<?php echo $netTotal; ?>.00
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <button onclick="checkout();" class="btn btn-success "><i class="mdi mdi-cart-outline me-1"></i>Proceed To Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- chekout part -->

    <?php
    } else {
    ?>
        <!-- empty cart -->
        <div class="container empty-cart-container">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <p class="fs-4 mb-4 text-muted">Your cart is currently empty.</p>
            <p class="fs-4 mb-4 text-muted">Let's find something amazing for you!</p>
            <div class="empty-cart-actions mt-4">
                <a href="./" class="btn btn-primary fs-5 m-1 py-3 px-3">Continue Shopping</a>
            </div>
        </div>
        <!-- empty cart -->

    <?php
    }
    ?>
<?php
}
?>