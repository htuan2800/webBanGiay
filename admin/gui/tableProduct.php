<?php

require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/product.php";
require_once __DIR__ . "/../../database/role.php";
require_once __DIR__ . "\\..\\..\\handle.php";


$db = new database();

$product = new product($db);
$role = new role($db);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//check chuc nang xem sua va xoa
$tasks = $role->checkPermissionLook($_SESSION['account_login']['idRole'], 3);

$countTask = $tasks->num_rows;
$check = false;
$checkDeleteAndUpdate = false;
foreach ($tasks as $key => $value) {
    if ($value['idTask'] == 2 || $value['idTask'] == 3) {
        $checkDeleteAndUpdate = true;
    }
}
$tasks = $role->selectTaskById($_SESSION['account_login']['idRole'], 2);
$countTask = $tasks->num_rows;

if (isset($_POST['delete-product'])) {
    $id = $_POST['id'];
    $product->deleteProduct($id);
    exit();
}

$page = (int) isset($_POST['page']) ? $_POST['page'] : 1;
$itemOfPage = (int) isset($_POST['itemOfPage']) ? $_POST['itemOfPage'] : 10;
$valueSearch = isset($_POST['valueSearch']) ? $_POST['valueSearch'] : "";

$sql = "SELECT * FROM products
    JOIN BRANDS ON products.idBrand = BRANDS.idBrand
    JOIN imageProductS ON products.idProduct = imageProductS.idProduct
    WHERE products.STATUS = 1";

if ($valueSearch != "") {
    $sql .= " AND products.productName like '%$valueSearch%'";
}

$sql .= " GROUP BY products.idProduct
    ORDER BY products.idProduct DESC ";
$sql .= " LIMIT " . ($page - 1) * $itemOfPage . ", " . $itemOfPage . " ";

$products = $product->selectByCondition($sql);

?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Hãng</th>
                <th>Tên sản phẩm</th>
                <th>Thiết kế</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Số lượng bán</th>
                <?php
                if ($checkDeleteAndUpdate) {
                    ?>
                    <th>Chức năng</th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($products->num_rows < 0) {
                ?>

                <tr>
                    <td colspan="7">Không tìm thấy sản phẩm</td>
                </tr>


                <?php
            }
            foreach ($products as $product) {
                ?>
                <tr>
                    <td>
                        <?php echo $product['brandName'] ?>
                    </td>
                    <td>
                        <?php echo $product['productName'] ?>
                    </td>
                    <td>
                        <?php echo $product['designType'] ?>
                    </td>
                    <td>
                        <?php echo convertPrice($product['currentPrice']); ?>
                    </td>
                    <td>
                        <?php
                        $image = '.' . $product['image'] . "?" . time();
                        ?>
                        <img src="<?php echo $image ?>" alt="" width="50" height="50">
                    </td>
                    <td>
                        <?php echo $product['quantitySold'] ?>
                    </td>
                    <?php
                    if ($countTask > 0) {
                        ?>
                        <td>
                            <div class="action">
                                <?php
                                foreach ($tasks as $key => $value) {
                                    if ($value['idTask'] == 2) {
                                        ?>
                                        <i class="fa fa-trash" data-id="<?php echo $product['idProduct'] ?>"></i>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($value['idTask'] == 3) {
                                        ?>
                                        <i class="fa fa-edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                            data-id="<?php echo $product['idProduct'] ?>"></i>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </td>

                        <?php
                    }
                    ?>

                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<div class="pagination">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link previous disabled" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <?php
        $db = new database();
        $product = new product($db);
        $page = $product->pagination($itemOfPage, $valueSearch);
        for ($i = 1; $i <= $page; $i++) {
            ?>

            <?php
            if ($i == 1) {
                ?>

                <li class="page-item active"><a class="page-link" href="#"><?php echo $i ?></a></li>

                <?php
            } else {
                ?>

                <li class="page-item"><a class="page-link" href="#"><?php echo $i ?></a></li>

                <?php
            }
        }
        ?>

        <li class="page-item">
            <a class="page-link next" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</div>