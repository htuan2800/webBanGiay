$(document).ready(function () {
    // load js
    $.when(
        $.getScript("../js/validate.js")
    ).done(function () {
    });

    // add avatar
    $('.container').on('click', '.add-staff #add-avatar', function (e) {
        e.preventDefault();
        $('#avatar').click();
    })

    var file = '';
    $('.container').on('change', '.add-staff #avatar', function () {
        file = this.files[0];
        $('#add-avatar').parent().css('display', 'none');
        $('#avatar-img').parent().css('display', 'flex');
        $('#avatar-img').attr('src', URL.createObjectURL(file));
    });

    // add staff
    $('.container').on('click', '.add-staff #save-staff', function (e) {
        e.preventDefault();
        var idRole = $('#role').val();
        var phone = $('#phone-number').val();
        var name = $('#fullname').val();
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();

        if (phone == "" || name == "" || username == "" || password == "") {
            Swal.fire({
                icon: 'error',
                title: 'Không bỏ trống các trường!',
                text: 'Vui lòng điền đầy đủ thông tin',
            });
            return;
        }

        if (validatePhone(phone) != "") {
            Swal.fire({
                icon: 'error',
                title: validatePhone(phone)
            });
            return;
        }

        if (validateFullname(name) != "") {
            Swal.fire({
                icon: 'error',
                title: validateFullname(name)
            });
            return;
        }

        if (validateUsername(username) != "") {
            Swal.fire({
                icon: 'error',
                title: validateUsername(username)
            });
            return;
        }

        if (validatePassword(password) != "") {
            Swal.fire({
                icon: 'error',
                title: validatePassword(password)
            });
            return;
        }

        if (email != "") {
            if (validateEmail(email) != "") {
                Swal.fire({
                    icon: 'error',
                    title: validateEmail(email)
                });
                return;
            }
        }

        var formData = new FormData();
        formData.append('idRole', idRole);
        formData.append('avatar', file);
        formData.append('phone-number', phone);
        formData.append('fullname', name);
        formData.append('email', email);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('add-staff', true);

        $.ajax({
            type: "POST",
            url: './gui/addStaff.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response)
                if (response !== '') {
                    Swal.fire({
                        icon: 'warning',
                        title: response,
                        text: response
                    });
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Thêm nhân viên thành công',
                    text: ''
                });
            }
        });
    });

    // remove avatar
    $('.container').on('click', '.add-staff #remove-avatar', function (e) {
        e.preventDefault();
        $('#avatar').val('');
        $('#add-avatar').parent().css('display', 'block');
        $('#avatar-img').parent().css('display', 'none');
        $('#avatar-img').attr('src', '');
        file = '';
    })

    // update avatar
    $('.container').on('click', '.add-staff #update-avatar', function (e) {
        e.preventDefault();
        $('#avatar').click();
    })
});