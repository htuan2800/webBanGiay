$(document).ready(function () {
    $(".main-panel").on('click', '.container .info-customer tbody .btn', function (e) {
        e.preventDefault();
        var id = $(this).closest('tr').find('img').data('id');
        if ($(this).hasClass('btn-success')) {
            Swal.fire({
                title: "Bạn có chắc muốn khóa tài khoản này?",
                text: "",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Khóa tài khoản",
                cancelButtonText: "Hủy bỏ"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đã khóa tài khoản",
                        text: "",
                        icon: "success"
                    });

                    $(this).removeClass('btn-success').addClass('btn-danger');
                    $(this).text('Khoá hoạt động');
                    $.ajax({
                        type: "POST",
                        url: "./gui/infoCustomer.php",
                        data: {
                            "id": id,
                            'block-customer': true
                        },
                        dataType: "html",
                        success: function (response) {

                        }
                    });
                }
            });
        }
        else if ($(this).hasClass('btn-danger')) {
            Swal.fire({
                title: "Bạn muốn mở khóa tài khoản này?",
                text: "",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Mở tài khoản",
                cancelButtonText: "Hủy bỏ"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đã mở tài khoản",
                        text: "",
                        icon: "success"
                    });

                    $(this).removeClass('btn-danger').addClass('btn-success');
                    $(this).text('Được hoạt động');
                    $.ajax({
                        type: "POST",
                        url: "./gui/infoCustomer.php",
                        data: {
                            "id": id,
                            'unblock-customer': true
                        },
                        dataType: "html",
                        success: function (response) {

                        }
                    });
                }
            });
        }
    });
});