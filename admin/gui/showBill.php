<?php
    if (isset($_POST['id'])) {
        require_once __DIR__ . "/../../database/database.php";
        require_once __DIR__ . "/../../database/bill.php";
        require_once __DIR__ . "/../../handle.php";

        $db = new database();
        $bill = new bill($db);

        $id = $_POST['id'];
        $infoBill = $bill->getInfoBill($id);
        $detailBill = $bill->selectBillShow($id);
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thông tin đơn hàng</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body container-fluid row" style="margin: auto;">
        <div class="info col-12 row">
            <div class="receiver col-6 mb-3">
                <h5 class="text-danger">Người nhận:
                    <span class="text-capitalize text-black">
                        <?php echo $infoBill['receiver']; ?>
                    </span>
                </h5>
            </div>
            <div class="phoneNumber col-6 mb-3">
                <h5 class="text-danger">Số điện thoại:
                    <span class="text-capitalize text-black">
                        <?php echo $infoBill['phoneNumber']; ?>
                    </span>
                </h5>
            </div>
            <div class="totalBill col-6 mb-3">
                <h5 class="text-danger">Tổng hóa đơn:
                    <span class="text-capitalize text-black">
                        <?php echo convertPrice($infoBill['totalBill']); ?>
                    </span>
                </h5>
            </div>
            <div class="order-time col-12 mb-3">
                <h5 class="text-danger">Thời gian đơn:
                    <span class="text-black">
                        <?php echo convertTime($infoBill['orderTime']) . ", ngày " . convertDate($infoBill['orderTime']); ?>
                    </span>
                </h5>
            </div>
            <div class="shippingAddress col-12 mb-3">
                <h5 class="text-danger">Địa chỉ:
                    <span class="text-black">
                        <?php echo $infoBill['shippingAddress']; ?>
                    </span>
                </h5>
            </div>
            <div class="payment-method col-12 mb-3">
                <h5 class="text-danger">Phương thức thanh toán:
                    <span class="text-capitalize text-black">Thanh toán khi nhận hàng</span>
                </h5>
            </div>
        </div>

        <div class="list-product col-12" style="border-top: 1px solid black;">
            <h3 class="text-center text-uppercase mt-3 mb-3">Danh sách sản phẩm:</h3>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th style="width: 30%;">Tên sản phẩm</th>
                        <th style="width: 15%;">Giá</th>
                        <th style="width: 10%;">Size</th>
                        <th style="width: 10%;">Số lượng</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($detailBill as $d) {
                    ?>
                    <tr>
                        <td>
                            <?php
                                $img = "." . $d['image'];
                            ?>
                            <img src="<?= $img ?>" alt="" class="img-fluid" width="100">
                        </td>
                        <td>
                            <?= $d['productName'] ?>
                        </td>
                        <td>
                            <?= convertPrice($d['currentPrice']) ?>
                        </td>
                        <td>
                            <?= $d['size'] ?>
                        </td>
                        <td>
                            <?= $d['quantity'] ?>
                        </td>
                        <td>
                            <?= convertPrice($d['total']) ?>
                        </td>
                    </tr>

                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>