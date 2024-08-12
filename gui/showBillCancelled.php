<?php
    require_once __DIR__ . '/../database/database.php';
    require_once __DIR__ . '/../database/bill.php';
    require_once __DIR__ . '/../handle.php';

    $db = new Database();
    $bill = new bill($db);

    if (isset ($_POST['delete-bill'])) {
        $idBill = $_POST['id'];
        echo $bill->updateStatus($idBill, 0);
        exit ();
    }

    $bills = $bill->selectBillByIdUser(0);
?>

<?php
    if ($bills->num_rows == 0) {
?>
<h1 class="text-center text-capitalize text-danger mt-5">Không có đơn hàng hủy</h1>
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

</div>
<?php
    }
?>