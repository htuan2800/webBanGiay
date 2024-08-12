$(document).ready(function () {
    // load js
    $.when(
        $.getScript("../js/validate.js")
    ).done(function () {
    });

    function checkButtonSwapPage(page) {
        var nextPage = page.parent().next().find('a')
        if (nextPage.hasClass('next')) {
            nextPage.addClass('disabled');
        }

        var previousPage = page.parent().prev().find('a')
        if (previousPage.hasClass('previous')) {
            previousPage.addClass('disabled');
        }
    }

    window.checkButtonSwapPage = checkButtonSwapPage

    // lock/unlock staff
    $(".container").on('click', '.info-staff .table tbody .button-lock button', function () {
        var id = $(this).data('id');
        var type = '';
        if ($(this).hasClass("btn-success")) {
            type = 'lock';
            $(this).removeClass("btn-success").addClass("btn-danger");
            $(this).text("Khoá hoạt động");
        }
        else if ($(this).hasClass("btn-danger")) {
            type = 'unlock';
            $(this).removeClass("btn-danger").addClass("btn-success");
            $(this).text("Được hoạt động");
        }

        $.ajax({
            type: "POST",
            url: "./gui/tableStaff.php",
            data: {
                'id': id,
                'type': type
            },
            dataType: "html",
            success: function (response) {

            }
        });
    });

    // remove staff
    $(".container").on('click', '.info-staff .table tbody .fa-trash', function () {
        var id = $(this).data('id');
        var parent = $(this).closest('tr');

        Swal.fire({
            title: "Bạn có muốn xoá nhân viên này?",
            text: "",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy bỏ"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Đã xoá nhân viên",
                    text: "",
                    icon: "success"
                });
                parent.remove();
                $.ajax({
                    type: "POST",
                    url: "./gui/tableStaff.php",
                    data: {
                        'id': id,
                        'remove-staff': true
                    },
                    dataType: "html",
                    success: function (response) {
                    }
                });
            }
        });
    })

    // edit staff
    var row = '';
    $(".container").on('click', '.info-staff .table tbody .fa-edit', function () {
        var id = $(this).data('id');
        row = $(this).closest('tr');
        $.ajax({
            type: "POST",
            url: "./gui/editStaff.php",
            data: {
                'id': id,
                'edit-staff': true
            },
            dataType: "html",
            success: function (response) {
                $(".info-staff .modal-dialog").html(response);
            }
        });
    })

    var file = '';

    $(".container").on('click', '.info-staff .modal-dialog #remove-avatar', function (e) {
        e.preventDefault();
        $("#avatar-img").attr("src", "../avatar/default-avatar.jpg");
        $("#avatar-input").val("");
        file = 'default';
    })

    $(".container").on('click', '.info-staff .modal-dialog #change-avatar', function (e) {
        e.preventDefault();
        $("#avatar-input").click()
    })

    $(".container").on('change', '#avatar-input', function (e) {
        file = e.target.files[0];
        console.log(file);
        $("#avatar-img").attr("src", URL.createObjectURL(file));
    })

    $(".container").on('click', '.info-staff .modal-dialog #save-btn', function (e) {
        e.preventDefault();
        console.log(file);
        var idUser = $(this).data('id');
        var fullName = $("#full-name").val();
        var phoneNumber = $("#phone-number").val();
        var email = $("#email").val();

        if (fullName == "" || phoneNumber == "") {
            Swal.fire({
                icon: 'error',
                title: 'Không bỏ trống trường nào!',
                text: 'Vui lòng điền đầy đủ thông tin',
            });
            return;
        }

        $('#full-name ~ span').text(validateFullname(fullName));
        $('#phone-number ~ span').text(validatePhone(phoneNumber));

        var check = validateFullname(fullName) == "" && validatePhone(phoneNumber) == "";
        if (!check) {
            return;
        }

        if (email != "Không có") {
            $('#email ~ span').text(validateEmail(email));

            check = validateEmail(email) == "";
            if (!check) {
                return;
            }
        }
        else {
            $('#email ~ span').text("");
        }

        var idRole = $("#role").val();

        var formData = new FormData();
        if (file != 'default' && file != '') {
            formData.append("avatar", file);
        }
        else {
            formData.append("avatarDefault", true);
        }
        formData.append("fullName", fullName);
        formData.append("phoneNumber", phoneNumber);
        formData.append("email", email);
        formData.append("idRole", idRole);
        formData.append("id", idUser);
        formData.append("edit", true);

        $.ajax({
            type: "POST",
            url: './gui/editStaff.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == "1") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã lưu!',
                    })
                    row.find('td').eq(0).text(fullName);
                    row.find('td').eq(1).text(phoneNumber);
                    row.find('td').eq(2).text(email);
                    row.find('td').eq(3).find('img').attr("src", URL.createObjectURL(file));
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Đã xảy ra lỗi!',
                        text: response
                    })
                }
            }
        });

    })

    // show row of staff
    $(".container").on('change', '.info-staff .staff-tools #itemOfPage', function () {
        var value = $(this).val();

        $.ajax({
            type: "POST",
            url: "./gui/tableStaff.php",
            data: {
                'itemOfPage': value,
                'page': 1
            },
            dataType: "html",
            success: function (response) {
                console.log(response)
                $(".info-staff .table-staff").html(response);

                $.ajax({
                    type: "POST",
                    url: "./gui/tableStaff.php",
                    data: {
                        'get-staff-count': true
                    },
                    dataType: "html",
                    success: function (response) {
                        var count = Number(response);
                        var page = Math.ceil(count / value);
                        var content = '';
                        content += `
                        <li class="page-item">
                            <a class="page-link previous disabled" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        `;

                        for (var i = 1; i <= page; i++) {
                            if (i == 1) {
                                content += `
                                <li class="page-item active">
                                    <a class="page-link" href="#">${i}</a>
                                </li>
                                `;
                            }
                            else {
                                content += `
                                <li class="page-item">
                                    <a class="page-link" href="#">${i}</a>
                                </li>
                                `;
                            }
                        }

                        if (page == 1) {
                            content += `
                            <li class="page-item">
                                <a class="page-link next disabled" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                            `;
                        }
                        else {
                            content += `
                            <li class="page-item">
                                <a class="page-link next" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                            `;
                        }
                        $(".info-staff .pagination ul.pagination").html(content);
                    }
                });
            }
        });
    })

    // swap page
    $(".container").on('click', '.info-staff .pagination ul.pagination .page-item .page-link:not(.previous):not(.next)', function (e) {
        e.preventDefault();
        var page = $(this).text();

        $('.info-staff .pagination ul.pagination .page-item').removeClass('active');
        $(this).parent().addClass('active');

        $('.info-staff .pagination ul.pagination .page-item a').removeClass('disabled');

        checkButtonSwapPage($(this))

        $.ajax({
            type: "POST",
            url: "./gui/tableStaff.php",
            data: {
                'page': page,
                'itemOfPage': $('.info-staff .staff-tools #itemOfPage').val()
            },
            dataType: "html",
            success: function (response) {
                $(".info-staff .table-staff").html(response);
            }
        });
    })

    // next page
    $(".container").on('click', '.info-staff .pagination ul.pagination .page-item .page-link.next', function (e) {
        e.preventDefault();

        var pageCurrent = $('.info-staff .pagination ul.pagination .page-item.active a');
        $('.info-staff .pagination ul.pagination .page-item a').removeClass('disabled');

        if (pageCurrent.text() == $('.info-staff .pagination ul.pagination .page-item').length) {
            return;
        }

        $('.info-staff .pagination ul.pagination .page-item').removeClass('active');
        pageCurrent.parent().next().addClass('active');

        var page = $('.info-staff .pagination ul.pagination .page-item.active a');

        checkButtonSwapPage(page)
        $.ajax({
            type: "POST",
            url: "./gui/tableStaff.php",
            data: {
                'page': Number($('.info-staff .pagination ul.pagination .page-item.active a').text()),
                'itemOfPage': $('.info-staff .staff-tools #itemOfPage').val()
            },
            dataType: "html",
            success: function (response) {
                console.log(response)
                $(".info-staff .table-staff").html(response);
            }
        });
    })

    // previous page
    $(".container").on('click', '.info-staff .pagination ul.pagination .page-item .page-link.previous', function (e) {
        e.preventDefault();
        var pageCurrent = $('.info-staff .pagination ul.pagination .page-item.active a');

        $('.info-staff .pagination ul.pagination .page-item a').removeClass('disabled');

        if (pageCurrent.text() == 1) {
            return;
        }

        $('.info-staff .pagination ul.pagination .page-item').removeClass('active');
        pageCurrent.parent().prev().addClass('active');

        var page = $('.info-staff .pagination ul.pagination .page-item.active a');

        checkButtonSwapPage(page)

        $.ajax({
            type: "POST",
            url: "./gui/tableStaff.php",
            data: {
                'page': Number($('.info-staff .pagination ul.pagination .page-item.active a').text()),
                'itemOfPage': $('.info-staff .staff-tools #itemOfPage').val()
            },
            dataType: "html",
            success: function (response) {
                $(".info-staff .table-staff").html(response);
            }
        });
    })
});