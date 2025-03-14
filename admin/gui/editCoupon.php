<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/coupon.php";
    require_once __DIR__ . "/../../database/brand.php";

    $db = new database();

    $coupon = new coupon($db);

    if (isset($_POST['editCoupon'])) {
        $id = $_POST['id'];
        $codename = $_POST['codename'];
        $percent = $_POST['percent'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        echo $coupon->updateCoupon($id, $codename, $percent, $start_date, $end_date);

        exit();
    }
    // show edit modal
    if (isset ($_POST['edit-coupon'])) {
        $id = $_POST['id'];
        $coupons = $coupon->selectCouponById($id);
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa sản phẩm</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <div class="container-fluid row">

            <div class="form-group col-12">
                <label for="coupon-name">Tên sản phẩm</label>
                <input type="text" name="coupon-name" id="coupon-name" class="form-control"
                    value="<?= $coupons['code'] ?>" />
            </div>

            <div class="form-group col-6">
                <label for="percent-discount">Tỉ lệ giảm giá</label>
                <input type="text" name="percent-discount" id="percent-discount" class="form-control"
                    value="<?= $coupons['discount_percent'] ?>" />
            </div>

            <div class="form-group col-6">
                <label for="start-date">Ngày bắt đầu</label>
                <input type="datetime-local" name="start-date" id="start-date" class="form-control"
                    value="<?= $coupons['start_date'] ?>" />
            </div>

            <div class="form-group col-6">
                <label for="end-date">Ngày kết thúc</label>
                <input type="datetime-local" name="end-date" id="end-date" class="form-control"
                    value="<?= $coupons['end_date'] ?>" />
            </div>
        </div>
    </div>

    <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" id="save-btn-coupon" data-id="<?php echo $coupons['id']; ?>">Lưu thay
        đổi</button>
    </div>
</div>