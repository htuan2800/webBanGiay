$(document).ready(function () {
    // load js
    $.when(
        $.getScript("../js/validate.js")
    ).done(function () {
    });

    // add avatar
    $('.container').on('click', '.add-customer #add-avatar', function (e) {
        e.preventDefault();
        $('#avatar').click();
    })

    var file = '';
    $('.container').on('change', '.add-customer #avatar', function () {
        file = this.files[0];
        $('#add-avatar').parent().css('display', 'none');
        $('#avatar-img').parent().css('display', 'flex');
        $('#avatar-img').attr('src', URL.createObjectURL(file));
    });

    // add customer
    $('.container').on('click', '.add-customer #save-customer', function (e) {
        e.preventDefault();
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
        formData.append('avatar', file);
        formData.append('phone-number', phone);
        formData.append('fullname', name);
        formData.append('email', email);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('add-customer', true);

        $.ajax({
            type: "POST",
            url: './gui/addCustomer.php',
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
                    title: 'Thêm khách hàng thành công',
                    text: ''
                });
            }
        });
    });

    // remove avatar
    $('.container').on('click', '.add-customer #remove-avatar', function (e) {
        e.preventDefault();
        $('#avatar').val('');
        $('#add-avatar').parent().css('display', 'block');
        $('#avatar-img').parent().css('display', 'none');
        $('#avatar-img').attr('src', '');
        file = '';
    })

    // update avatar
    $('.container').on('click', '.add-customer #update-avatar', function (e) {
        e.preventDefault();
        $('#avatar').click();
    })
});