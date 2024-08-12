<?php
    require_once "./database/database.php";
    require_once "./database/brand.php";
    $db = new Database();
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

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css -->
    <link rel="stylesheet" href="./css/navbar.css">
    <link rel="stylesheet" href="./css/userInfo.css">
    <link rel="stylesheet" href="./css/loading.css">
</head>

<body>
    <div class="loading">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="container-fluid">
        <?php
            include "./gui/navbar.php";
        ?>
    </div>

    <div class="container-fluid user-info row">
        <div class="function col-lg-3 col-md-3">
            <div>
                <a class="load-link selected" href="./gui/userInfo.php">Thông tin người dùng</a>
                <a class="load-link" href="./gui/addressInfo.php">Địa chỉ đặt hàng</a>
                <a class="load-link" href="./gui/infoBillUser.php">Thông tin đơn hàng</a>
                <a class="load-link" href="">Thống kê mua hàng</a>
                <a href="./logout.php" id="logout" style="color: red">đăng xuất</a>
            </div>
        </div>

        <div class="info col-lg-9 col-md-9 col-sm-12 row">
            <?php
                require_once "./gui/userInfo.php";
            ?>
        </div>
    </div>

    <!-- axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- dropdown js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- custom js -->
    <script src="./js/navbar.js"></script>
    <script src="./js/cart.js"></script>
    <script src="./js/userInfo.js"></script>
    <script src="./js/bill.js"></script>
</body>

</html>