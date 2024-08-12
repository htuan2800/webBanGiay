<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/role.php";

    $db = new database();
    $role = new role($db);

    if (isset ($_POST['see-role'])) {
        $id = $_POST['id'];
        $roles = $role->selectRole($id);
        $tasks = $role->selectAllTask ();
        $permissiongroups = $role->selectAllPermission();
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thông tin vai trò: <?= $roles['roleName']; ?></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container-fluid row">
            <div class="task col-12 row mb-3">
                <div class="col-4"></div>
                <?php
                    while ($row = $tasks->fetch_assoc()) {
                ?>
                <div class="col-2"><?= $row['taskName']; ?></div>
                <?php
                    }
                ?>
            </div>

            <?php
                while ($row = $permissiongroups->fetch_assoc()) {
            ?>

            <div class="permission col-12 row mb-3">
                <div class="col-4 d-flex align-items-center">
                    <?= $row['permissionName']; ?>
                </div>

                <?php
                    $roleDetail = $role->selectRoleDetailByIdPermission($id, $row['idPermission']);
                    $taskLength = $tasks->num_rows;
                    for ($i = 1; $i <= $taskLength; $i++) {
                ?>

                <?php
                    $check = false;
                    foreach ($roleDetail as $key => $value) {
                        if ($i == $value['idTask']) {
                            $check = true;
                ?>

                <div class="col-2 d-flex align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?= $i; ?>" id="flexCheckDefault"
                            data-id-permission="<?= $row['idPermission']; ?>" checked disabled>
                    </div>
                </div>

                <?php
                        }
                    }
                    if ($check == false) {
                ?>

                <div class="col-2 d-flex align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?= $i; ?>" id="flexCheckDefault"
                            data-id-permission="<?= $row['idPermission']; ?>" disabled>
                    </div>
                </div>

                <?php
                    }
                ?>

                <?php
                    }
                ?>

            </div>

            <?php
                }
            ?>
        </div>
    </div>
</div>