// add collection 

$(document).ready(function () {

    var formdata = new FormData();
    $(".container").on('click', '#add-image', function (e) {
        e.preventDefault();
        $("#image-logo-input").click();
    })

    // add image 
    $(".container").on('change', '#image-logo-input', function () {
        var file = $(this).prop('files')[0];
        formdata.append("image", file);
    })


    $(".container").on('click', '#save-collection', function (e) {
        e.preventDefault();
        var nameCollection = $("#collection-name").val()
        if (nameCollection === "") {
            Swal.fire({
                icon: 'error',
                title: 'Tên không được để trống',
                text: 'Vui lòng nhập tên cho hãng',
            });
            return;
        }
        else {
            formdata.append("nameCollection", nameCollection)
        }
        if (formdata.getAll("image").length < 1) {
            Swal.fire({
                icon: 'error',
                title: 'Ảnh không được để trống',
                text: 'Vui lòng chọn logo',
            });
            return;
        }
        formdata.append("add-collection", true)
        $.ajax({
            type: "POST",
            url: "./gui/addCollection.php",
            data: formdata,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response)
                swal.fire({
                    icon: 'success',
                    title: 'Đã thêm danh mục',
                    text: '',
                });
                $("#collection-name").val('')
                $(".image .accordion").html('');
            }
        });

    })
});