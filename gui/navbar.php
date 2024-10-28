<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        // session_destroy();
    }
?>

<!-- dialog login -->
<div class="modal fade" id="modalId" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId"
    aria-hidden="true">

</div>

<div class="fake-navbar"></div>

<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <!-- logo -->
        <a class="navbar-brand" href="./index.php">
            <img src="./image/logo/navbar-logo.png" alt="" class="d-inline-block align-text-top">
        </a>

        <!-- toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- create database and table brand -->
                <?php
                        
                        $db = new database();
                        $brands = new brand($db);

                        $result = $brands->selectAll();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>

                <!-- check dropdown menu -->
                <li class="nav-item <?php
                        $countSubBrand = $brands->countSubBrand($row['idBrand']);
                        if ($countSubBrand > 0) {
                            echo "dropdown";
                        }
                    ?>">
                    <!-- check dropdown menu -->
                    <a class="nav-link" href="products.php?idBrand=<?php echo $row['idBrand']; ?>" aria-expanded="false"
                        role="button" <?php
                                if ($countSubBrand > 0) {
                                    echo 'id="navbarDropdown" data-bs-toggle="dropdown"';
                                }
                            ?>>
                        <?php echo $row['brandName']; ?>

                        <!-- check dropdown menu -->
                        <?php if ($countSubBrand > 0) { ?>
                        <i><i class="fa-solid fa-angle-down icon-down"></i></i>
                        <?php } ?>
                    </a>
                    <?php if ($countSubBrand > 0) { ?>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                                $subBrands = $brands->selectSubBrandById($row['idBrand']);
                                foreach ($subBrands as $subBrand) {
                                ?>
                        <li><a class="dropdown-item"
                                href="products.php?idBrand=<?php echo $row['idBrand']; ?>&designType=<?php echo $subBrand['subBrandName']; ?>"><?php echo $subBrand['subBrandName']; ?></a>
                        </li>
                        <?php } ?>
                    </ul>

                    <?php } ?>
                </li>
                <?php
                            }
                        }

                    ?>

            </ul>

            <div class="d-flex function-nav">
                <!-- search -->
                <div class="function-group">
                    <span class="search-label">Tìm kiếm</span>
                    <i><i class="fa-solid fa-magnifying-glass" id="search"></i></i>
                </div>

                <!-- cart -->
                <div class="function-group">
                    <span class="cart-label">Giỏ hàng</span>
                    <?php
                        if (isset($_SESSION['account_login'])) {
                            require_once './database/cart.php';
                            $cart = new cart($db);
                            $result = $cart->selectById($_SESSION['account_login']['idUser']);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {        
                        ?>
                    <i><i class="fa-solid fa-cart-shopping" id="cart"
                            title="<?php echo "Số lượng sản phẩm trong giỏ: " . $row['quantityProduct']; ?>"
                            type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                            aria-controls="offcanvasRight"></i></i>
                    <?php
                        }
                    ?>
                    <?php
                        }
                    }
                    else {
                    ?>
                    <i><i class="fa-solid fa-cart-shopping" id="cart"></i></i>
                    <?php
                    }
                    ?>
                </div>

                <!-- login -->
                <div class="function-group">
                    <?php                        
                        if (isset($_SESSION['account_login'])) {
                            ?>
                    <span class="login-label">Tài khoản</span>
                    <a href="./userInfo.php"><img src="<?php echo $_SESSION['account_login']['avatar']; ?>" alt=""
                            class="img-fluid img-avatar"></a>
                    <?php
                        }
                        else {
                            ?>
                    <span class="login-label">Đăng nhập</span>
                    <i><i class="fa-solid fa-user" id="login"></i></i>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- cart detail -->
<?php
    if (isset ($_SESSION['account_login'])) {
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Giỏ hàng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php
            require_once "./gui/carts.php";
        ?>
    </div>
</div>

<?php
    }
?>