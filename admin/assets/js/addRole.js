$(document).ready(function () {

    // add role
    $(".container").on('click', '#add-role', function () {
        var name = $("#role-name").val();

        if (name === "") {
            Swal.fire({
                icon: 'error',
                title: 'Trường tên đang trống!',
                text: 'Xin vui nhập tên vai trò',
            });
            return;
        }

        var listTask = [];
        var inputTask = $(".permissiongroup input[type='checkbox']:checked");

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
                text: '',
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: "./gui/addRole.php",
            data: {
                'add-role': true,
                'name': name,
                'listTask': listTask
            },
            dataType: "html",
            success: function (response) {
                if (response !== "") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thêm thành công',
                        text: '',
                    });
                }
            }
        })

    })
});