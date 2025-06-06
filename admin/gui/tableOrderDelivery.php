<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/bill.php";
    require_once __DIR__ . "\\..\\..\\database\\role.php";
    require_once __DIR__ . "\\..\\..\\handle.php";

    $db = new database();
    $bill = new bill($db);
    $role = new role($db);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset ($_POST['deliver-bill'])) {
        $idBill = $_POST['id'];
        echo $bill->updateStatus($idBill, 3);
        exit ();
    }

    if (isset ($_POST['get-count'])) {
        $sql = "SELECT * FROM BILLS
        WHERE STATUSBILL = 2";
        $bills = $bill->selectByCondition($sql);
        echo $bills->num_rows;
        exit ();
    }

    $page = (int) isset($_POST['page']) ? $_POST['page'] : 1;
    $itemOfPage = (int) isset($_POST['itemOfPage']) ? $_POST['itemOfPage'] : 10;

    $sql = "SELECT * FROM BILLS
    WHERE STATUSBILL = 2
    OR STATUSBILL = 3
    ORDER BY statusBill asc
    LIMIT " . ($page - 1) * $itemOfPage . ", " . $itemOfPage;
    $bills = $bill->selectByCondition($sql);

    $tasks = $role->selectTaskById($_SESSION['account_login']['idRole'], 4);
    $countTask = $tasks->num_rows;
?>

<div class="table-responsive bill">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Người nhận</th>
                <th>Số điện thoại</th>
                <th style="width: 25%;">Địa chỉ</th>
                <th>Tổng hóa đơn</th>
                <th>Giao hàng</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($bills->num_rows > 0) {
                    while ($b = $bills->fetch_assoc()) {
            ?>
            <tr>
                <td>
                    <?= $b['receiver'] ?>
                </td>
                <td>
                    <?= $b['phoneNumber'] ?>
                </td>
                <td>
                    <?= $b['shippingAddress'] ?>
                </td>
                <td>
                    <?= convertPrice ($b['totalBill']) ?>
                </td>
                <td>
                    <?php
                        if ($b['statusBill'] == 2) {
                            $check = false;
                            foreach ($tasks as $task) {
                                if ($task['idTask'] == 3) {
                                    $check = true;
                    ?>

                    <button class="btn btn-primary deliver-order" data-id="<?= $b['idBill']; ?>">Giao hàng</button>

                    <?php
                                }
                            }
                            if (!$check) {
                    ?>
                    <button class="btn" disabled style="background: orange; border: none; ">Giao hàng</button>

                    <?php
                            }
                    ?>

                    <?php
                        }
                        else {
                    ?>
                    <button class="btn" disabled style="background: orange; border: none; ">Đang giao hàng</button>

                    <?php
                        }
                    ?>
                </td>
                <td>
                    <div class="action">
                        <?php
                            foreach ($tasks as $task) {
                                if ($task['idTask'] == 2) {
                        ?>
                        <i class="fas fa-trash"></i>
                        <?php
                                }
                            }
                            if ($countTask > 0) {
                        ?>
                        <i class="fas fa-eye show-bill" data-bs-toggle="modal" data-bs-target="#show-bill"
                            data-id="<?= $b['idBill']; ?>"></i>
                        <?php
                            }
                        ?>
                    </div>
                </td>
            </tr>

            <?php
                    }
                }
                else {
            ?>

            <tr>
                <td colspan="6">
                    Không có đơn hàng cần giao
                </td>
            </tr>

            <?php
                }
            ?>

        </tbody>
    </table>
</div>