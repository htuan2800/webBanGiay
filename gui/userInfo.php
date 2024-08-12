<?php
    if (!function_exists('customErrorHandler')) {
        function customErrorHandler($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        }

        set_error_handler("customErrorHandler");
    }
    
    try {
        include_once "./database/database.php";
        include_once "./database/user.php";
    } catch (ErrorException $e) {
        try {
            include_once "../database/database.php";
            include_once "../database/user.php";
        } catch (ErrorException $e) {
            echo "Failed to include autoload file: " . $e->getMessage() . "\n";
        }
    }
    restore_error_handler();
    
    $db = new Database();
    $user = new User($db);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // update avatar
    if (isset ($_POST['update-avatar'])) {
        $id = $_SESSION['account_login']['idUser'];
        $avatar = $_FILES['avatar'];
        require_once __DIR__ . "\\..\\handle.php";
        $user->updateAvatar($id, uploadsAvatar($avatar, $id));
        $result = $user->selectById($id);
        $result = $result->fetch_assoc();
        $_SESSION['account_login'] = $result;
        header("Location: http://localhost/webBanGiay/userInfo.php");
    }

    $result = $user->selectById($_SESSION['account_login']['idUser']);
    $result = $result->fetch_assoc();
?>

<div class="row">
    <div class="avatar col-lg-12 col-md-12 col-sm-12 d-flex flex-column justify-content-center">
        <img src="<?php echo $result['avatar']; ?>" alt="" class="img-fluid muted" data-bs-toggle="tooltip"
            data-bs-title="Cập nhật ảnh đại diện" id="avatar">
        <button id="update-avatar" class="btn btn-primary mt-2">Thay đổi ảnh đại diện</button>
        <input type="file" name="" id="avatar-input" accept="image/*" style="display: none;">
    </div>

    <form action="" class="col-lg-12 col-md-12 col-sm-12 row">
        <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
            <label for="full-name" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="full-name" value="<?php echo $result['fullName']; ?>" readonly>
        </div>
        <?php
            if ($result['email'] == "") {
        ?>

        <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
            <label for="phone-number" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone-number" value="<?php echo $result['phoneNumber']; ?>"
                readonly>
        </div>

        <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
            <label for="username" class="form-label">Tài khoản</label>
            <input type="text" class="form-control" id="username" value="<?php echo $result['username']; ?>" readonly>
        </div>
        <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="text" class="form-control" id="password" value="" placeholder="Nhập mật khẩu hiện tại">
        </div>
        <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
            <label for="change-password" class="form-label">Thay đổi mật khẩu</label>
            <input type="text" class="form-control" id="change-password" value="" placeholder="Nhập mật khẩu mới">
        </div>

        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>

        <?php
            } else {
        ?>
        <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" value="<?php echo $result['email']; ?>" readonly>
        </div>
        <?php
                    if ($result['phoneNumber'] == "") {
                ?>
        <div class="mb-3 col-lg-9 col-md-9 col-sm-9">
            <label for="phone-number" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone-number" value="">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <label for="phone-number" class="form-label" style="visibility: hidden;">Thêm</label>
            <button class="btn btn-primary">Thêm số điện thoại</button>
        </div>
        <?php

                    } else {
                    ?>
        <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
            <label for="phone-number" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone-number" value="<?php echo $result['phoneNumber']; ?>"
                readonly>
        </div>
        <?php
            }}
        ?>
    </form>
</div>