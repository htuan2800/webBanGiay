$(document).ready(function () {

    // load script
    $.when($.getScript("../js/validate.js")).done(function () { });


    // show supplier
    $(".main-panel").on(
        "change",
        ".container .info-supplier .product-tools .show select",
        function () {
            var value = $(this).val();
            $.ajax({
                type: "POST",
                url: "./gui/tableSupplier.php",
                data: {
                    itemOfPage: value,
                },
                dataType: "html",
                success: function (response) {
                    $(".container .info-supplier .table-product").html(response);
                    if ($(".container .info-supplier .pagination li").length - 2 == 1) {
                        $(".container .info-supplier .pagination .next").addClass(
                            "disabled"
                        );
                    }
                },
            });
        }
    );

    // search supplier
    $(".main-panel").on(
        "keyup change",
        ".container .info-supplier .product-tools .search input",
        () => {
            var valueInput = $(
                ".main-panel .container .info-supplier .product-tools .search input"
            ).val();
            var valueItem = $(
                ".main-panel .container .info-supplier .product-tools .search select"
            ).val();
            $.ajax({
                type: "POST",
                url: "./gui/tableSupplier.php",
                data: {
                    itemOfPage: valueItem,
                    valueSearch: valueInput,
                },
                dataType: "html",
                success: function (response) {
                    $(".container .info-supplier .table-product").html(response);
                    if ($(".container .info-supplier .pagination li").length - 2 == 1) {
                        $(".container .info-supplier .pagination .next").addClass(
                            "disabled"
                        );
                    }
                },
            });
        }
    );

    // Delete supplier
    $(".main-panel").on(
        "click",
        ".container .info-supplier tbody .fa-trash",
        function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            Swal.fire({
                title: "Bạn có muốn xóa nhà cung cấp?",
                text: "",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy bỏ",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đã xóa nhà cung cấp",
                        text: "",
                        icon: "success",
                    });
                    $.ajax({
                        type: "POST",
                        url: "./gui/tableSupplier.php",
                        data: {
                            id: id,
                            "delete-supplier": true,
                        },
                        dataType: "html",
                        success: function (response) {
                            console.log(response);
                            $.ajax({
                                type: "POST",
                                url: "./gui/infoSupplier.php",
                                dataType: "html",
                                success: function (response) {
                                    $(".main-panel .container").html(response);
                                },
                            });

                        },
                    });
                }
            });
        }
    );

    // show edit supplier
    $(".main-panel").on(
        "click",
        ".container .info-supplier tbody .fa-edit",
        function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "./gui/editSupplier.php",
                data: {
                    id: id,
                    "edit-supplier": true,
                },
                dataType: "html",
                success: function (response) {
                    // console.log(response)
                    $(".main-panel .container .info-supplier .modal-dialog").html(
                        response
                    );
                    $(".main-panel .container .info-supplier .modal").modal("show");
                },
            });
        }
    );

    $(".container").on(
        "click",
        ".info-supplier .modal-dialog #save-btn",
        function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $("#supplier-name-edit").val();
            var phone = $("#supplier-phone-edit").val();
            var email = $("#supplier-email-edit").val();
            var address = $("#supplier-address-edit").val();

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
            formData.append('edit', true);
            formData.append('id', id);
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('email', email);
            formData.append('address', address);
            $.ajax({
                type: "POST",
                url: "./gui/editSupplier.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    if (response === "Sửa thành công") {
                        $(".main-panel .container .info-supplier .modal").modal("hide");
                        var id = $('.info-supplier .modal-dialog #save-btn').data('id');
                        let row = $('.container .info-supplier tbody .fa-edit[data-id="' + id + '"]').closest('tr');
                        if (row.length) {
                            row.find('td:eq(0)').text(name);
                            row.find('td:eq(1)').text(phone);
                            row.find('td:eq(2)').text(email);
                            row.find('td:eq(3)').text(address);
                            swal.fire({
                                icon: 'success',
                                title: 'Đã sửa thông tin nhà cung cấp',
                            });
                        } else {
                            console.log("Không tìm thấy sản phẩm trong bảng.");
                        }
                    }
                    else {
                        swal.fire({
                            icon: 'info',
                            title: 'Không có gì thay đổi',
                        });
                        $(".main-panel .container .info-supplier .modal").modal("hide");
                    }
                }
            });
        }
    );
    // swap page
    function swapPage(page) {
        $.ajax({
            type: "POST",
            url: "./gui/tableSupplier.php",
            data: {
                page: page,
                itemOfPage: $(
                    ".container .info-supplier .product-tools .show select"
                ).val(),
            },
            dataType: "html",
            success: function (response) {
                $(".container .info-supplier .table-product").html(response);
                $(".container .info-supplier .pagination li").removeClass("active");
                for (
                    var i = 0;
                    i < $(".container .info-supplier .pagination li").length;
                    i++
                ) {
                    if (
                        $(".container .info-supplier .pagination li").eq(i).text() == page
                    ) {
                        $(".container .info-supplier .pagination li")
                            .eq(i)
                            .addClass("active");
                    }
                }
                if (page == 1) {
                    $(".container .info-supplier .pagination .previous").addClass(
                        "disabled"
                    );
                } else {
                    $(".container .info-supplier .pagination .previous").removeClass(
                        "disabled"
                    );
                }
                if (page == $(".container .info-supplier .pagination li").length - 2) {
                    $(".container .info-supplier .pagination .next").addClass("disabled");
                } else {
                    $(".container .info-supplier .pagination .next").removeClass(
                        "disabled"
                    );
                }
            },
        });
    }

    $(".main-panel").on(
        "click",
        ".container .info-supplier .pagination a",
        function (e) {
            e.preventDefault();
            var page = $(this).text();
            swapPage(page);
        }
    );

    // previous page
    $(".main-panel").on(
        "click",
        ".container .info-supplier .pagination .previous",
        function (e) {
            e.preventDefault();
            var pageCurrent = $(
                ".container .info-supplier .pagination li.active"
            ).text();
            if (pageCurrent == 1) {
                return;
            }
            var page = Number(pageCurrent) - 1;
            swapPage(page);
        }
    );

    // next page
    $(".main-panel").on(
        "click",
        ".container .info-supplier .pagination .next",
        function (e) {
            e.preventDefault();
            var pageCurrent = $(
                ".container .info-supplier .pagination li.active"
            ).text();

            var page = Number(pageCurrent) + 1;

            swapPage(page);
        }
    );
});