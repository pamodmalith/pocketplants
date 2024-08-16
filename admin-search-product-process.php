<div class="bg-light text-center rounded p-3 mb-2">
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include "connection.php";

                $page = 1;
                $keyword = "";

                if (isset($_GET['keyword'])) {
                    $keyword = $_GET['keyword'];
                }

                if (isset($_GET["page"]) && $_GET["page"] > 1) {
                    $page = $_GET["page"];
                }

                $rs = Database::search(" SELECT * FROM `product_details` ");
                $num = $rs->num_rows;

                $resultsPerPage = 5;
                $noOfPages = ceil($num / $resultsPerPage);
                $pageResults = ($page - 1) * $resultsPerPage;

                $rs2 = Database::search("SELECT * FROM `product_details` WHERE `name` LIKE '%$keyword%' LIMIT $resultsPerPage OFFSET $pageResults ");
                $num2 = $rs2->num_rows;

                for ($x = 0; $x < $num2; $x++) {
                    $row = $rs2->fetch_assoc();

                    $qtyRs = Database::search(" SELECT * FROM `stock_details` WHERE `product_id` = '" . $row['id'] . "' ");
                    $qtyData = $qtyRs->fetch_assoc();
                    $productQty = 0;
                    if (!empty($qtyData['qty'])) {
                        $productQty = $qtyData['qty'];
                    }
                ?>

                    <tr>
                        <td><?php echo ($row['id']); ?></td>
                        <td><?php echo ($row['name']); ?></td>
                        <td><?php echo ($row['cat_name']); ?></td>
                        <td><?php echo ($row['color_name']); ?></td>
                        <td><?php echo ($row['size_name']); ?></td>
                        <td>Rs.<?php echo ($row['price']); ?>.00</td>
                        <td><button class="btn btn-warning btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#editProductModal">Edit</button></td>
                        <td>
                            <?php
                            if ($row['status'] == 1) {
                            ?>
                                <button onclick="changeProductStatus(<?php echo $row['id']; ?>,<?php echo ($page); ?>);" class="btn btn-sm btn-success fw-bold">Active</button>
                            <?php
                            } else {
                            ?>
                                <button onclick="changeProductStatus(<?php echo $row['id']; ?>,<?php echo ($page); ?>);" class="btn btn-sm btn-danger fw-bold">Deactive</button>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>

                <?php
                }
                ?>
                <!-- More product rows as needed -->
            </tbody>
        </table>
    </div>
</div>

<div class="bg-light text-center rounded">
    <ul class="pagination justify-content-center align-items-center py-2">
        <li class="page-item hover">
            <a class="page-link" aria-label="Previous" <?php if ($page > 1) { ?> onclick="loadProducts(<?php echo ($page - 1); ?>);" <?php } ?>>
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php
        for ($i = 1; $i <= $noOfPages; $i++) {
            if ($i == $page) {
        ?>
                <li class="page-item hover active"><a class="page-link" onclick="loadProducts(<?php echo ($i); ?>);"><?php echo ($i); ?></a></li>

            <?php
            } else {
            ?>
                <li class="page-item hover"><a class="page-link" onclick="loadProducts(<?php echo ($i); ?>);"><?php echo ($i); ?></a></li>
        <?php
            }
        }
        ?>


        <li class="page-item hover">
            <a class="page-link" aria-label="Next" <?php if ($page < $noOfPages) { ?> onclick="loadProducts(<?php echo ($page + 1); ?>);" <?php } ?>>
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</div>