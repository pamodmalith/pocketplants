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
        <title>User Profile</title>
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
                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                        </ol>
                        <!-- /Breadcrumb -->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="rounded shadow-sm h-100 px-2 d-flex flex-column align-items-center justify-content-center text-center">
                                    <?php
                                    $profile = "assets/profile/default.png";
                                    if (isset($user['profile']) && !empty($user['profile'])) {
                                        $profile = $user['profile'];
                                    }
                                    ?>
                                    <img src="<?php echo $profile ?>" class="img-150-circle" id="profileImgTag">
                                    <div class="mt-3 px-3">
                                        <h4><?php echo $user['fname'] . " " . $user['lname'] ?></h4>
                                        <input onclick="previewProfile();" type="file" id="profileImg" class="form-control form-control-sm">
                                        <button onclick="updateProfileImg();" class="btn btn-success w-100 mb-2 mt-2">Update Profile Picture</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 mt-3 mt-xl-0">
                                <div class="rounded shadow-sm h-100 d-flex flex-column align-items-center text-center p-3">
                                    <h4 class="mb-3">Personal Details</h4>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="firstName" id="fname" value="<?php echo ($user['fname']); ?>" placeholder="First Name" required>
                                            <label for="fname" class="form-label">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="lastName" id="lname" value="<?php echo ($user['lname']); ?>" placeholder="First Name" required>
                                            <label for="lname" class="form-label">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo ($user['mobile']); ?>" placeholder="First Name" required>
                                            <label for="mobile" class="form-label">Mobile</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" id="email" value="<?php echo ($user['email']); ?>" placeholder="name@example.com" disabled>
                                            <label for="email" class="form-label">Email</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-success" onclick="updatePersonalData();">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Side -->

                </div>
            </div>
        </div>
        <script src="header.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:login.php");
}
?>