<?php
    require_once "./database/database.php";
    require_once "./database/brand.php";
    require_once "./database/product.php";
    require_once __DIR__ . "/database/evalution.php";
    require_once "./handle.php";
    $db = new database();
    $brands = new brand($db);
    $products = new product($db);
    $evaluation = new evalution($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- slick css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- custom css -->
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/detail.css">
</head>

<body>

    <!-- navbar -->
    <div class="container-fluid">
        <?php
            include "./gui/navbar.php";
        ?>
    </div>

    <!-- detail product -->
    <div class="container-fluid detail-product row">
        <?php
            $product = $products->selectProductById($_GET['idProduct']);
            $images = $products->selectImageById($_GET['idProduct']);
            $sizes = $products->selectSizeById($_GET['idProduct']);
        ?>


        <!-- image -->
        <div class="image col-lg-6 col-md-12 col-sm-12 row">
            <div class="main-image col-lg-10 col-md-12 col-sm-12">
                <img src="<?php echo $images[0]['image']; ?>" alt="" class="img-fluid">
                <div class="button-swap">
                    <i class="fa-solid fa-angle-left prev"></i>
                    <i class="fa-solid fa-angle-right next"></i>
                </div>
            </div>
            <div class="slide col-lg-2 col-md-12 col-sm-12 row">
                <?php
                    $i = 0;
                    foreach ($images as $image) {
                        if ($i == 0) {
                ?>
                <img src="<?php echo $image['image']; ?>" alt="" class="img-fluid col-lg-12 col-md-2 col-sm-2 selected">
                <?php
                    }
                    else {
                ?>
                <img src="<?php echo $image['image']; ?>" alt="" class="img-fluid col-lg-12 col-md-2 col-sm-2">
                <?php
                        }
                        $i++;
                    }
                ?>
            </div>
        </div>

        <!-- info -->
        <div class="info col-lg-6 col-md-12 col-sm-12 row">
            <div class="name col-lg-12 col-md-12 col-sm-12">
                <h2><?php echo $product['productName']; ?></h2>
            </div>

            <!-- price and star -->
            <div class="price-and-star col-lg-12 col-md-12 col-sm-12">
                <?php
                    if ($product['oldPrice'] != 0) {
                ?>

                <span class="old-price"><?php echo convertPrice($product['oldPrice']); ?></span>
                <span class="current-price"><?php echo convertPrice($product['currentPrice']); ?></span>

                <?php
                    }
                    else {
                ?>
                <span><?php echo convertPrice($product['currentPrice']); ?></span>
                <?php
                    }
                ?>

                <div class="star">
                    <?php
                        for ($i = 0; $i < $evaluation->getAverageRating($product['idProduct']); $i++) {
                    ?>
                    <i class="fa-solid fa-star"></i>
                    <?php
                        }
                    ?>
                </div>
            </div>


            <!-- size -->
            <div class="size col-lg-12 col-md-12 col-sm-12">
                <span>Size:</span>
                <?php
                    $i = 0;
                    foreach ($sizes as $size) {
                        if ($i == 0) {
                ?>
                <button class="selected"
                    data-quantity="<?php echo $size['quantityRemain']; ?>"><?php echo $size['size']; ?></button>
                <?php
                        }
                        else {
                ?>
                <button data-quantity="<?php echo $size['quantityRemain']; ?>"><?php echo $size['size']; ?></button>

                <?php
                        }$i++;}
                ?>
            </div>

            <!-- status -->
            <div class="status col-lg-12 col-md-12 col-sm-12">
                <?php
                    if ($sizes[0]['quantityRemain'] == 0) {
                ?>

                <span class="Out-of-Stock">Hết hàng</span>


                <?php
                    }
                    else {
                ?>
                <span>Còn <?php echo $sizes[0]['quantityRemain']; ?> sản phẩm</span>

                <?php
                    }
                ?>
            </div>

            <!-- quantity -->
            <div class="quantity col-lg-12 col-md-12 col-sm-12">
                <div>
                    <button class="btn-minus">-</button>
                    <input type="text" value="<?php echo $sizes[0]['quantityRemain'] > 0 ? 1 : 0; ?>"
                        inputmode="numeric" >
                    <button class="btn-plus">+</button>
                </div>
            </div>

            <!-- buy and cart -->
            <div class="buy col-lg-12 col-md-12 col-sm-12">
                <button class="btn-buy">Mua ngay</button>
                <button class="btn-cart">Thêm vào giỏ hàng</button>
            </div>
        </div>
    </div>

    <!-- rating -->
    <div class="container-fluid rating row">
        <div class="title col-lg-12 col-md-12 col-sm-12">
            <h2>Đánh giá sản phẩm</h2>
            <span>(<?php echo $evaluation->getCountEvalutionByProduct($_GET['idProduct']); ?>)</span>
        </div>

        <?php
                $result = $evaluation->getEvalutionByProduct($_GET['idProduct']);
                while ($row = $result->fetch_assoc()) {
            ?>

        <div class="rating col-lg-12 col-md-12 col-sm-12 row">
            <div class="avatar col-lg-1 col-md-2 col-sm-2">
                <img src="./avatar/default-avatar.jpg" alt="" class="img-fluid">
            </div>

            <div class="info col-lg-9 col-md-8 col-sm-8">
                <div class="name">
                    <span><?php echo $row['fullName']; ?></span>
                </div>
                <div class="time">
                    <span><?php echo convertDate($row['createAtEvaluation']) ?></span>
                </div>
                <div class="comment">
                    <p><?php echo $row['content']; ?></p>
                </div>
            </div>

            <div class="star col-lg-2 col-md-2 col-sm-2">
                <?php
                    for ($i = 0; $i < $row['rating']; $i++) {
                ?>
                <i class="fa-solid fa-star"></i>
                <?php
                    }
                    ?>
            </div>
        </div>

        <?php
                }
        ?>
        <?php
            if ($evaluation->getCountEvalutionByProduct($_GET['idProduct']) > 5) {
        ?>
        <div class="show-more col-lg-12 col-md-12 col-sm-12">
            <button class="btn-show-more">Xem thêm</button>
        </div>

        <?php
            }
        ?>
    </div>

    <!-- related product -->
    <div class="container-fluid related-product row">
        <div class="title col-lg-12 col-md-12 col-sm-12">
            <h2>Sản phẩm tương tự</h2>
        </div>

        <div class="products col-lg-12 col-md-12 col-sm-12 row">
            <?php
                $result = $products->selectProductByDesignType ($product['designType']);
                foreach ($result as $product) {
            ?>

            <div class="product-item col-lg-3 col-md-6 col-sm-6">
                <div class="product-top">
                    <a href="./detailProduct.php?idProduct=<?php echo $product['idProduct']; ?>" class="product-image">
                        <img src="<?php echo $product['image']; ?>" loading="lazy" alt="" class="img-fluid">
                    </a>
                </div>
                <div class="product-info">
                    <div class="product-name">
                        <a
                            href="./detailProduct.php?idProduct=<?php echo $product['idProduct']; ?>"><?php echo $product['productName']; ?></a>
                    </div>
                    <div class="product-price">
                        <?php
                            if ($product['oldPrice'] != 0) {
                        ?>
                        <span class="old-price"><?php echo convertPrice($product['oldPrice']); ?></span>
                        <span class="current-price"><?php echo convertPrice($product['currentPrice']); ?></span>
                        <?php
                            } else {
                        ?>
                        <span class="current-price"><?php echo convertPrice($product['currentPrice']); ?></span>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>

            <?php
                }
            ?>
        </div>
    </div>

    <!-- jquery -->
    <script src=" https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
    </script>

    <!-- dropdown js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- slick js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
        integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- custom js -->
    <script src="./js/navbar.js"></script>
    <script src="./js/detail.js"></script>
    <script src="./js/cart.js"></script>
</body>

</html>