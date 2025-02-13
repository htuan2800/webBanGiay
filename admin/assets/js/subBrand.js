$(document).ready(function () {
    $(".container").on('click', '#add-subCollection', function (e) {
        e.preventDefault();
        var idCollection = $("#type").val()
        var subName = $("#sub_collection-name").val()
       
        if (subName === "") {
            Swal.fire({
                icon: 'error',
                title: 'Tên không được để trống',
                text: 'Vui lòng nhập tên thiết kế',
            });
            return;
        }



        $.ajax({
            type: "POST",
            url: "./gui/addSubCollection.php",
            data: {
                idCollection: idCollection,
                subName: subName,
                addSubBrand:true
            },
            success: function (response) {
                console.log(response)
                swal.fire({
                    icon: 'success',
                    title: 'Đã thêm thiết kế',
                    text: '',
                });
                $("#sub_collection-name").val('')
            }
        });

    })
});