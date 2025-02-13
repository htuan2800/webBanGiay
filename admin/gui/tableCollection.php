<?php

require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/brand.php";
require_once __DIR__ . "\\..\\..\\handle.php";

$db = new database();

$brand = new brand($db);

if (isset($_POST['delete-product'])) {
    $id = $_POST['id'];
    $product->deleteProduct($id);
    exit();
}

$page = (int) isset($_POST['page']) ? $_POST['page'] : 1;
$itemOfPage = (int) isset($_POST['itemOfPage']) ? $_POST['itemOfPage'] : 10;
$valueSearch = isset($_POST['valueSearch']) ? $_POST['valueSearch'] : "";

$sql = "SELECT * FROM brands";

if ($valueSearch != "") {
    $sql .= " where brandName like '%$valueSearch%'";
}

$sql .= " GROUP BY idBrand
    ORDER BY idBrand DESC ";
$sql .= " LIMIT " . ($page - 1) * $itemOfPage . ", " . $itemOfPage . " ";

$brands = $brand->selectByCondition($sql);

?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>Hãng</th>
                <th>Logo</th>
                <th></th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($brands->num_rows < 0) {
            ?>

                <tr>
                    <td colspan="7">Không tìm thấy danh mục</td>
                </tr>


            <?php
            }
            foreach ($brands as $item) {
            ?>
                <tr>
                    <td>
                        <?php echo $item['brandName'] ?>
                    </td>

                    <td>
                        <?php
                        $image = '.' . $item['imageLogo'] . "?" . time();
                        ?>
                        <img src="<?php echo $image ?>" alt="" width="100" height="100">
                    </td>
                    <td></td>
                    <td>
                        <div class="action">

                            <i class="fa fa-edit" data-bs-toggle="modal" data-bs-target="#info-collection"
                                data-id="<?php echo $item['idBrand'] ?>"></i>
                        </div>
                    </td>
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
        $brand = new brand($db);
        $page = $brand->pagination($itemOfPage, $valueSearch);
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