$(document).ready(function () {
    // load script
    $.when($.getScript("../js/validate.js")).done(function () { });
    //add supplier
    $(".container").on('click', '#save-supplier', function (e) {
        e.preventDefault();
        var name = $("#supplier-name").val();
        var phone = $("#supplier-phone").val();
        var email = $("#supplier-email").val();
        var address = $("#supplier-address").val();
        if (name === "") {
            Swal.fire({
                icon: 'error',
                title: 'Không được để trống tên nhà cung cấp!',
                text: 'Xin vui lòng nhập vào tên nhà cung cấp',
            });
            return;
        }
        if (phone === "") {
            Swal.fire({
                icon: 'error',
                title: 'Không được để trống số điện thoại!',
                text: 'Xin vui lòng nhập vào số điện thoại',
            });
            return;
        }
        if (email === "") {
            Swal.fire({
                icon: 'error',
                title: 'Không được để trống email!',
                text: 'Xin vui lòng nhập vào email',
            });
            return;
        }
        if (address === "") {
            Swal.fire({
                icon: 'error',
                title: 'Không được để trống địa chỉ!',
                text: 'Xin vui lòng nhập vào địa chỉ',
            });
            return;
        }
        if (validatePhone(phone) != "") {
            Swal.fire({
                icon: 'error',
                title: validatePhone(phone),
            });
            return;
        }
        if (validateEmail(email) != "") {
            Swal.fire({
                icon: 'error',
                title: validateEmail(email),
            });
            return;
        }
        var formData = new FormData();
        formData.append('add-supplier', true);
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('address', address);
        $.ajax({
            type: "POST",
            url: "./gui/addSupplier.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response === "Thêm thành công") {
                    $("#supplier-name").val("");
                    $("#supplier-phone").val("");
                    $("#supplier-email").val("");
                    $("#supplier-address").val("");
                    swal.fire({
                        icon: 'success',
                        title: 'Đã thêm nhà cung cấp',
                    });
                }
            }
        });

    });
});