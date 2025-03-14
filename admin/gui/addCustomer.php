<?php
    require_once __DIR__ . "/../../database/database.php";

    $db = new Database();

    if (isset ($_POST['add-customer'])) {
        require_once __DIR__ . "/../../handle.php";
        require_once __DIR__ . "/../../database/user.php";
        $user = new user($db);

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
            $id = $user->insertCustomer($fullname, $phoneNumber, $email, $username, $password, $avatar["name"]);

            $avatar = uploadsAvatar($avatar,$id);
            
            $user->updateAvatar($id, $avatar);
        }
        else {
            $avatar = "./avatar/default-avatar.jpg";
            $user->insertCustomer($fullname, $phoneNumber, $email, $username, $password, $avatar);
        }
        exit ();
    }
?>

<div class="add-customer container">
    <div class="title">
        <h1>Thêm khách hàng</h1>
    </div>

    <div class="content">
        <form action="" method="post" class="row" id="formAddCustomer" enctype="multipart/form-data">

            <div class="form-floating col-6 mb-3">
                <input type="text" class="form-control" id="phone-number" placeholder="Số điện thoại">
                <label for="phone-number">Số điện thoại</label>
            </div>

            <div class="form-floating col-6 mb-3">
                <input type="text" class="form-control" id="fullname" placeholder="Họ tên">
                <label for="fullname">Họ tên</label>
            </div>

            <div class="form-floating mb-3 col-12">
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
                <button class="btn btn-primary" id="save-customer">Thêm khách hàng</button>
            </div>

        </form>
    </div>
</div>