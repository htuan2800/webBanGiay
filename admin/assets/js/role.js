$(document).ready(function () {
    // see role
    $(".container").on('click', '.info-role .table tbody .fa-eye', function () {
        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "./gui/showDetailRole.php",
            data: {
                "id": id,
                'see-role': true
            },
            dataType: "html",
            success: function (data) {
                $(".modal-dialog").html(data);
                $("#modal-role").modal('show');
            }
        });
    })

    // edit role
    var dateUpdate;
    $(".container").on('click', '.info-role .table tbody .fa-edit', function () {
        var id = $(this).data('id');
        dateUpdate = $(this).closest('tr').find('td').eq(2)
        console.log(dateUpdate)

        $.ajax({
            type: "POST",
            url: "./gui/editRole.php",
            data: {
                "id": id,
                'edit-role': true
            },
            dataType: "html",
            success: function (data) {
                $(".modal-dialog").html(data);
                $("#modal-role").modal('show');
            }
        });
    })

    $(".container").on('click', '.modal-dialog #edit-role', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var listTask = [];

        var inputTask = $(".modal-dialog input[type='checkbox']:checked");

        $.each(inputTask, function (i, val) {
            var obj = {
                'idTask': $(val).val(),
                'idPermission': $(val).data('idPermission')
            }
            listTask.push(obj);
        });

        if (listTask.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Hãy thêm ít nhất 1 chức năng!',
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: "./gui/editRole.php",
            data: {
                'save-role': true,
                "id": id,
                "listTask": listTask
            },
            dataType: "html",
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thay đổi thành công',
                    text: '',
                });
                console.log(data)
                dateUpdate.html(data);
            }
        });
    })

    // delete role
    $(".container").on('click', '.info-role .table tbody .fa-trash', function () {
        var parent = $(this).closest('tr');
        Swal.fire({
            title: "Bạn chắc chắc muốn xóa?",
            text: "Xóa xong không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy bỏ"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Xóa thành công",
                    text: "",
                    icon: "success"
                });
                var id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: "./gui/infoRole.php",
                    data: {
                        "id": id,
                        'delete-role': true
                    },
                    dataType: "html",
                    success: function (response) {
                        console.log(response)
                        if (response == "success") {
                            Swal.fire({
                                title: "Xóa thành công!",
                                text: "",
                                icon: "success"
                            });
                            parent.remove();
                        }

                    }
                });
            }
        });


    })
});