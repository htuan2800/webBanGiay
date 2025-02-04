<?php
    require_once __DIR__ . "/../database/database.php";
    require_once __DIR__ . "/../database/product.php";

    $db = new database ();
    $products = new product($db);

    $brand = $_GET['idBrand'];

    $sql = "SELECT * FROM products JOIN imageProductS
            ON products.idProduct = imageProductS.idProduct
            JOIN sizeProductS ON products.idProduct = sizeProductS.idProduct
            WHERE PRODUCTS.STATUS = 1 AND
            idBrand = $brand";
    if (isset($_GET['designType']) && $_GET['designType'] !== '') {
        $designType = $_GET['designType'];
        $sql = $sql . " AND designType = '$designType'";
    }

    if (isset($_GET['queryPrice']) && $_GET['queryPrice'] !== '') {
        $queryPrice = $_GET['queryPrice'];
        $sql = $sql . " AND $queryPrice";
    }

    if (isset($_GET['querySize']) && $_GET['querySize'] !== '') {
        $querySize = $_GET['querySize'];
        $sql = $sql . " AND $querySize";
    }

    $sql = $sql . " GROUP BY products.idProduct";

    echo $sql;

    $result = $products->selectByCondition($sql);
    $totalRecord = $result->num_rows;
    $totalPage = ceil($totalRecord / 4);
?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item disabled previous"><a class="page-link" href="#">Previous</a></li>

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

        <?php
            if ($totalPage > 1) {
        ?>
        <li class="page-item next"><a class="page-link" href="#">Next</a></li>

        <?php
            }
            else {
        ?>

        <li class="page-item disabled next"><a class="page-link" href="#">Next</a></li>

        <?php
            }
        ?>

    </ul>
</nav>