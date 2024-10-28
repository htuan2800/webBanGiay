<?php
require_once __DIR__ . '/database/database.php';

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

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- custom css -->
    <link rel="stylesheet" href="./css/products.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/filter.css">
</head>

<body>

    <!-- navbar -->
    <div class="container-fluid">
        <?php
        require_once './database/brand.php';
        include './gui/navbar.php';
        ?>
    </div>

    <!-- content -->
    <div class="container-fluid mt-5">
        <div class="title text-center">
            <?php
            if (isset($_GET['designType'])) {
                $designType = $_GET['designType'];
                echo "<h1>$designType</h1>";
            } else {
                if (isset($_GET['idBrand'])) {
                    $result = $brands->selectById($_GET['idBrand']);
                    echo '<h1>' . $result['brandName'] . '</h1>';
                }
            }
            ?>
        </div>

        <div class="row">

            <!-- filter -->
            <div class="filter col-lg-3 col-md-12 col-sm-12 row">
                <?php
                require_once './gui/filter.php';
                ?>
            </div>

            <!-- products -->
            <div class="products col-lg-9 col-md-12 col-sm-12 row">
                <div class="filter-nav col-lg-12 col-md-12 col-sm-12">
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-sliders">
                            <line x1="4" y1="21" x2="4" y2="14"></line>
                            <line x1="4" y1="10" x2="4" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12" y2="3"></line>
                            <line x1="20" y1="21" x2="20" y2="16"></line>
                            <line x1="20" y1="12" x2="20" y2="3"></line>
                            <line x1="1" y1="14" x2="7" y2="14"></line>
                            <line x1="9" y1="8" x2="15" y2="8"></line>
                            <line x1="17" y1="16" x2="23" y2="16"></line>
                        </svg>
                    </button>

                    <select name="" id="sort-product" class="form-select" aria-label="Default select example">
                        <option value="">Sắp xếp</option>
                        <option value="currentPrice ASC">Giá tăng dần</option>
                        <option value="currentPrice DESC">Giá giảm dần</option>
                        <option value="CREATEAT DESC">Mới nhất</option>
                        <option value="CREATEAT ASC">Cũ nhất</option>
                        <option value="QUANTITYSOLD DESC">Bán chạy</option>
                    </select>
                </div>

                <div class="show-product col-lg-12 col-md-12 col-sm-12 row">
                    <?php
                    require_once './database/ajaxProducts.php';
                    ?>
                </div>

                <div class="paging">
                    <?php
                        require_once ("./gui/paging.php")
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="./js/navbar.js"></script>
    <script src="./js/cart.js"></script>
    <script type="module" src="./js/products.js"></script>

</html>