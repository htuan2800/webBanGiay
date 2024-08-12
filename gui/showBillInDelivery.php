<?php
    require_once __DIR__ . '/../database/database.php';
    require_once __DIR__ . '/../database/bill.php';
    require_once __DIR__ . '/../handle.php';

    $db = new Database();
    $bill = new bill($db);

    if (isset ($_POST['receive-bill'])) {
        $idBill = $_POST['id'];
        echo $bill->updateStatus($idBill, 4);
        exit ();
    }

    $bills = $bill->selectBillByIdUser(3);
?>

<?php
    if ($bills->num_rows == 0) {
?>
<h1 class="text-center text-capitalize text-danger mt-5">Không có đơn hàng đang giao</h1>
<?php
        exit ();
    }
?>

<?php
    foreach ($bills as $key => $value) {
?>
<div class="bill-item row">
    <?php
                $detail = $bill->selectDetailBill($value['idBill']);

                foreach ($detail as $key => $value) {
            ?>
    <div class="bill-image col-lg-2 col-md-2 col-sm-2">
        <img src="<?php echo $value['image']; ?>" alt="" class="img-fluid">
    </div>

    <div class="bill-info col-lg-10 col-md-10 col-sm-10">
        <h4><?php echo $value['productName']; ?></h4>
        <span>Số lượng: <?php echo $value['quantity']; ?></span>
        <span>
            <h5>Giá:</h5> <?php echo convertPrice($value['total']); ?>
        </span>
    </div>

    <?php
                }
            ?>

    <div class="bill-button-receive col-lg-12 col-md-12 col-sm-12">
        <span>
            <h5>Thành tiền:</h5> <?php echo convertPrice($value['totalBill']); ?>
        </span>
        <div class="btn-group">
            <a style="text-decoration: none; color: white;"
                href="billDetail.php?idBill=<?php echo $value['idBill']; ?>"><button>Xem đơn hàng</button></a>

            <button class="receive-bill" data-id="<?php echo $value['idBill']; ?>" style="background-color: #0984e3;
            margin-left: 15px;">Đã nhận được
                hàng</button>
        </div>
    </div>

</div>
<?php
    }
?>