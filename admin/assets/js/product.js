$(document).ready(function () {

    // load js
    $.when(
        $.getScript("../js/validate.js")
    ).done(function () { });

    // show product
    $(".main-panel").on('change', '.container .info-product .product-tools .show select', function () {
        var value = $(this).val();
        $.ajax({
            type: "POST",
            url: "./gui/tableProduct.php",
            data: {
                "itemOfPage": value
            },
            dataType: "html",
            success: function (response) {
                $(".container .info-product .table-product").html(response);
                if ($('.container .info-product .pagination li').length - 2 == 1) {
                    $('.container .info-product .pagination .next').addClass('disabled');
                }
            }
        })
    });

    // Delete product
    $(".main-panel").on('click', '.container .info-product tbody .fa-trash', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        Swal.fire({
            title: "Bạn có muốn xóa sản phẩm?",
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
                    title: "Đã xóa sản phẩm",
                    text: "",
                    icon: "success"
                });
                $(this).closest('tr').remove();
                $.ajax({
                    type: "POST",
                    url: "./gui/tableProduct.php",
                    data: {
                        "id": id,
                        'delete-product': true
                    },
                    dataType: "html",
                    success: function (response) {
                        console.log(response)
                        if ($('.info-product tbody tr').length == 0) {
                            $.ajax({
                                type: "POST",
                                url: "./gui/infoProduct.php",
                                dataType: "html",
                                success: function (response) {
                                    $('.main-panel .container').html(response);
                                }
                            });
                        }
                    }
                });

            }
        });
    })

    // show edit product
    $(".main-panel").on('click', '.container .info-product tbody .fa-edit', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: {
                "id": id,
                'edit-product': true
            },
            dataType: "html",
            success: function (response) {
                $('.main-panel .container .info-product .modal-dialog').html(response);
                $('.main-panel .container .info-product .modal').modal('show');
            }
        });
    })

    // swap page
    function swapPage(page) {
        $.ajax({
            type: "POST",
            url: "./gui/tableProduct.php",
            data: {
                "page": page,
                'itemOfPage': $('.container .info-product .product-tools .show select').val()
            },
            dataType: "html",
            success: function (response) {
                $(".container .info-product .table-product").html(response);
                $('.container .info-product .pagination li').removeClass('active');
                for (var i = 0; i < $('.container .info-product .pagination li').length; i++) {
                    if ($('.container .info-product .pagination li').eq(i).text() == page) {
                        $('.container .info-product .pagination li').eq(i).addClass('active');
                    }
                }
                if (page == 1) {
                    $('.container .info-product .pagination .previous').addClass('disabled');
                } else {
                    $('.container .info-product .pagination .previous').removeClass('disabled');
                }
                if (page == $('.container .info-product .pagination li').length - 2) {
                    $('.container .info-product .pagination .next').addClass('disabled');
                } else {
                    $('.container .info-product .pagination .next').removeClass('disabled');
                }
            }
        })
    }

    $(".main-panel").on('click', '.container .info-product .pagination a', function (e) {
        e.preventDefault();
        var page = $(this).text();
        swapPage(page);
    })

    // previous page
    $(".main-panel").on('click', '.container .info-product .pagination .previous', function (e) {
        e.preventDefault();
        var pageCurrent = $('.container .info-product .pagination li.active').text();
        if (pageCurrent == 1) {
            return;
        }
        var page = Number(pageCurrent) - 1;
        swapPage(page);
    })

    // next page
    $(".main-panel").on('click', '.container .info-product .pagination .next', function (e) {
        e.preventDefault();
        var pageCurrent = $('.container .info-product .pagination li.active').text();
        var page = Number(pageCurrent) + 1;
        swapPage(page);
    })

    // change brand on edit product
    $(".main-panel").on('change', '.container .info-product .modal-dialog #brand', function () {
        var value = $(this).val();
        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: {
                "idBrand": value,
                'get-sub-brand': true
            },
            dataType: "json",
            success: function (response) {
                $(".container .info-product .modal-dialog #type option").remove();
                $.each(response, function (i, val) {
                    $(".container .info-product .modal-dialog #type").append('<option value="' + val['subBrandName'] + '">' + val['subBrandName'] + '</option>');
                });

                var idProduct = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');
                var designType = $(".container .info-product .modal-dialog #type option:selected").val()

                $.ajax({
                    type: "POST",
                    url: "./gui/editProduct.php",
                    data: {
                        'update-brand': true,
                        'idProduct': idProduct,
                        'designType': designType,
                        'idBrand': value
                    },
                    dataType: "html",
                    success: function (response) {
                    }
                });

            }
        });
    })

    $(".main-panel").on('change', '.container .info-product .modal-dialog #type', function () {
        var idProduct = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');
        var idBrand = $('.container .info-product .modal-dialog #brand').val()
        var designType = $(this).val()

        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: {
                'update-brand': true,
                'idProduct': idProduct,
                'idBrand': idBrand,
                'designType': designType
            },
            dataType: "html",
            success: function (response) {
                console.log(response)
            }
        });
    })

    // delete image product
    $(".main-panel").on('click', '.container .info-product .modal-dialog .btn-delete-image', function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Chắc chắn xóa ảnh?",
            text: "Xóa xong không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa ảnh",
            cancelButtonText: "Hủy bỏ"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Đã xóa ảnh!",
                    text: "",
                    icon: "success"
                });
                var id = $(this).data('id');
                var parent = $(this).closest('.accordion-item');
                parent.remove();
                $.ajax({
                    type: "POST",
                    url: "./gui/editProduct.php",
                    data: {
                        "id-image": id,
                        'delete-image': true
                    },
                    dataType: "html",
                    success: function (response) {
                        console.log(response)
                        var parent = $(this).closest('.accordion-item');
                        parent.remove();
                    }
                });
            }
        });

    })

    // update image product
    $(".main-panel").on('click', '.container .info-product .modal-dialog .btn-update-image', function (e) {
        e.preventDefault();
        var input = $(this).parent().find('input');
        input.click();
    })

    $(".main-panel").on('change', '.container .info-product .modal-dialog .input-image', function (e) {
        var file = this.files[0];
        var idImage = $(this).data('id');
        var image = $(this).closest('.accordion-item').find('img');

        var formData = new FormData();
        formData.append('image', file);
        formData.append('id-image', idImage);
        formData.append('update-image', true);

        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                image.attr('src', "." + response);
            }
        });

    })

    // add image product
    $(".main-panel").on('click', '.container .info-product .modal-dialog .add-image', function (e) {
        e.preventDefault();
        var idProduct = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');
        $(this).parent().find('input').click();
    })

    $(".main-panel").on('change', '.container .info-product .modal-dialog #add-image', function (e) {
        e.preventDefault();

        var idProduct = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');
        var file = this.files[0];

        var formData = new FormData();
        formData.append('image', file);
        formData.append('id-product', idProduct);
        formData.append('add-image', true);

        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                console.log(response)
                var i = $('.container .info-product .modal-dialog .accordion .accordion-item').length + 1;
                var headingId = 'flush-heading' + i;
                var collapseId = 'flush-collapse' + i;
                var content = `
                <div class="accordion-item">
                    <h2 class="accordion-header" id="${headingId}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#${collapseId}" aria-expanded="false"
                            aria-controls="${collapseId}">
                            Ảnh ${i}
                        </button>
                    </h2>
                    <div id="${collapseId}" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <img src="${"." + response['image']}" alt="" class="img-fluid" />
                            <div class="btn-tools">
                                <button class="btn btn-danger btn-delete-image"
                                    data-id="${response['id']}">Xóa ảnh</button>
                                <button class="btn btn-warning btn-update-image">Sửa ảnh</button>
                                <input type="file" class="input-image" accept="image/*" name="image" id=""
                                    style="display: none;" data-id="${response['id']}">
                            </div>
                        </div>
                    </div>
                </div>
                `

                $('.container .info-product .modal-dialog .accordion').append(content);
            }
        });
    })

    // change name or price
    $(".main-panel").on('blur', '.modal-dialog #product-name', function () {
        var name = $(this).val();
        if (name === "") {
            Swal.fire({
                icon: 'error',
                title: 'Không được để trống!',
                text: 'Xin vui lòng nhập tên sản phẩm!',
                showConfirmButton: false
            });
            $(this).focus()
            return;
        }

        var idProduct = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');

        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: {
                'update-name-and-price': true,
                'name': name,
                'idProduct': idProduct,
                'price': ''
            },
            dataType: "html",
            success: function (response) {
                console.log(response)
            }
        });
    });


    $(".main-panel").on('click', '.modal-dialog #save-price', function () {
        var price = $('.modal-dialog #price').val();

        if (price === "") {
            Swal.fire({
                icon: 'error',
                title: 'Không để trống!',
                text: 'Xin vui lòng nhập dữ liệu vào',
                showConfirmButton: false
            });
            $('.modal-dialog #price').focus()
            return;
        }

        if (isNaN(price)) {
            Swal.fire({
                icon: 'error',
                title: 'Giá phải là số!',
                text: 'Vui lòng nhập lại',
                showConfirmButton: false
            });
            $('.modal-dialog #price').focus()
            return;
        }

        var name = $('.modal-dialog #product-name').val();
        var idProduct = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');
        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: {
                'update-name-and-price': true,
                'name': name,
                'idProduct': idProduct,
                'price': price
            },
            dataType: "html",
            success: function (response) {
                Swal.fire({
                    title: "Cập nhật giá thành công",
                    text: "",
                    icon: "success"
                });
            }
        });
    })

    // add size
    $(".main-panel").on('click', '.modal-dialog .add-size', function (e) {
        e.preventDefault();
        $(this).css("display", "none");
        $(this).next().css("display", "block");
        $(this).next().focus();
    })

    $(".main-panel").on('blur', '.modal-dialog #add-size', function () {
        var size = $(this).val();

        if (size === "") {
            $(this).css("display", "none");
            $(this).prev().css("display", "block");
            return;
        }

        size = Number(size);

        if (isNaN(size)) {
            Swal.fire({
                icon: 'error',
                title: 'Size phải là số!',
                text: 'Vui này nhap lai',
                showConfirmButton: false
            });
            $(this).focus()
            return;
        }

        if (size <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Size không hợp lệ!',
                text: 'Vui lòng nhập lại',
                showConfirmButton: false
            });
            $(this).focus()
            return;
        }

        var options = $('.container .info-product .modal-dialog #select-size option');

        for (var i = 0; i < options.length; i++) {
            if (options[i].value == size) {
                return;
            }
        }

        var id = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');

        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: {
                'add-size': true,
                'size': size,
                'idProduct': id
            },
            dataType: "html",
            success: function (response) {

            }
        });

        $('.container .info-product .modal-dialog #select-size').prepend(
            `<option value="${size}" selected>${size}</option>`
        );

        $('.container .info-product .modal-dialog #quantity').val(0);

        $(this).css("display", "none");
        $(this).val("");
        $(this).prev().css("display", "block");
    })

    // delete size
    $(".main-panel").on('click', '.modal-dialog #delete-size', function (e) {
        e.preventDefault();
        var idProduct = $('.container .info-product .modal-dialog #quantity-sold').data('id-product');
        var size = $('.container .info-product .modal-dialog #select-size').val();

        $.ajax({
            type: "POST",
            url: "./gui/editProduct.php",
            data: {
                'delete-size': true,
                'size': size,
                'idProduct': idProduct
            },
            dataType: "html",
            success: function (response) {
                console.log(response)
                $('.container .info-product .modal-dialog #select-size option[value="' + size + '"]').remove();
                $('.container .info-product .modal-dialog #quantity').val(
                    $('.container .info-product .modal-dialog #select-size option:selected').data('quantity')
                );
            }
        });

        $(this).next().focus();
    })

    // change size
    $(".main-panel").on('change', '.container .info-product .modal-dialog #select-size', function () {
        var quantity = $(this).find('option:selected').data('quantity');
        $('.container .info-product .modal-dialog #quantity').val(quantity);
    })
});