$(document).ready(function () {

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


    $(".main-panel").on(
        "click",
        ".modal-content .modal-body .btn-save",
        function (e) {
            e.preventDefault();
            var idBrand = $(this).data("id");
            var oldName = $("#collection-name").data("name");
            var brandName = $("#collection-name").val()
            if (brandName === oldName) {
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

            $.ajax({
                type: "POST",
                url: "./gui/editCollection.php",
                data: {
                    "update-brand": true,
                    idBrand: idBrand,
                    brandName: brandName,

                },
                dataType: "html",
                success: function (response) {
                    console.log(response)

                    Swal.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công',

                    });
                    var row = $('i[data-id="' + idBrand + '"]').closest('tr')
                    row.find("td:eq(0)").text(brandName)
                    $(".main-panel .container .info-collection .modal").modal("hide");
                },
            });
        });
});
