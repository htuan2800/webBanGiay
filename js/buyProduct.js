$(document).ready(function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // load js
    $.when(
        $.getScript("./js/validate.js")
    ).done(function () {
    });

    // load php address when load page
    function loadAddress(type) {
        if (type == 1) {
            $(".info-payment .info").load("./gui/formAddress.php");
        }
        else {
            $(".info-payment .info").load("./gui/existAddress.php");
        }
    }

    loadAddress($(".info-payment .address-selected input:checked").val());

    // swap type select address
    $(".info-payment .address-selected").on("change", "input", function () {
        var type = $(this).val();
        loadAddress(type);
    })

    // swap address
    $(".info-payment .info").on("change", "#floatingSelect", function (e) {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "./gui/existAddress.php",
            data: {
                'idAddress': id
            },
            dataType: "json",
            success: function (response) {
                $("#phone-number").val(response['phoneNumber']);
                $("#address").val(response['address']);
                $("#recipient-name").val(response['name']);
            }
        });
    })

    // buy product when receive
    $(".info-payment .btn-payment").on("click", ".btn-buy-product", function (e) {
        var name = $("#recipient-name").val();
        var address = $("#address").val();
        var phone = $("#phone-number").val();
        if (name == "" || address == "" || phone == "") {
            Swal.fire({
                title: "Vui lòng điền đầy đủ thông tin!",
                icon: "error",
            });
            return;
        }

        $("#recipient-name ~ .error").text(validateFullname(name));
        $("#address ~ .error").text(validateAddress(address));
        $("#phone-number ~ .error").text(validatePhone(phone));
        var check = validateFullname(name) + validateAddress(address) + validatePhone(phone);
        if (check == "") {
            var receiver = $("#recipient-name").val();
            var address = $("#address").val();
            var phone = $("#phone-number").val();
            var total = Number($(".show-product .price").text().replace(/đ|\./g, ""));
            var products = new URL(window.location.href).searchParams.get
                ("products");
            $.ajax({
                type: "POST",
                url: "./buyProduct.php",
                data: {
                    'buy-product': true,
                    'receiver': receiver,
                    'address': address,
                    'phone': phone,
                    'total': total,
                    'payment-method': "Thanh toán khi nhận hàng",
                    'products': products
                },
                dataType: "html",
                success: function (response) {

                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Đã đặt đơn hàng thành công",
                        showConfirmButton: false,
                        timer: 1500,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            window.location.href = "./index.php";
                        }
                    })
                    console.log(response)
                }
            });
        }

    })

    //add coupon
    $(".info-payment .coupon").on("click", ".btn-add-coupon", function (e) {
        var name = $("#coupon-code").val();
        console.log(name);
        if (name == "") {
            Swal.fire({
                title: "Vui lòng điền đầy đủ thông tin!",
                icon: "error",
            });
            return;
        }

        var receiver = $("#coupon-code").val();
        $.ajax({
            type: "POST",
            url: "./buyProduct.php",
            data: {
                'apply-coupon': true,
                'code': receiver
            },
            dataType: "html",
            success: function (response) {
                var data = JSON.parse(response);
                console.log(data);
                if (data==1) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Thêm mã giảm giá thành công",
                        showConfirmButton: false,
                        timer: 1500
                    });
                
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500);
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Mã giảm giá không hợp lệ!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });


    })

    $(document).on("click", ".btn-remove-coupon", function () {
        $.ajax({
            type: "POST",
            url: "./buyProduct.php",
            data: { remove_coupon: true },
            success: function (response) {
                console.log(response);
                if (response == "1") {
                    location.reload(); // Tải lại trang sau khi xóa mã giảm giá
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: "Không thể xóa mã giảm giá.",
                    });
                }
            },
        });
    });
});