<?php
    if (!function_exists('customErrorHandler')) {
        function customErrorHandler($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        }
    
        set_error_handler("customErrorHandler");
    }
    
    set_error_handler("customErrorHandler");
    
    try {
        include_once "./database/database.php";
        include_once "./database/bill.php";
        include_once "./handle.php";
    } catch (ErrorException $e) {
        try {
            include_once "../database/database.php";
            include_once "../database/bill.php";
            include_once "../handle.php";
        } catch (ErrorException $e) {
            echo "Failed to include autoload file: " . $e->getMessage() . "\n";
        }
    }
    restore_error_handler();

    $db = new Database();
    $bill = new bill($db);

    if (isset ($_POST['delete-bill'])) {
        $idBill = $_POST['id'];
        echo $bill->updateStatus($idBill, 0);
        exit ();
    }

    $bills = $bill->selectBillByIdUser(1);
?>

<?php
    if ($bills->num_rows == 0) {
?>
<h1 class="text-center text-capitalize text-danger mt-5">Không có đơn hàng được đặt</h1>
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

    <div class="bill-delete col-lg-12 col-md-12 col-sm-12">
        <span>
            <h5>Thành tiền:</h5> <?php echo convertPrice($value['totalBill']); ?>
        </span>
        <button data-id="<?php echo $value['idBill']; ?>">Hủy đơn hàng</button>
    </div>

</div>
<?php
    }
?>