$(document).ready(function () {
    $(".container").on('change', '#brand-rc', function () {
        var idBrand = $(this).val();
        $.ajax({
            type: "POST",
            url: "./gui/importProducts.php",
            data: {
                "idBrand": idBrand,
                "get-sub-brand": true,
                "get-products": true
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                // cap nhat subBrand
                $("#design-type-rc").empty();
                $.each(response.subBrand, function (key, value) {
                    $("#design-type-rc").append("<option value='" + value['subBrandName'] + "'>" + value['subBrandName'] + "</option>");
                });
                //cap nhat ten san pham
                $("#name-product-rc").empty();
                $.each(response.products, function (key, value) {
                    $("#name-product-rc").append("<option value='" + value['idProduct'] + "' data-name='" + value['productName'] + "'>" + value['productName'] + "</option>");
                });
                //cap nhat size va ton kho
                $("#product-size").empty();
                $("#inventory-product").empty();
                $('#inventory-product').val(response.size[0]['quantityRemain']);
                $.each(response.size, function (key, value) {
                    $("#product-size").append("<option value='" + value['size'] + "' data-remain='" + value['quantityRemain'] + " '>" + value['size'] + "</option>");
                });
            }
        });
    });

    $(".container").on('change', '#design-type-rc', function () {
        var subBrand = $(this).val();
        $.ajax({
            type: "POST",
            url: "./gui/importProducts.php",
            data: {
                "subBrand": subBrand,
                "get-products": true
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $("#name-product-rc").empty();
                $.each(response.products, function (key, value) {
                    $("#name-product-rc").append("<option value='" + value['idProduct'] + "' data-name='" + value['productName'] + "'>" + value['productName'] + "</option>");
                });
                //cap nhat size va ton kho
                $("#product-size").empty();
                $("#inventory-product").empty();
                $('#inventory-product').val(response.size[0]['quantityRemain']);
                $.each(response.size, function (key, value) {
                    $("#product-size").append("<option value='" + value['size'] + "' data-remain='" + value['quantityRemain'] + " '>" + value['size'] + "</option>");
                });
            }
        });
    });
    $(".container").on('change', '#name-product-rc', function () {
        var idProduct = $(this).val();
        $.ajax({
            type: "POST",
            url: "./gui/importProducts.php",
            data: {
                "idProduct": idProduct,
                "get-size": true
            },
            dataType: "json",
            success: function (response) {
                console.table(response);
                $("#product-size").empty();
                $("#inventory-product").empty();
                $('#inventory-product').val(response.size[0]['quantityRemain']);
                $.each(response.size, function (key, value) {
                    $("#product-size").append("<option value='" + value['size'] + "' data-remain='" + value['quantityRemain'] + " '>" + value['size'] + "</option>");
                });
            }
        });
    });
    $(".container").on('change', '#product-size', function () {
        var remainQuantity = $(this).find(":selected").data("remain");
        $("#inventory-product").empty();
        $('#inventory-product').val(remainQuantity);
    });
    // add product to receipt
    $(".container").on('click', '#add-receipt', function (e) {
        e.preventDefault();
        var price = $("#product-price").val();
        var quantity = $("#quantity-import").val();
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
        if (quantity === "") {
            Swal.fire({
                icon: 'error',
                title: 'Số lượng nhập không được để trống!',
                text: 'Xin vui nhập số lượnglượng',
            });
            return;
        }
        if (isNaN(quantity) || quantity < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Dữ liệu không hợp lệ!',
                text: 'Số lượng phải là số nguyên dươngdương',
            });
            return;
        }
        var idProduct = $('#name-product-rc').val();
        var size = $('#product-size').val();
        var name = $('#name-product-rc').find(":selected").data("name")
        var formData = new FormData();
        formData.append("addReceipt", true);
        formData.append("idProduct", idProduct);
        formData.append("name", name);
        formData.append("size", size);
        formData.append("price", price);
        formData.append("quantity", quantity);
        $.ajax({
            type: "POST",
            url: "./gui/importProducts.php",
            data:
                formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.message == "update") {
                    updateQuantityByDataId(response.product.id + '-' + response.product.size + "-" + response.product.price, response.product.quantity, response.product.total);
                    swal.fire({
                        icon: 'success',
                        title: 'Đã thêm sản phẩm vào danh sách nhập',
                        text: '',
                    });
                    $('#total-receipt').val(new Intl.NumberFormat('vi-VN').format(response.total) + "đ");

                }
                else {
                    $("#product-price").val('');
                    $("#quantity-import").val('');
                    var newRow = $("<tr>");
                    var td = $("<td>")
                    var actionTd = $("<td><div class='action'></div></td>");
                    actionTd.find('.action').append('<i class="fa fa-trash delete-btn" id="delete-icon" data-id="' + response.product.id + '-' + response.product.size + "-" + response.product.price + '"></i> ');
                    newRow.append("<td>" + response.product.name + "</td>");
                    newRow.append("<td><img src=" + '.' + response.product.img + "  width='50' height='50'></td>");
                    newRow.append("<td>" + response.product.size + "</td>");
                    newRow.append("<td>" + new Intl.NumberFormat('vi-VN').format(response.product.price) + "đ" + "</td>");
                    newRow.append("<td>" + response.product.quantity + "</td>");
                    newRow.append("<td>" + new Intl.NumberFormat('vi-VN').format(response.product.total) + "đ" + "</td>");
                    newRow.append(actionTd);
                    $("tr td[colspan='7']").first().closest("tr").remove();
                    $(".table-responsive table tbody").append(newRow);
                    $('#total-receipt').val(new Intl.NumberFormat('vi-VN').format(response.total) + "đ");
                    swal.fire({
                        icon: 'success',
                        title: 'Đã thêm sản phẩm vào danh sách nhập',
                        text: '',
                    });
                }
            }
        });
    });
    function updateQuantityByDataId(dataId, newQuantity, newTotal) {
        let row = $('i[data-id="' + dataId + '"]').closest('tr');

        if (row.length) {
            row.find('td:eq(4)').text(newQuantity);
            row.find('td:eq(5)').text(new Intl.NumberFormat('vi-VN').format(newTotal) + "đ");
        } else {
            console.log("Không tìm thấy sản phẩm trong bảng.");
        }
    }
    // delete product in receipt
    $(".container").on("click", "#delete-icon", function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Chắc chắn hủy nhập sản phẩm?",
            text: "Xóa xong không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa sản phẩm",
            cancelButtonText: "Hủy bỏ",
        }).then((result) => {
            if (result.isConfirmed) {
                var index = $(this).data("id");
                var row = $(this).closest("tr");
                $.ajax({
                    type: "POST",
                    url: "./gui/importProducts.php",
                    data: {
                        'index': index,
                        'deleteReceipt': true,
                    },
                    dataType: "json",

                    success: function (response) {
                        if (response.message === "success") {
                            Swal.fire({
                                title: "Đã xóa sản phẩm khỏi danh sách nhập!",
                                text: "",
                                icon: "success",
                            });
                            row.remove();
                            $('#total-receipt').val(new Intl.NumberFormat('vi-VN').format(response.total) + "đ");

                            if ($(".table-responsive table tbody tr").length === 0) {
                                $(".table-responsive table tbody").append('<tr><td colspan="7">Chưa có mặt hàng nào</td></tr>');
                            }
                        } else {
                            alert("Xóa thất bại!");
                        }
                    }
                });
            }
        });
    });

    $(".container").on("click", "#add-list-receipt", function (e) {
        e.preventDefault();
        var isEmpty = $(".table-responsive table tbody td[colspan='7']").length > 0;
        if (isEmpty) {
            Swal.fire({
                icon: 'error',
                title: 'Chưa có sản phẩm nào trong danh sách nhập!',
                text: 'Hãy thêm sản phẩm cần nhập',
            });
            return;
        }
        else {
            var supplier = $("#supplier").val();
            $.ajax({
                type: "POST",
                url: "./gui/importProducts.php",
                data: {
                    'idSupplier': supplier,
                    'add-list-receipt': true
                },
                dataType: "html",
                success: function (response) {
                    console.log(response);
                    if (response === "Thêm thành công") {
                        $(".table-responsive table tbody").empty();
                        $(".table-responsive table tbody").append('<tr><td colspan="7">Chưa có mặt hàng nào</td></tr>');
                        $('#total-receipt').val('0' + "đ");
                        $("#supplier option:first").prop("selected", true);
                        swal.fire({
                            icon: 'success',
                            title: 'Nhập hàng thành công!',
                            text: '',
                        });

                    }
                }
            });
        }
    });



});
