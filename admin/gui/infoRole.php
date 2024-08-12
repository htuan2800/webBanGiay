<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/role.php";
    require_once __DIR__ . "/../../handle.php";

    $db = new database();
    $role = new role($db);

    if (isset ($_POST['delete-role'])) {
        $id = $_POST['id'];
        $role->deleteRole($id);
        echo "success";
        exit ();
    }

    $result = $role->selectAll();
?>

<div class="table-responsive info-role">
    <div class="title mb-3">
        <h3>Quản lý vai trò</h3>
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Vai trò</th>
                <th>Ngày tạo</th>
                <th>Ngày chỉnh sửa</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>

            <?php
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    if ($i < 2) {
                        $i++;
                        continue;
                    }
            ?>

            <tr>
                <td>
                    <?= $row['roleName']; ?>
                </td>
                <td>
                    <?= convertDate($row['createAt']); ?>
                </td>
                <td>
                    <?= convertDate($row['updateAt']); ?>
                </td>
                <td>
                    <div class="action">
                        <i class="fa fa-trash" data-id="<?= $row['idRole']; ?>"></i>
                        <i class="fa fa-edit" data-id="<?= $row['idRole']; ?>" data-bs-toggle="modal"
                            data-bs-target="#modal-role"></i>
                        <i class="fa fa-eye" data-id="<?= $row['idRole']; ?>" data-bs-toggle="modal"
                            data-bs-target="#modal-role"></i>
                    </div>
                </td>
            </tr>

            <?php
                }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">

    </div>
</div>