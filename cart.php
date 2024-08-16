<?php
session_start();
if ($_SESSION['user']) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart - Pocket Plant</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/ddab9ff985.js" crossorigin="anonymous"></script>
    </head>

    <body onload="loadCart();">

        <!-- Header -->
        <?php include "header.php" ?>
        <!-- Header -->



        <div class="container body-56">
            <div class="row" id="content">


                <!-- load cart items -->



            </div>

        </div>



        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

<?php
} else {
    header("Location: login.php");
}
?>