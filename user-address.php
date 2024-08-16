<?php
include "connection.php";
session_start();

if (isset($_SESSION['user'])) {

    $uid = $_SESSION['user']['id'];
    $rs = Database::search(" SELECT * FROM `user` WHERE `id`='$uid' ");

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
        <title>User Address</title>
        <link href="bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="style.css">
        <style>
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>
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
                    <div class="container">

                        <!-- Breadcrumb -->
                        <ol class="breadcrumb p-3 bg-body-tertiary rounded-3 m-0 mb-2" style="--bs-breadcrumb-divider: '>';">
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis" href="./">
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="profile.php">Account</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Address Book</li>
                        </ol>
                        <!-- /Breadcrumb -->

                        <div class="rounded shadow-sm p-4" id="addressSec">
                            <?php
                            $userAddressRs = Database::search(" SELECT * FROM `user_address` WHERE `user_id`='$uid' ");

                            $no = "";
                            $pcode = "";
                            $province = "";
                            $city = "";
                            $street = "";

                            if ($userAddressRs->num_rows > 0) {
                                $address = $userAddressRs->fetch_assoc();

                                $no = $address['no'];
                                $pcode = $address['postal_code'];
                                $province = $address['province'];
                                $city = $address['city'];
                                $street = $address['street'];
                            }
                            ?>
                            <h2 class="update-address-header">User Address</h2>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" value="<?php echo ($no); ?>" class="form-control" id="no" placeholder="No" required>
                                        <label for="no" class=" form-label">No</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" value="<?php echo ($pcode); ?>" class="form-control" id="postal" placeholder="Zip/Postal Code">
                                        <label for="zip" class=" form-label">Zip/Postal Code</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="state" value="<?php echo ($province); ?>" placeholder="State/Province">
                                    <label for="state" class=" form-label">State/Province</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="city" value="<?php echo ($city); ?>" placeholder="City">
                                    <label for="city" class=" form-label">City</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="street" value="<?php echo ($street); ?>" placeholder="1234 Main St">
                                    <label for="street" class=" form-label">Street</label>
                                </div>
                            </div>
                            <button onclick="updateUserAddress();" class="btn btn-success">Save Address</button>
                        </div>
                    </div>
                    <!-- Right Side -->

                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="header.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:login.php");
}
?>