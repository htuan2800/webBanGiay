<?php

    require_once __DIR__ . '/..\\database\\database.php';
    require_once __DIR__ . '/..\\database\\product.php';
    require_once __DIR__ . '/..\\handle.php';
    
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    echo $page;
    $offset = ($page - 1) * 8;
    $offsetMax = 8;

    $db = new Database();
    $products = new product($db);

    $sql = "SELECT * FROM products JOIN imageProductS
    ON products.idProduct = imageProductS.idProduct
    JOIN sizeProductS ON products.idProduct = sizeProductS.idProduct
    WHERE PRODUCTS.STATUS = 1 ";
    $sql = $sql . " GROUP BY products.idProduct";
    $sql = $sql . "  LIMIT $offsetMax OFFSET $offset";
    echo $sql;
    $result = $products->selectByCondition($sql);
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