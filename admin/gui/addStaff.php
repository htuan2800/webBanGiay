<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/role.php";

    $db = new Database();
    $role = new role($db);

    if (isset ($_POST['add-staff'])) {
        require_once __DIR__ . "/../../handle.php";
        require_once __DIR__ . "/../../database/user.php";
        $user = new user($db);

        $idRole = $_POST['idRole'];
        $phoneNumber = $_POST['phone-number'];
        $fullname = $_POST['fullname'];
        $email = isset ($_POST['email']) ? $_POST['email'] : '';
        $username = $_POST['username'];
        $password = $_POST['password'];

        $check = $user->checkRegister($phoneNumber, $username);
        if ($check != "") {
            echo $check;
            return;
        }
        $check = $user->checkEmail($email);
        if ($check != "") {
            echo $check;
            return;
        }

        if (isset($_FILES["avatar"])) {
            $avatar = $_FILES["avatar"];
        }
        if (isset($avatar)) {
            $id = $user->insertStaff($idRole, $fullname, $phoneNumber, $email, $username, $password, $avatar["name"]);

            $avatar = uploadsAvatar($avatar,$id);
            
            $user->updateAvatar($id, $avatar);
        }
        else {
            $avatar = "./avatar/default-avatar.jpg";
            $user->insertStaff($idRole, $fullname, $phoneNumber, $email, $username, $password, $avatar);
        }
        exit ();
    }
?>

<div class="add-staff container">
    <div class="title">
        <h1>Thêm nhân viên</h1>
    </div>

    <div class="content">
        <form action="" method="post" class="row" id="formAddStaff" enctype="multipart/form-data">

            <div class="form-floating col-6 mb-3">
                <select class="form-select" id="role" aria-label="Floating label select example">

                    <?php
                        $result = $role->selectAllWithOutCustomer();
                        while ($row = $result->fetch_assoc()) {
                    ?>

                    <option value="<?= $row['idRole']; ?>"><?= $row['roleName']; ?></option>

                    <?php
                        }
                    ?>

                </select>
                <label for="role">Vai trò</label>
            </div>

            <div class="form-floating col-6 mb-3">
                <input type="text" class="form-control" id="phone-number" placeholder="Số điện thoại">
                <label for="phone-number">Số điện thoại</label>
            </div>

            <div class="form-floating col-6 mb-3">
                <input type="text" class="form-control" id="fullname" placeholder="Họ tên">
                <label for="fullname">Họ tên</label>
            </div>

            <div class="form-floating mb-3 col-6">
                <input type="email" class="form-control" id="email" placeholder="Email (không bắt buộc)">
                <label for="email">Email (không bắt buộc)</label>
            </div>

            <div class="form-floating mb-3 col-12">
                <input type="username" class="form-control" id="username" placeholder="Tên đăng nhập">
                <label for="username">Tên đăng nhập</label>
            </div>

            <div class="form-floating mb-3 col-12">
                <input type="password" class="form-control" id="password" placeholder="Mật khẩu">
                <label for="password">Mật khẩu</label>
            </div>

            <div class="form-floating mb-3 col-12">
                <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;">
                <button class="btn btn-success" id="add-avatar">Thêm ảnh đại diện</button>
            </div>

            <div class="form-floating mb-3 col-12 justify-content-center" style="display: none;">
                <img src="" id="avatar-img" alt="avatar" class="img-fluid" style="max-width: 200px;">
                <button class="btn btn-danger" id="remove-avatar" style="border-radius: 0;">Xóa</button>
                <button class="btn btn-warning" id="update-avatar" style="border-radius: 0;">Đổi ảnh</button>
            </div>

            <div class="form-group mt-3 d-flex justify-content-center align-items-center col-12">
                <button class="btn btn-primary" id="save-staff">Thêm nhân viên</button>
            </div>

        </form>
    </div>
</div>