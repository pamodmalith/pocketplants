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
                            <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
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
                            <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
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