<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/user.php";
    require_once __DIR__ . "/../../database/role.php";

    $db = new database();
    $user = new user($db);
    $role = new role($db);

    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $idRole = $_POST['idRole'];
        $name = $_POST['fullName'];
        $phoneNumber = $_POST['phoneNumber'];
        $email = $_POST['email'];

        // echo $id . " " . $name . " " . $phoneNumber . " " . $email . " " . $idRole;
        // exit ();
        if (isset($_POST['avatarDefault'])) {
            $avatar = "./avatar/default-avatar.jpg";
            echo $user->updateStaffDefaultAvatar($id, $name, $phoneNumber, $idRole, $email);
            exit();
        }

        if (isset($_FILES['avatar'])) {
            $avatar = $_FILES['avatar'];
        }

        if (isset($avatar)) {
            echo $user->updateStaff($id, $name, $phoneNumber, $idRole, $email, $avatar);
        }
        else {
            echo $user->updateStaff($id, $name, $phoneNumber, $idRole, $email, '');
        }

        exit();
    }

    if (isset($_POST['edit-staff'])) {
        $id = $_POST['id'];
        $staff = $user->selectById($id);
        $staff = $staff->fetch_assoc();
        // echo json_encode($staff);
        // exit();
        $roles = $role->selectAllWithOutCustomer();
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Sửa thông tin nhân viên</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="" class="container-fluid row">
            <div class="mb-4 col-6">
                <label for="full-name" class="form-label">Tên nhân viên</label>
                <input type="text" class="form-control" id="full-name" placeholder="Nhập tên nhân viên"
                    value="<?php echo $staff['fullName']; ?>">
                <span class="text-danger"></span>
            </div>
            <div class="mb-4 col-6">
                <label for="phone-number" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone-number" placeholder="Nhập số điện thoại"
                    value="<?php echo $staff['phoneNumber'] ?? 'Không có'; ?>">
                <span class="text-danger"></span>
            </div>
            <div class="mb-4 col-6">
                <label for="role" class="form-label">Vai trò</label>
                <select id="role" class="form-select">
                    <?php
                        foreach ($roles as $key => $value) {
                            if ($staff['idRole'] == $value['idRole']) {
                    ?>
                    <option value="<?php echo $value['idRole']; ?>" selected><?php echo $value['roleName']; ?></option>
                    <?php
                            }
                            else {
                    ?>
                    <option value="<?php echo $value['idRole']; ?>"><?php echo $value['roleName']; ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="mb-4 col-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" placeholder="Nhập email"
                    value="<?php echo $staff['email'] ?? 'Không có'; ?>">
                <span class="text-danger"></span>
            </div>
            <div class="mb-1 col-12 d-flex align-items-center flex-column justify-content-center">
                <?php
                    if (strncmp($staff['avatar'],"https", 5) == 0) {
                        $avatar = $staff['avatar'];
                    }
                    else {
                        $avatar = "." . $staff['avatar'] . "?" . time();
                    }
                ?>
                <label for="avatar" class="form-label"
                    style="font-weight: bold;font-size: 22px !important;">Avatar</label>
                <img src="<?= $avatar; ?>" id="avatar-img" alt="Lỗi ảnh" class="img-fluid" width="400px">
                <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;">
            </div>
            <div class="mb-2 col-12 d-flex align-items-center justify-content-center">
                <button class="btn btn-warning" id="change-avatar" style="margin-right: 20px;">Sửa ảnh</button>
                <button class="btn btn-danger" id="remove-avatar">Xóa</button>
            </div>
        </form>
    </div>
    <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-primary" id="save-btn" data-id="<?php echo $staff['idUser']; ?>">Lưu thay
            đổi</button>
    </div>
</div>