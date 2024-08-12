<?php
    require_once __DIR__ . "/database/database.php";
    require_once __DIR__ . "/database/bill.php";
    require_once __DIR__ . "/database/evaluation.php";
    require_once __DIR__ . "/handle.php";

    $db = new database();
    $bill = new bill($db);
    $evaluation = new evaluation($db);

    if (isset ($_POST['updateRate'])) {
        $idBill = $_POST['idBill'];
        $idProduct = $_POST['idProduct'];
        $content = $_POST['comment'];
        $star = $_POST['star'];

        $evaluation->insert($idProduct, $idBill, $content, $star);

        $countBill = $bill->selectDetailBill($idBill)->num_rows;
        $countRate = $evaluation->selectByIdBill($idBill)->num_rows;

        if ($countBill == $countRate) {
            $bill->updateStatus($idBill, 5);
            echo "success";
        }

        exit ();
    }

    if (isset ($_POST['updateStatus'])) {
        $idBill = $_POST['idBill'];
        $status = $_POST['status'];
        echo $bill->updateStatus($idBill, $status);
        exit ();
    }

    $billDetail = $bill->selectDetailBill($_GET['idBill']);
    $billCurrent = $bill->getInfoBill($_GET['idBill']);
    $statusBill = $billCurrent['statusBill'];
    $billRated = $evaluation->selectByIdBill($_GET['idBill']);
    $percent = 25 * ($statusBill - 1);
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
    <link rel="stylesheet" href="css/billDetail.css">

</head>

<body>

    <style>
    :root {
        --progress-percent: <?php echo $percent;
        ?>%;
    }
    </style>

    <div class="container border">
        <div class="title d-flex justify-content-center align-items-center mb-3">
            <h1 class="text-danger text-capitalize">Thông tin đơn hàng</h1>
        </div>

        <!-- progress bar -->
        <div class="progress-bar px-5">
            <?php
                require_once __DIR__ . "/gui/progressBar.php";
            ?>
        </div>

        <!-- button receive order/ rating -->
        <?php
            if ($statusBill == 3) {
        ?>

        <div class="button-order d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-primary" data-status="4">Đã nhận đơn hàng</button>
        </div>

        <?php
            }
        ?>

        <!-- shipping info -->
        <div class="letter-line-top mt-5"></div>

        <div class="shipping-info p-3 row">
            <div class="receiver col-lg-6 col-md-12 col-sm-12 mb-3">
                <h5 class="text-primary fs-3">Người nhận: <span
                        class="text-capitalize text-black mx-2"><?php echo $billCurrent['receiver']; ?></span>
                </h5>
            </div>

            <div class="phone-number col-lg-6 col-md-12 col-sm-12 mb-3">
                <h5 class="text-primary fs-3">Số điện thoại: <span
                        class="text-capitalize text-black mx-2"><?php echo $billCurrent['phoneNumber']; ?></span></h5>
            </div>

            <div class="address col-12 mb-3">
                <h5 class="text-primary fs-3">Địa chỉ: <span
                        class="text-capitalize text-black mx-2"><?php echo $billCurrent['shippingAddress']; ?></span>
                </h5>
            </div>

            <div class="total col-lg-6 col-md-12 col-sm-12 mb-3">
                <h5 class="text-primary fs-3">Tổng tiền: <span
                        class="text-capitalize text-black mx-2"><?php echo convertPrice($billCurrent['totalBill']); ?></span>
                </h5>
            </div>

            <div class="payment-method col-lg-6 col-md-12 col-sm-12">
                <h5 class="text-primary fs-3">Phương thức thanh toán: <span
                        class="text-capitalize text-black mx-2"><?php echo $billCurrent['paymentMethod']; ?></span></h5>
            </div>

        </div>

        <div class="letter-line-bottom mb-3"></div>

        <div class="bill-detail mt-5">
            <h5 class="text-danger fs-1 text-center text-capitalize mb-3">Chi tiết đơn hàng</h5>

            <?php
                foreach ($billDetail as $key => $value) {
            ?>
            <div class="bill-item row px-5 py-2 d-flex justify-content-center align-items-center">
                <div class="bill-img col-lg-2 col-md-4 col-sm-4">
                    <img src="<?php echo $value['image']; ?>" alt="" class="img-fluid">
                </div>

                <div class="bill-info col-lg-10 col-md-8 col-sm-8 py-2">
                    <div class="name mb-3">
                        <h5 class="fs-3 font-bold"><?php echo $value['productName']; ?></h5>
                    </div>
                    <div class="size mb-3">
                        <span class="fs-5">Size: <?php echo $value['size']; ?></span>
                    </div>
                    <div class="quantity mb-3">
                        <span class="fs-5">Số lượng: <?php echo $value['quantity']; ?></span>
                    </div>
                    <div class="price">
                        <span class="fs-5">Giá: <?php echo convertPrice($value['total']); ?></span>
                    </div>
                </div>

                <?php
                    if ($statusBill >= 4) {
                ?>

                <div class="bill-button col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end mb-3">
                    <?php
                        $check = false;
                        foreach ($billRated as $key => $rated) {
                            if ($rated['idProduct'] == $value['idProduct']) {
                                $check = true;
                    ?>
                    <button type="button" class="btn btn-success btn-lg" disabled data-bs-toggle="modal"
                        data-bs-target="#rating" data-id-product="<?php echo $value['idProduct']; ?>">Đã đánh
                        giá</button>

                    <?php
                            }
                        }

                        if ($check == false) {
                    ?>

                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#rating"
                        data-id-product="<?php echo $value['idProduct']; ?>">Đánh giá</button>

                    <?php
                        }
                    ?>
                </div>

                <?php
                    }
                ?>

            </div>

            <?php
                }
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="rating" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

            </div>
        </div>

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <!-- bootstrap js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- custom js -->
        <script src="./js/billDetail.js"></script>
</body>

</html>