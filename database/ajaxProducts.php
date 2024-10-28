<?php

    require_once __DIR__ . '/..\\database\\database.php';
    require_once __DIR__ . '/..\\database\\product.php';
    require_once __DIR__ . '/..\\handle.php';
    if (isset($_GET['idBrand'])) {
        $brand = $_GET['idBrand'];
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $designType = isset($_GET["designType"]) ? $_GET["designType"] : "";
        $queryPrice = isset($_GET["queryPrice"]) ? $_GET["queryPrice"] : "";
        $querySize = isset($_GET["querySize"]) ? $_GET["querySize"] : "";
        $queryDesignType = isset($_GET["queryDesignType"]) ? $_GET["queryDesignType"] : "";
        $queryOrder = isset($_GET["queryOrder"]) ? $_GET["queryOrder"] : "";
        $offset = ($page - 1) * 4;
        $offsetMax = $page * 4;

        $db = new Database();
        $products = new product($db);

        $sql = "SELECT * FROM products JOIN imageProductS
        ON products.idProduct = imageProductS.idProduct
        WHERE PRODUCTS.STATUS = 1 AND
        idBrand = $brand";
        if ($designType != "") {
            $sql = $sql . " AND designType = '$designType'";
        }
        if ($queryPrice != "") {
            $sql = $sql . " AND $queryPrice";
        }
        $sql = $sql . " GROUP BY products.idProduct";
        if ($queryOrder != "") {
            $sql = $sql . " ORDER BY $queryOrder";
        }
        $sql = $sql . "  LIMIT $offsetMax OFFSET $offset";
        echo $sql;
        $result = $products->selectByCondition($sql);
    }
?>

<?php
    while ($row = $result->fetch_assoc()) {
?>
<div class="product-item col-lg-3 col-md-3 col-sm-4">
    <div class="product-top">
        <a href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>" class="product-image">
            <img src="<?php echo $row['image']; ?>" alt="" class="img-fluid">
        </a>
    </div>
    <div class="product-info">
        <div class="product-name">
            <a
                href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>"><?php echo $row['productName']; ?></a>
        </div>
        <?php
            if ($row['oldPrice'] != 0) {
        ?>
        <div class="product-price">
            <span class="old-price"><?php echo convertPrice($row['oldPrice']); ?></span>
            <span class="current-price"><?php echo convertPrice($row['currentPrice']); ?></span>
        </div>
        <?php
            } else {
        ?>
        <div class="product-price">
            <span><?php echo convertPrice($row['currentPrice']); ?></span>
        </div>
        <?php
            }
        ?>
    </div>
</div>

<?php
    }
?>