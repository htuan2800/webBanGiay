$(document).ready(function () {
    // show edit
    $(".main-panel").on(
        "click",
        ".container .info-collection tbody .fa-edit",
        function (e) {
            e.preventDefault();

            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "./gui/editCollection.php",
                data: {
                    id: id,
                    "edit-collection": true,
                },
                dataType: "html",
                success: function (response) {
                    $(".main-panel .container .info-collection .modal-dialog").html(
                        response
                    );
                    $(".main-panel .container .info-collection .modal").modal("show");
                },
            });
        }
    );


    // edit 
    var data = new FormData()
    $(".main-panel").on(
        "click",
        ".modal-content .modal-body .btn-save",
        function (e) {
            e.preventDefault();
            var idBrand = $(this).data("id");
            var oldName = $("#collection-name").data("name");
            var brandName = $("#collection-name").val()
            if (brandName === oldName && data.getAll("img").length < 1) {
                Swal.fire({
                    icon: 'info',
                    title: 'Không có gì để cập nhật',
                });
                return
            }
            if (brandName === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Tên danh mục không được để trống!',
                    text: 'Xin vui nhập tên danh mục',
                });
                return
            }
            data.append("brandName", brandName);
            data.append("idBrand", idBrand);
            data.append("update-brand", true);



            $.ajax({
                type: "POST",
                url: "./gui/editCollection.php",
                data: data,
                processData: false,
                contentType: false,
                dataType: "html",
                success: function (response) {
                    console.log(response)

                    Swal.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công',

                    });
                    $.ajax({
                        type: "POST",
                        url: "./gui/infoCollection.php",
                        dataType: "html",
                        success: function (response) {
                            $(".main-panel .container").html(response);

                        },
                    });
                    $(".main-panel .container .info-collection .modal").modal("hide");
                },
            });
        });



    // change image


    $(".main-panel").on(
        "click",
        ".modal-content .modal-body .btn-update-logoImage ",
        function (e) {
            e.preventDefault();
            var input = $(this).parent().find("input");
            input.click();

        })

    $(".main-panel").on(
        "change",
        ".modal-content .modal-body input[type=file] ",
        function (e) {
            var file = this.files[0];
            if (!file) return;

            const blob = new Blob([file], { type: file.type }); // Chuyển file thành BLOB
            data.append('img', file)

            // Hiển thị ảnh (Chuyển BLOB thành URL)
            const imageUrl = URL.createObjectURL(blob);
            $(this).parent().parent().find("img").attr("src", imageUrl);

        })

});
