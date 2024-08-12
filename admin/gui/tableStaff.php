<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/user.php";
    require_once __DIR__ . "/../../database/role.php";

    $db = new database();
    $user = new user($db);
    $role = new role($db);

    if (session_status () == PHP_SESSION_NONE) {
        session_start();
    }

    $idCurrent = $_SESSION['account_login']['idUser'];

    if (isset ($_POST['get-staff-count'])) {
        $sql = "SELECT * FROM users
        WHERE STATUSREMOVE = 0
        AND IDROLE != 1
        AND IDUSER != $idCurrent";
        $result = $user->selectByCondition($sql);
        echo $result->num_rows;
        exit ();
    }

    // set status
    if (isset ($_POST['type'])) {
        $id = $_POST['id'];
        if ($_POST['type'] == "lock") {
            $user->blockUser($id);
        }
        else if ($_POST['type'] == "unlock") {
            $user->unblockUser($id);
        }
        exit ();
    }

    // set remove
    if (isset ($_POST['remove-staff'])) {
        $id = $_POST['id'];
        $user->deleteStaff($id);
        exit ();
    }

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $itemOfPage = isset($_POST['itemOfPage']) ? $_POST['itemOfPage'] : 10;

    $page = intval($page);
    $itemOfPage = intval($itemOfPage);

    $sql = "SELECT * FROM users
    WHERE STATUSREMOVE = 0
    AND IDROLE != 1
    AND IDUSER != $idCurrent
    ORDER BY IDUSER DESC
    LIMIT " . ($page - 1) * $itemOfPage . ", " . $itemOfPage . " ";

    $users = $user->selectByCondition($sql);
    $tasks = $role->selectTaskById($_SESSION['account_login']['idRole'], 2);
    $countTask = $tasks->num_rows;
    $check = false;
    if ($countTask > 1) {
        $check = true;
    }
?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Tình trạng</th>
                <?php
                    if ($countTask > 1) {
                ?>
                <th>Chức năng</th>
                <?php
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($users->num_rows == 0) {
                    echo "<tr><td colspan='6'>Không co dữ liệu</td></tr>";
                }
            ?>

            <?php
                while ($row = $users->fetch_assoc()) {
            ?>
            <tr>
                <td>
                    <?= $row['fullName']; ?>
                </td>
                <td>
                    <?= $row['phoneNumber'] ?? "Không có"; ?>
                </td>
                <td>
                    <?= $row['email'] ?? "Không có"; ?>
                </td>
                <td>
                    <?php
                        if (strncmp($row['avatar'],"https", 5) == 0) {
                            $avatar = $row['avatar'];
                        }
                        else {
                            $avatar = "./." . $row['avatar'] . "?" . time();
                        }
                    ?>
                    <img src="<?= $avatar; ?>" alt="Lỗi ảnh" class="img-fluid" width="100px" height="100px">
                </td>
                <td>
                    <div class="button-lock">
                        <?php
                            if ($row['status'] == 0) {
                                if ($check) {
                                    echo "<button class='btn btn-danger' data-id='" . $row['idUser'] . "'>Khóa hoạt động</button>";
                                }
                                else {
                                    echo "<button class='btn btn-danger disabled' data-id='" . $row['idUser'] . "'>Khóa hoạt động</button>";
                                }
                            }
                            else {
                                if ($check) {
                                    echo "<button class='btn btn-success' data-id='" . $row['idUser'] . "'>Được hoạt động</button>";
                                }
                                else {
                                    echo "<button class='btn btn-success disabled' data-id='" . $row['idUser'] . "'>Được hoạt động</button>";
                                }
                            }
                        ?>
                    </div>
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
                        <i class="fa fa-trash" data-id="<?= $row['idUser']; ?>"></i>
                        <?php
                                }
                        ?>
                        <?php
                                if ($value['idTask'] == 3) {
                        ?>
                        <i class="fa fa-edit" data-id="<?= $row['idUser']; ?>" data-bs-toggle="modal"
                            data-bs-target="#edit-staff"></i>
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

<!-- Modal -->
<div class="modal fade" id="edit-staff" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">

    </div>
</div>