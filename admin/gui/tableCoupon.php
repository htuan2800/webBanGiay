<?php

require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/coupon.php";
require_once __DIR__ . "/../../database/role.php";
require_once __DIR__ . "\\..\\..\\handle.php";


$db = new database();

$coupon = new coupon($db);
$role = new role($db);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//check chuc nang xem sua va xoa
$tasks = $role->checkPermissionLook($_SESSION['account_login']['idRole'], 3);

$countTask = $tasks->num_rows;
$check = false;
$checkDeleteAndUpdate = false;
foreach ($tasks as $key => $value) {
    if ($value['idTask'] == 2 || $value['idTask'] == 3) {
        $checkDeleteAndUpdate = true;
    }
}
$tasks = $role->selectTaskById($_SESSION['account_login']['idRole'], 2);
$countTask = $tasks->num_rows;

if (isset($_POST['delete-coupon'])) {
    $id = $_POST['id'];
    $coupon->deleteCoupon($id);
    exit();
}

// $page = (int) isset($_POST['page']) ? $_POST['page'] : 1;
// $itemOfPage = (int) isset($_POST['itemOfPage']) ? $_POST['itemOfPage'] : 10;
$valueSearch = isset($_POST['valueSearch']) ? $_POST['valueSearch'] : "";

$sql = "SELECT * FROM coupon
    WHERE coupon.status = 1";

if ($valueSearch != "") {
    $sql .= " AND coupon.code LIKE '%$valueSearch%'";
}

// $sql .= " ORDER BY coupon.id DESC "; 

// $sql .= " LIMIT " . (($page - 1) * $itemOfPage) . ", " . $itemOfPage;

$coupons = $coupon->selectByCondition($sql);

?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Code</th>
                <th>Discount_Percent</th>
                <th>Start_Date</th>
                <th>End_Date</th>
                <?php
                if ($checkDeleteAndUpdate) {
                    ?>
                    <th>Chức năng</th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($coupons->num_rows < 0) {
                ?>

                <tr>
                    <td colspan="7">Không tìm thấy sản phẩm</td>
                </tr>


                <?php
            }
            foreach ($coupons as $coupon) {
                ?>
                <tr>
                    <td>
                        <?php echo $coupon['code'] ?>
                    </td>
                    <td>
                        <?php echo $coupon['discount_percent'] ?>
                    </td>
                    <td>
                        <?php echo $coupon['start_date'] ?>
                    </td>
                    <td>
                        <?php echo ($coupon['end_date']); ?>
                    </td>
                    <?php
                    if ($countTask > 0) {
                        ?>
                        <td>
                            <div class="action">
                                <?php
                                foreach ($tasks as $key => $value) {
                                    if ($value['idTask'] == 2) {
                                        ?>
                                        <i class="fa fa-trash" data-id="<?php echo $coupon['id'] ?>"></i>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($value['idTask'] == 3) {
                                        ?>
                                        <i class="fa fa-edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                            data-id="<?php echo $coupon['id'] ?>"></i>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </td>

                        <?php
                    }
                    ?>

                </tr>

                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- <div class="pagination">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link previous disabled" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>



        <li class="page-item">
            <a class="page-link next" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</div> -->