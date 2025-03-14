<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/brand.php";

    $db = new database();

    if (isset($_POST['add-coupon'])) {
        require_once __DIR__ . "/../../database/coupon.php";
        $code = $_POST['name'];
        $discount_percent = $_POST['percent'];
        $start_date = $_POST['start-date'];
        $end_date = $_POST['end-date'];

        $coupon = new coupon($db);
        echo $coupon->insertCoupon($code, $discount_percent, $start_date, $end_date);
        exit();
    }

?>

<div class="add-coupon container">
    <div class="title">
        <h1>Thêm mã giảm giá</h1>
    </div>

    <div class="content">
        <form action="" method="post" class="row" id="formAddCoupon" enctype="multipart/form-data">

            <div class="form-floating mb-3 col-6">
                <input type="text" class="form-control" id="coupon-name" placeholder="Tên mã">
                <label for="coupon-name">Tên mã</label>
            </div>

            <div class="form-floating col-6 mb-3">
                <input type="text" class="form-control" id="percent-discount" placeholder="Giảm giá">
                <label for="percent-discount">Giảm giá</label>
            </div>

            <div class="form-floating col-6 mb-3">
                <input type="datetime-local" class="form-control" id="start-date" placeholder="Ngày bắt đầu" required>
                <label for="start-date">Ngày bắt đầu</label>
            </div>

            <div class="form-floating col-6 mb-3">
                <input type="datetime-local" class="form-control" id="end-date" placeholder="Ngày kết thúc" required>
                <label for="end-date">Ngày kết thúc</label>
            </div>
            
            <div class="form-group mt-3 d-flex justify-content-center align-items-center col-12">
                <button class="btn btn-primary" id="save-coupon">Lưu</button>
            </div>

        </form>
    </div>
</div>