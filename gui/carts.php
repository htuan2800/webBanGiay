<?php

    function customErrorHandler($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    }

    set_error_handler("customErrorHandler");

    try {
        include_once "./database/database.php";
        include_once "./database/cart.php";
        include_once "./handle.php";
    } catch (ErrorException $e) {
        try {
            include_once "../database/database.php";
            include_once "../database/cart.php";
            include_once "../handle.php";
        } catch (ErrorException $e) {
            echo "Failed to include autoload file: " . $e->getMessage() . "\n";
        }
    }
    restore_error_handler();
    
    $db = new database();
    $cart = new cart($db);

    // add cart
    if (isset($_POST['add-cart'])) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['account_login'])) {
            echo "fail";
            exit();
        }
        $idProduct = $_POST['idProduct'];
        $size = $_POST['size'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $cart->insertCart($idProduct, $size, $quantity, $price);
    }

    // delete cart
    if (isset($_POST['delete-product-cart'])) {
        $idProduct = $_POST['idProduct'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $cart->deleteProductCart($idProduct, $quantity, $price);
        exit ();
    }

    // update quantity cart
    if (isset($_POST['update-product-cart'])) {
        $idProduct = $_POST['idProduct'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $cart->updateQuantityProductToCartDetail($idProduct, $quantity, $price);
    }

    $result = $cart->selectCartDetailById($_SESSION['account_login']['idUser']);
?>

<div class="products">
    <?php
        if ($result->num_rows == 0) {
    ?>
    <style>
    .offcanvas {
        .products {
            overflow: hidden !important;
            display: flex;
            align-items: center;
            justify-content: center;

            .empty-cart {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;

                div {
                    margin-bottom: 30px;

                    &.image {
                        background-color: #f5f5f5;
                        border-radius: 50%;
                        width: 100px;
                        height: 100px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    &.text {
                        font-size: 20px;
                        color: #333;
                    }
                }

                button {
                    padding: 10px 20px;
                    border: none;
                    background-color: #333;
                    color: #fff;
                    cursor: pointer;

                    &:hover {
                        opacity: 0.8;
                    }
                }
            }
        }
    }
    </style>
    <div class="empty-cart">
        <div class="image">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-shopping-bag">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
        </div>
        <div class="text">
            Chưa có sản phẩm nào trong giỏ hàng
        </div>
        <button class="btn-continue-shopping">Tiếp tục mua sắm</button>
    </div>
    <?php
        }
        else {
    ?>
    <?php
        while ($row = $result->fetch_assoc()) {
    ?>
    <div class="product-item row">
        <div class="product-image col-lg-3 col-md-2 col-sm-2">
            <input type="checkbox" name="" class="form-check-input">
            <img src="<?php echo $row['image']; ?>" alt="" class="img-fluid">
        </div>

        <div class="product-info col-lg-9 col-md-10 col-sm-10 row">
            <div class="product-name col-lg-12 col-md-12 col-sm-12">
                <span><?php echo $row['productName']; ?></span>
                <i class="fa-solid fa-xmark" data-id-product="<?php echo $row['idProduct']; ?>"></i>
            </div>
            <div class="product-size col-lg-12 col-md-12 col-sm-12">
                <span>Size: <?php echo $row['size']; ?></span>
            </div>
            <div class="quantity col-lg-6 col-md-6 col-sm-6">
                <button>-</button>
                <input type="text" value="<?php echo $row['quantity']; ?>" inputmode="numeric"
                    max="<?php echo $row['quantityRemain']; ?>" readonly>
                <button>+</button>
            </div>
            <div class="product-price col-lg-6 col-md-6 col-sm-6">
                <span
                    data-price="<?php echo $row['currentPrice']; ?>"><?php echo convertPrice($row['currentPrice']); ?></span>
            </div>
        </div>
    </div>

    <?php
        }
    ?>
</div>

<div class="total row">
    <span class="label col-lg-6 col-md-6 col-sm-6">Tổng tiền: </span>
    <span class="value col-lg-6 col-md-6 col-sm-6">0đ</span>
    <button class="btn btn-primary">Thanh toán</button>
</div>

<?php
    }
?>