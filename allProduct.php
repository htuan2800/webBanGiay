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
    <div class="container-fluid mt-5 mx-auto">
        <div class="row mx-auto d-flex flex-row justify-content-center align-items-center">
            <!-- title -->
            <div class="w-100 text-center mb-5">
                <h1>All product</h1>
            </div>

            <!-- products -->
            <div class="products col-lg-9 col-md-12 col-sm-12 row">
                <div class="show-product col-lg-12 col-md-12 col-sm-12 row mx-auto">
                    <?php
                    require_once './database/ajaxAllProduct.php';
                    ?>
                </div>

                <div class="paging-all-product">
                    <?php
                        require_once ("./gui/allPaging.php")
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
    <script type="module" src="./js/allProduct.js"></script>

</html>