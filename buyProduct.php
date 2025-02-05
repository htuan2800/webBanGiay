<?php
// include file database
require_once('./database/database.php');
require_once('./database/cart.php');
require_once('./database/product.php');
require_once('./handle.php');

$db = new database();
$cart = new cart($db);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// get products from url
if (isset($_GET['products'])) {

    $encoded_json = $_GET['products'];
    $decoded_json = urldecode(base64_decode($encoded_json));
    $products = json_decode($decoded_json, true);
    $result = $cart->selectProductToBuy($products, $_SESSION['account_login']['idUser']);
    // print_r($result->fetch_assoc());
}

// insert bill
if (isset($_POST['buy-product'])) {
    require_once('./database/bill.php');

    $cart = new cart($db);
    $bill = new bill($db);
    $product = new product($db);

    $encoded_json = $_POST['products'];
    $decoded_json = urldecode(base64_decode($encoded_json));
    $products = json_decode($decoded_json, true);
    $receiver = $_POST['receiver'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phone'];
    $total = $_POST['total'];
    $paymentMethod = $_POST['payment-method'];
    $result = $cart->selectProductToBuy($products, $_SESSION['account_login']['idUser']);
    $id = $bill->insertBill($_SESSION['account_login']['idUser'], $receiver, $address, $phoneNumber, $total, $paymentMethod, $products, $cart);
    if ($id) {
        foreach ($result as $value) {
            $product->updateQuantityProduct($value["idProduct"], $value["quantity"], $value["size"]);
        }
    }
    echo $id;
    print_r($products);
    exit();
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

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- custom css -->
    <link rel="stylesheet" href="./css/buyProduct.css">
</head>

<body>
    <div class="container-fluid row">
        <div class="col-lg-6 col-md-6 col-sm-6 show-product">

            <div class="products">
                <?php
                $total = 0;
                foreach ($result as $key => $value) {
                ?>
                    <div class="product-item row">
                        <div class="product-image col-lg-3 col-md-3 col-sm-3">
                            <img src="<?php echo $value['image']; ?>" alt="" class="img-fluid">
                        </div>
                        <div class="product-info col-lg-6 col-md-6 col-sm-6">
                            <div class="product-name">
                                <?php echo $value['productName']; ?>
                            </div>
                            <div class="product-size">
                                Size: <?php echo $value['size']; ?>
                            </div>
                            <div class="product-quantity">
                                Số lượng: <?php echo $value['quantity']; ?>
                            </div>
                        </div>
                        <div class="product-total col-lg-3 col-md-3 col-sm-3">
                            <?php echo convertPrice($value['totalProduct']); ?>
                        </div>
                    </div>
                <?php
                    $total += $value['totalProduct'];
                }
                ?>
            </div>

            <div class="total-price">
                <span>Tổng thanh toán: </span>
                <span class="price"><?php echo convertPrice($total); ?></span>
            </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 info-payment">
            <div class="logo col-lg-12 col-md-12 col-sm-12">
                <a href="./index.php"><img src="./image/logo/navbar-logo.png" alt="" loading="lazy"
                        class="img-fluid"></a>
            </div>
            <div class="title">
                Thông tin thanh toán
            </div>
            <div class="address-selected">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="address-option" id="inlineRadio1" value="1"
                        checked>
                    <label class="form-check-label" for="inlineRadio1">Giao hàng đến địa chỉ khác</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="address-option" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">Giao hàng đến địa chỉ sẵn có</label>
                </div>
            </div>

            <div class="info">
                <?php
                include_once "./gui/formAddress.php";
                ?>
            </div>

            <div class="btn-payment">
                <button type="submit" class="btn-buy-product">Thanh toán </button>
                <!-- <div class="online-payment row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <a href="" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip" data-bs-title="Thanh toán qua VNPAY">
                            <img src="./vnpay.jpg" alt="" class="img-fluid">
                        </a>

                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <a href="" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip" data-bs-title="Thanh toán qua MOMO">
                            <img src="./momo.webp" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <a href="" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip" data-bs-title="Thanh toán qua napas">
                            <img src="./napas.jpg" alt="" class="img-fluid">
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- dropdown js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- custom js -->
    <script src="./js/buyProduct.js"></script>
</body>

</html>