$(document).ready(function () {
    // change brand
    $(".container").on('change', '#brand', function () {
        var idBrand = $(this).val();
        $.ajax({
            type: "POST",
            url: "./gui/addProduct.php",
            data: {
                "idBrand": idBrand,
                "get-sub-brand": true
            },
            dataType: "json",
            success: function (response) {
                console.table(response);
                $("#design-type option").remove();
                $.each(response, function (key, value) {
                    $("#design-type").append("<option value='" + value['subBrandName'] + "'>" + value['subBrandName'] + "</option>");
                });
            }
        });
    })

    // add size
    $(".container").on('click', '#add-size', function () {
        var size = $("#size-input").val();
        if (size === "") {
            Swal.fire({
                icon: 'error',
                title: 'Không có dữ liệu!',
                text: 'Xin vui lòng nhập vào size',
            });
            return;
        }
        if (isNaN(size) || size < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Dữ liệu không hợp lệ!',
                text: 'Size phải là số nguyên dương',
            });
            return;
        }
        var opt = "<option value='" + size + "' selected>" + size + "</option>";
        $("#product-size").prepend(opt);
        $("#size-input").val("");
    })

    // remove size
    $(".container").on('click', '#delete-size', function () {
        $("#product-size option:selected").remove();
    })

    // add image
    $(".container").on('click', '#add-image', function (e) {
        e.preventDefault();
        $("#image-input").click();
    })

    $(".container").on('change', '#image-input', function () {
        var file = $(this).prop('files')[0];
        var form = new FormData();
        var count = $(".image .accordion .accordion-item").length;
        form.append('image', file);
        form.append('add-image', true);
        form.append('count', count);

        $.ajax({
            type: "POST",
            url: "./gui/addProduct.php",
            img: form,
            processData: false,
            contentType: false,
            success: function (response) {
                console.table(response);
                var content = `
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#${"image-" + count}" aria-expanded="false"
                            aria-controls="${"image-" + count}">
                            Ảnh ${count + 1}
                        </button>
                    </h2>
                    <div id="${"image-" + count}" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <img src="${response}" alt="image" class="img-fluid">
                        </div>
                    </div>
                </div>
                `

                $(".image .accordion").append(content);
            }
        });
    })

    // add product
    $(".container").on('click', '#save-product', function (e) {
        e.preventDefault();

        // check product name
        var productName = $("#product-name").val();
        if (productName === "") {
            Swal.fire({
                icon: 'error',
                title: 'Tên sản phẩm không được để trống!',
                text: 'Xin vui nhập tên sản phẩm',
            });
            return;
        }
        var size = [];
        $("#product-size option").each(function () {
            size.push($(this).val());
        })

        console.table(size);

        // check size
        if (size.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Sản phẩm phải có ít nhất 1 size!',
                text: 'Hãy nhập 1 size cho sản phẩm',
            });
            return;
        }

        var price = $("#product-price").val();
        // check price
        if (price === "") {
            Swal.fire({
                icon: 'error',
                title: 'Giá không được để trống!',
                text: 'Xin vui nhập giá',
            });
            return;
        }
        if (isNaN(price) || price < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Dữ liệu không hợp lệ!',
                text: 'Giá phải là số nguyên dươngdương',
            });
            return;
        }

        var image = [];
        $(".image .accordion .accordion-item").each(function () {
            image.push($(this).find("img").attr("src"));
        });

        if (image.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Sản phẩm phải có ít nhất 1 hình ảnh!',
                text: 'Hãy thêm hình cho sản phẩm',
            });
            return;
        }

        var idBrand = $("#brand").val();
        var designType = $("#design-type").val();

        var formData = new FormData();
        formData.append("add-product", true);
        formData.append("name", productName);
        formData.append("size", JSON.stringify(size));
        formData.append("price", price);
        formData.append("image", JSON.stringify(image));
        formData.append("idBrand", idBrand);
        formData.append("designType", designType);

        $.ajax({
            type: "POST",
            url: "./gui/addProduct.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                swal.fire({
                    icon: 'success',
                    title: 'Đã thêm sản phẩm',
                    text: '',
                });
                $("#product-name").val('')
                $("#product-price").val('')
                $("#product-size option").remove();
                $(".image .accordion").html('');
            }
        });
    })
});