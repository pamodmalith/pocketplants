<?php
session_start();
require "connection.php";
if ($_SESSION['admin']) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/admin-panel.png" type="image/x-icon">
        <title>Product Management - Pocket Plant</title>
        <link rel="stylesheet" href="bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="admin-style.css" rel="stylesheet">
    </head>

    <body onload="loadProducts(1);">

        <!-- Header -->
        <?php include "admin-header.php" ?>
        <!-- Header -->

        <div class="container-fluid admin-body">
            <div class="row">

                <!-- Nav Bar -->
                <?php include "admin-navbar.php" ?>
                <!-- Nav Bar End -->

                <!-- Main Body -->
                <main class=" ms-sm-auto col-lg-10 px-md-4">

                    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3 m-0 mt-3 mb-2">
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis" href="admin-dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <!-- <li class="breadcrumb-item">
                            <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Library</a>
                        </li> -->
                        <li class="breadcrumb-item active" aria-current="page">
                            Product Management
                        </li>
                    </ol>

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h2 class="">Product Management</h2>
                    </div>


                    <div class="container mb-2">
                        <div class="bg-light text-center rounded p-2">
                            <div class="row">

                                <div class="col-12 col-sm-7 col-lg-3">
                                    <div class="row">
                                        <div class="col-6 col-sm-12">
                                            <input oninput="searchProducts(1);" id="productSearch" type="text" class="form-control" placeholder="Search products...">
                                        </div>
                                        <div class="col-6 d-sm-none text-end">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Product</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-none d-sm-block col-sm-5 d-lg-none text-end">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Product</button>
                                </div>

                                <div class="col-12 mt-2 d-block d-lg-none">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add New Category</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addColorModal">Add New Color</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSizeModal">Add New Size</button>
                                </div>

                                <div class="col-12 col-lg-9 d-none d-lg-block text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add New Category</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addColorModal">Add New Color</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSizeModal">Add New Size</button>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Product</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product List Table -->
                    <div class="container" id="content">

                        <!-- load products -->

                    </div>
                </main>
                <!-- Main Body -->

                <!-- Add Product Modal -->
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="productName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="productName" placeholder="Enter product name">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="productCategory" class="form-label">Product Category</label>
                                        <select class="form-select" id="productCategory" required>
                                            <option value="0" selected disabled>Select category</option>

                                            <?php
                                            $rs = Database::search(" SELECT * FROM `category` ");
                                            $num = $rs->num_rows;

                                            for ($x = 0; $x < $num; $x++) {
                                                $d = $rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['cat_name']); ?></option>
                                            <?php
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="productSize" class="form-label">Product Size</label>
                                        <select class="form-select" id="productSize" required>
                                            <option value="0" selected disabled>Select Size</option>

                                            <?php
                                            $rs = Database::search(" SELECT * FROM `size` ");
                                            $num = $rs->num_rows;

                                            for ($x = 0; $x < $num; $x++) {
                                                $d = $rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['size_name']); ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="productDescription" class="form-label">Product Description</label>
                                    <textarea class="form-control" id="productDescription" rows="3" placeholder="Enter product description"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="productCost" class="form-label">Product Cost</label>
                                        <input type="number" class="form-control" id="productCost" onchange="valueLessError('productCost','Cannot be less than 1');" placeholder="Enter Product Cost">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="productPrice" class="form-label">Selling Price</label>
                                        <input type="number" class="form-control" id="productPrice" onchange="valueLessError('productPrice','Cannot be less than 1');" placeholder="Enter Selling Price">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="productColor" class="form-label">Product Color</label>
                                        <select class="form-select" id="productColor" required>
                                            <option value="0" selected disabled>Select Color</option>

                                            <?php
                                            $rs = Database::search(" SELECT * FROM `color` ");
                                            $num = $rs->num_rows;

                                            for ($x = 0; $x < $num; $x++) {
                                                $d = $rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['color_name']); ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="">
                                    <label for="productImage" class="form-label">Product Image</label>
                                    <input onclick="previewImg();" type="file" class="form-control mb-3" id="productImage" accept="image/*">
                                    <div class="mb-3 d-flex justify-content-start d-none" id="preview">
                                        <div class="col-3">
                                            <img src="" id="i" class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="registerProduct();" class="btn btn-primary">Save Product</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Product Modal -->

                <!-- Edit Product Modal -->
                <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="addNewProductModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewProductModal">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-4 ">
                                        <label for="uProductName" class="form-label">Product Name</label>
                                        <input id="uId" class="d-none"></input>
                                        <input type="text" class="form-control" id="uName" placeholder="Enter product name">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="uCat" class="form-label">Product Category</label>
                                        <select class="form-select" id="uCat" disabled>
                                            <option value="0">Select category</option>
                                            <?php
                                            $rs = Database::search(" SELECT * FROM `category` ");
                                            $num = $rs->num_rows;

                                            for ($x = 0; $x < $num; $x++) {
                                                $d = $rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['cat_name']); ?></option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="productSize" class="form-label">Product Size</label>
                                        <select class="form-select" id="uSize" disabled>
                                            <option value="0" disabled>Select Size</option>
                                            <?php
                                            $rs = Database::search(" SELECT * FROM `size` ");
                                            $num = $rs->num_rows;

                                            for ($x = 0; $x < $num; $x++) {
                                                $d = $rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['size_name']); ?></option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="uDes" class="form-label">Product Description</label>
                                    <textarea class="form-control" id="uDes" rows="3" placeholder="Enter product description"></textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 mb-3">
                                        <label for="uCost" class="form-label">Product Cost</label>
                                        <input type="number" id="uCost" oninput="valueLessError('uCost','Cannot be less than 1');" class="form-control" placeholder="Enter price" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="uPrice" class="form-label">Selling Price</label>
                                        <input type="number" id="uPrice" oninput="valueLessError('uPrice','Cannot be less than 1');" class="form-control" placeholder="Enter product color" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="uColor" class="form-label">Product Color</label>
                                        <select class="form-select" id="uColor" required>
                                            <option value="0" disabled>Select Color</option>
                                            <?php
                                            $rs = Database::search(" SELECT * FROM `color` ");
                                            $num = $rs->num_rows;

                                            for ($x = 0; $x < $num; $x++) {
                                                $d = $rs->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($d['id']); ?>"><?php echo ($d['color_name']); ?></option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label for="uImg" class="form-label">Product Image</label>
                                        <input onclick="uPreviewImg();" type="file" class="form-control mb-3" id="uImg" accept="image/*">
                                        <div class=" d-flex justify-content-start" id="uPreview">
                                            <div class="col-3">
                                                <img id="img" class="img-fluid" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" onclick="updateProduct();">Edit Product</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Product Modal -->

                


                <!-- Add Category Modal -->
                <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="newCategoryName" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="newCategoryName" placeholder="Enter category name">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="addNewCat();" class="btn btn-primary">Add Category</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Category Modal -->

                <!-- Add Color Modal -->
                <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addColorModalLabel">Add New Color</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="newColorName" class="form-label">Color Name</label>
                                    <input type="text" class="form-control" id="newColorName" placeholder="Enter Color name">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="addNewColor();" class="btn btn-primary">Add Color</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Color Modal -->

                <!-- Add Size Modal -->
                <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSizeModalLabel">Add New Size</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="newSizeName" class="form-label">Size Name</label>
                                    <input type="text" class="form-control" id="newSizeName" placeholder="Enter Size name">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="addNewSize();" class="btn btn-primary">Add Size</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Size Modal -->
            </div>


            <?php include "admin-footer.php" ?>


            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="bootstrap.bundle.js"></script>
            <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
            <script src="script.js"></script>
    </body>

<?php
} else {
    header("Location: admin-login.php");
}
?>
