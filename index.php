<?php
    require_once "./database/database.php";
    require_once "./database/product.php";
    require_once "./handle.php";

    $db = new Database();
    $products = new product($db);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        if (isset($_SESSION["account_login"])) {
            if (isset($_SESSION["account_login"]["idRole"]) && $_SESSION["account_login"]["idRole"] != 1) {
                session_destroy();
            }
        }
    }

    if(isset($_GET["code"]))
    {
        require_once "./gui/googleLogin.php";
        require_once "./database/user.php";
        $user = new user($db);
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
        
        if(!isset($token["error"]))
        {
            $google_client->setAccessToken($token['access_token']);

            $_SESSION['access_token']=$token['access_token'];

            $google_service = new Google_Service_Oauth2($google_client);

            $data = $google_service->userinfo->get();

            $fullname = $data['name'];
            $email = $data['email'];
            $avatar = $data['picture'];
            $check = $user->loginWithEmail($email, $fullname, $avatar);
            // echo print_r($check);
            // exit ();
            if ($check == "") {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            if ($check == 'admin') {
                header ("location: " . 'http://localhost/webBanGiay/admin/');
            }
            else
                echo "<script>alert('$check');</script>";
        }
    }
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
    <link rel="stylesheet" href="./css/main.css">

</head>

<body>

    <!-- navbar -->
    <div class="container-fluid">
        <?php
            require_once "./database/brand.php";
            include "./gui/navbar.php";
        ?>
    </div>

    <!-- content -->
    <div class="container-fluid">

        <!-- slide banner -->
        <div class="slide-image">
            <div class="slide-item"><img src="./image/slide/1.png" alt="" loading="lazy" class="img-fluid"></div>
            <div class="slide-item"><img src="./image/slide/2.png" alt="" loading="lazy" class="img-fluid"></div>
            <div class="slide-item"><img src="./image/slide/3.png" alt="" loading="lazy" class="img-fluid"></div>
            <div class="slide-item"><img src="./image/slide/4.png" alt="" loading="lazy" class="img-fluid"></div>
        </div>

        <!-- buyer benefit -->
        <div class="row buyer-benefit">
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="circle">
                    <img src="./image/benefits/1.jpg" alt="">
                </div>
                <span class="text">Đổi mẫu, đổi size miễn phí</span>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="circle">
                    <img src="./image/benefits/2.jpg" alt="">
                </div>
                <span class="text">Mua trước, trả sau miễn lãi</span>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="circle">
                    <img src="./image/benefits/3.jpg" alt="">
                </div>
                <span class="text">Giao hàng, đổi trả tận nhà</span>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="circle">
                    <img src="./image/benefits/4.jpg" alt="">
                </div>
                <span class="text">Hàng giả, đền tiền gấp đôi</span>
            </div>
        </div>

        <!-- product new -->
        <div class="product-new">
            <div class="title">
                <h1>Sản phẩm mới</h1>
            </div>
            <div class="products">
                <?php
                    $result = $products->selectProductNew ();
                    while ($row = $result->fetch_assoc()) {
                ?>

                <div class="product">
                    <div class="product-item">
                        <div class="product-top">
                            <a href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>"
                                class="product-image">
                                <img src="<?php echo $row['image']; ?>" loading="lazy" alt="" class="img-fluid">
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
                </div>

                <?php
                    }
                ?>
            </div>
        </div>

        <!-- best seller -->
        <div class="best-seller">
            <div class="title">
                <h1>Sản phẩm bán chạy</h1>
            </div>
            <div class="products">
                <?php
                    $result = $products->selectProductBestSeller ();
                    while ($row = $result->fetch_assoc()) {
                ?>
                <div class="product">
                    <div class="product-item">
                        <div class="product-top">
                            <a href="./detailProduct.php?idProduct=<?php echo $row['idProduct']; ?>"
                                class="product-image">
                                <img src="<?php echo $row['image']; ?>" loading="lazy" alt="" class="img-fluid">
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
                </div>

                <?php
                    }
                ?>
            </div>
        </div>

        <!-- feature brands -->
        <div class="feature-brands row">
            <div class="title col-sm-12 col-md-12 col-lg-12">
                <h1>Thương hiệu nổi bật</h1>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 row">
                <?php
                    $result = $brands->selectAll();
                    while ($row = $result->fetch_assoc()) {
                ?>

                <a href="./products.php?idBrand=<?php echo $row['idBrand']; ?>" class="col-lg-3 col-md-3 col-sm-4"><img
                        class="img-fluid" loading="lazy" src="<?php echo $row['imageLogo']; ?>" alt=""></a>
                <?php
                    }
                ?>
            </div>
        </div>

        <!-- news -->
        <div class="news">
            <div class="title">
                <h1>Báo chí nói về chúng tôi</h1>
            </div>

            <div class="news-content">
                <a
                    href="https://kenh14.vn/giay-hieu-mua-truoc-tra-sau-don-gian-khong-mat-phi-tai-sneaker-daily-20220328174058416.chn"><img
                        src="./image/logo/kenh14.webp" alt="" class="img-fluid"></a>
                <a
                    href="https://www.24h.com.vn/the-gioi-thoi-trang/giay-hieu-mua-truoc-tra-sau-don-gian-khong-mat-phi-tai-sneaker-daily-c672a1343794.html?gidzl=X7GMITGjaNI2RX9FqJkKT8DW7q_AQPKacZT26yfZoI6QFHeSpZF9T91kIqoLDPXobZfE6Z5dRR8DqY2HTG"><img
                        src="./image/logo/24h.webp" alt="" class="img-fluid"></a>
                <a
                    href="https://top247.vn/sneaker-daily-thien-duong-chinh-hang-danh-cho-cac-tin-do-thoi-trang-the-thao/?fbclid=IwAR0G4Nr8oBcONkXQWXEk3EfBdue1bGUE5SLIl_mLr2Dcc8jW9JwM8bHaYjI"><img
                        src="./image/logo/top247vn.webp" alt="" class="img-fluid"></a>
                <a href="https://tinnhiemmang.vn/cong-bo-sneaker-daily-da-dat-chung-nhan-website-tin-nhiem-mang-co-ban"><img
                        src="./image/logo/ncscvn.webp" alt="" class="img-fluid"></a>
                <a
                    href="https://meeyland.com/tin-tuc/sneaker-daily-hanh-trinh-tu-nhung-ngay-dau-kho-khan-den-dai-ly-phan-phoi-chinh-thuc-cua-nike-tao-nen-thanh-tuu-chi-sau-4-thang-khoi-su-159376172689"><img
                        src="./image/logo/meeyland.jpg" alt="" class="img-fluid"></a>
                <a
                    href="https://giadinhmoi.vn/sneaker-daily--thien-duong-chinh-hang-danh-cho-cac-tin-do-thoi-trang-the-thao-d56787.html"><img
                        src="./image/logo/giadinhmoi.webp" alt="" class="img-fluid"></a>
                <a
                    href="https://hanoimoi.vn/sneaker-daily-thien-duong-chinh-hang-danh-cho-cac-tin-do-thoi-trang-the-thao-483957.html"><img
                        src="./image/logo/hanoimoi.webp" alt="" class="img-fluid"></a>
                <a
                    href="https://ttvn.toquoc.vn/giay-hieu-mua-truoc-tra-sau-don-gian-khong-mat-phi-tai-sneaker-daily-2202228317433447.htm"><img
                        src="./image/logo/toquoc.webp" alt="" class="img-fluid"></a>
                <a
                    href="https://danviet.vn/giay-hieu-mua-truoc-tra-sau-don-gian-khong-mat-phi-tai-sneaker-daily-50202228315561500.htm"><img
                        src="./image/logo/danviet.webp" alt="" class="img-fluid"></a>
                <a href="https://cafebiz.vn/sprayground-co-gi-doc-la-ma-lai-thu-hut-nhu-the-176220825153632704.chn"><img
                        src="./image/logo/cafebiz.webp" alt="" class="img-fluid"></a>
            </div>

        </div>

    </div>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- slick js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
        integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- dropdown js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="./js/navbar.js"></script>
    <script src="./js/slideShow.js"></script>
    <script src="./js/cart.js"></script>
</body>

</html>