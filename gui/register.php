<?php
    if (isset($_POST["submit"])) {
        $fullname = $_POST["fullname"];
        $phoneNumber = $_POST["phone-number"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["password-confirm"];
        if (isset($_FILES["avatar"])) {
            $avatar = $_FILES["avatar"];
        }

        require_once "../database/database.php";
        require_once "../database/user.php";
        $db = new database();
        $users = new user($db);

        $check = $users->checkRegister($phoneNumber, $username);

        if ($check != "") {
            echo $check;
            return;
        }
        
        if (isset($avatar)) {
            require_once "../handle.php";
            $id = $users->insertRegister([$fullname, $phoneNumber, $username, $password, $avatar["name"]]);

            $avatar = uploadsAvatar($avatar,$id);
            
            $users->updateAvatar($id, $avatar);
        }
        else {
            $avatar = "./avatar/default-avatar.jpg";
            $users->insertRegister([$fullname, $phoneNumber, $username, $password, $avatar]);
        }
    }
    else {

?>

<form action="./gui/register.php" class="form-register d-flex flex-column justify-content-center align-items-center"
    enctype="multipart/form-data" method="post">


    <div class="form-group">
        <input type="text" name="fullname" placeholder="Họ tên">
        <i><i class="fa-solid fa-user icon-user"></i></i>
        <span class="underline"></span>
        <span class="error"></span>
    </div>

    <div class="form-group">
        <input type="text" name="phone-number" placeholder="Số điện thoại">
        <i><i class="fa-solid fa-phone icon-phone"></i></i>
        <span class="underline"></span>
        <span class="error"></span>
    </div>

    <div class="form-group">
        <input type="text" name="username" placeholder="Tài khoản">
        <i><i class="fa-solid fa-user icon-user"></i></i>
        <span class="underline"></span>
        <span class="error"></span>
    </div>

    <div class="form-group">
        <input type="password" name="password" placeholder="Mật khẩu">
        <i><i class="fa-solid fa-lock icon-lock"></i></i>
        <span class="underline"></span>
        <span class="error"></span>
    </div>

    <div class="form-group">
        <input type="password" name="password-confirm" placeholder="Xác nhận mật khẩu">
        <i><i class="fa-solid fa-lock icon-lock"></i></i>
        <span class="underline"></span>
        <span class="error"></span>
    </div>

    <div class="form-group">
        <input type="file" name="avatar" placeholder="Ảnh đại diện" accept="image/*">
        <i><i class="fa-solid fa-user icon-user"></i></i>
        <span class="underline"></span>
    </div>

    <button type="submit" class="btn btn-primary" name="submit" id="submit-register">Đăng kí</button>
</form>

<script>
$(document).ready(function() {

    // load validate.js
    $.getScript('./js/validate.js');

    $("#submit-register").click(function(e) {
        e.preventDefault();
        var fullname = $("input[name='fullname']").val();
        var phone = $("input[name='phone-number']").val();
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();
        var confirmPassword = $("input[name='password-confirm']").val();
        var avatar = document.querySelector("input[name='avatar']");

        var checkEmpty = validateEmpty(fullname) || validateEmpty(phone) || validateEmpty(username) ||
            validateEmpty(
                password) || validateEmpty(confirmPassword);

        if (checkEmpty) {
            Swal.fire({
                icon: "error",
                title: "Không được để trống các trường",
                text: "",
                showConfirmButton: false
            });
            return;
        }

        // validate
        $("input[name='fullname'] ~ .error").text(validateFullname(fullname));

        $("input[name='phone-number'] ~ .error").text(validatePhone(phone));

        $("input[name='username'] ~ .error").text(validateUsername(username));

        $("input[name='password'] ~ .error").text(validatePassword(password));

        $("input[name='password-confirm'] ~ .error").text(validateConfirmPassword(password,
            confirmPassword));

        var check = true;
        $.each($(".error"), function(i, val) {
            if ($(val).text() !== "") {
                check = false;
            }
        });



        if (check) {
            var form = new FormData();
            form.append('submit', 'submit');
            form.append('fullname', fullname);
            form.append('phone-number', phone);
            form.append('username', username);
            form.append('password', password);
            form.append('password-confirm', confirmPassword);
            form.append('avatar', avatar.files[0]);

            $.ajax({
                type: "POST",
                url: "./gui/register.php",
                data: form,
                dataType: "html",
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == "") {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Đăng kí tài khoản thành công",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(function() {
                            $.ajax({
                                type: "GET",
                                url: "./gui/login.php?username=" + username,
                                dataType: "html",
                                success: function(response) {
                                    $(".modal").html(response);
                                }
                            });
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: response,
                            text: "",
                            showConfirmButton: false
                        });
                    }
                }
            });
        }
    });
});
</script>

<?php
    }
?>