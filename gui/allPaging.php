<?php
    require_once __DIR__ . "/../database/database.php";
    require_once __DIR__ . "/../database/product.php";

    $db = new database ();
    $products = new product($db);

    $sql = "SELECT * FROM products JOIN imageProductS
            ON products.idProduct = imageProductS.idProduct
            JOIN sizeProductS ON products.idProduct = sizeProductS.idProduct
            WHERE PRODUCTS.STATUS = 1";

    $sql = $sql . " GROUP BY products.idProduct";

    // echo $sql;

    $result = $products->selectByCondition($sql);
    $totalRecord = $result->num_rows;
    $totalPage = ceil($totalRecord / 8);
?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == 1) {
        ?>
        <li class="page-item active"><a class="page-link" href="#"><?php echo $i; ?></a></li>

        <?php
                }
                else {
        ?>

        <li class="page-item"><a class="page-link" href="#"><?php echo $i; ?></a></li>

        <?php
                }
            }
        ?>

    </ul>
</nav>