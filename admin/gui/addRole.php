<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/role.php";

    $db = new Database();
    $role = new Role($db);

    if (isset ($_POST['add-role'])) {
        $name = $_POST['name'];
        $listTask = $_POST['listTask'];

        $id = $role->insertRole($name);

        foreach ($listTask as $task) {
            $idTask = $task['idTask'];
            $idPermission = $task['idPermission'];

            $role->insertRoleDetail($id, $idTask, $idPermission);
        }

        echo $id;

        exit ();
    }

    $tasks = $role->selectAllTask();
    $permissiongroups = $role->selectAllPermission();
?>

<div class="add-role container">
    <div class="row">
        <div class="col-12 mb-3 title">
            <h4 class="text-center">Tạo vai trò</h4>
        </div>

        <div class="col-6">
            <div class="mb-3">
                <input type="email" class="form-control" id="role-name" placeholder="Nhập tên vai trò">
            </div>
        </div>

        <div class="col-6">
            <button class="btn btn-primary" id="add-role">Thêm vai trò</button>
        </div>

        <div class="col-12 mt-3 row task">
            <div class="col-4"></div>

            <?php
                while ($row = $tasks->fetch_assoc()) {
            ?>
            <div class="col-2"><?=$row['taskName']; ?></div>
            <?php
                }
            ?>
        </div>

        <?php
            while ($row = $permissiongroups->fetch_assoc()) {
        ?>
        <div class="col-12 mt-3 row permissiongroup">
            <div class="col-4">
                <?=$row['permissionName']; ?>
            </div>

            <?php
                foreach ($tasks as $task) {
            ?>
            <div class="col-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?= $task['idTask']; ?>"
                        id="flexCheckDefault" data-id-permission="<?= $row['idPermission']; ?>">
                </div>
            </div>
            <?php
                }
            ?>

        </div>
        <?php
            }
        ?>
    </div>