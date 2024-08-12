$(document).ready(function () {

    // caculate total
    function CaculateTotal() {
        var product = $(".offcanvas-body .product-image input:checked")
        var total = 0;
        $.each(product, function (i, val) {
            var parent = $(val).closest(".product-item");
            var quantity = parent.find(".quantity input").val()
            var quantity = Number(quantity);
            var price = parent.find(".product-price span").data("price");
            total += quantity * price;
        });
        return total;
    }

    // swap slide product
    $(".image .slide img").click(function () {
        var src = $(this).attr("src");
        $(".image .slide img").removeClass("selected");
        $(this).addClass("selected");
        $(".image .main-image img").fadeOut(function () {
            $(this).attr("src", src).fadeIn();
        });
    })

    // swap slide product by button
    $(".image .button-swap i").click(function () {
        var imgCurent = $(".image .slide img.selected").attr("src");
        var index = 0;

        // get index selected
        $.each($(".image .slide img"), function (i, val) {
            if ($(val).hasClass("selected")) {
                index = i;
            }
        });

        // check prev or next
        if ($(this).hasClass("prev")) {
            if (index == 0) {
                index = $(".image .slide img").length - 1;
            } else {
                index--;
            }
        } else if ($(this).hasClass("next")) {
            if (index == $(".image .slide img").length - 1) {
                index = 0;
            } else {
                index++;
            }
        }

        // change slide
        $(".image .slide img").removeClass("selected");
        $(".image .slide img:eq(" + index + ")").addClass("selected");
        $(".image .main-image img").fadeOut(function () {
            $(this).attr("src", $(".image .slide img.selected").attr("src")).fadeIn();
        });
    })

    // swap size
    $(".container-fluid.detail-product .size button").click(function () {
        $(".container-fluid.detail-product .size button").removeClass("selected");
        $(this).addClass("selected");
        var quantity = $(this).data("quantity");
        $(".container-fluid.detail-product .quantity input").attr("max", quantity);
        $(".container-fluid.detail-product .quantity input").val(1);
        if (quantity == 0) {
            $(".container-fluid.detail-product .status span").text("Hết hàng");
            $(".container-fluid.detail-product .status span").addClass("Out-of-Stock");
            $(".container-fluid.detail-product .quantity input").val(0);
        }
        else {
            text = "Còn " + quantity + " sản phẩm";
            $(".container-fluid.detail-product .status span").text(text);
            $(".container-fluid.detail-product .status span").removeClass("Out-of-Stock");
        }
    });

    // change quantity
    $(".container-fluid.detail-product .quantity button").click(function () {
        var value = $(".container-fluid.detail-product .quantity input").val();
        var max = $(".container-fluid.detail-product .quantity input").attr("max");
        max = Number(max);
        if ($(this).hasClass("btn-plus")) {
            if (value < max) {
                value++;
            }
        }
        else if ($(this).hasClass("btn-minus")) {
            if (value > 1) {
                value--;
            }
        }
        $(".container-fluid.detail-product .quantity input").val(value);
    });

    $(".container-fluid.detail-product .quantity input").change(function (e) {
        var value = $(this).val();
        var max = $(this).attr("max");
        if (value === "") {
            value = 1;
        }
        else if (value > max) {
            value = max;
        }
        $(this).val(value);
    });

    $('.container-fluid.detail-product .quantity input').on('keypress', function (e) {
        var charCode = (e.which) ? e.which : e.keyCode;

        if (charCode < 48 || charCode > 57) {
            e.preventDefault();
        }
    });

    $('.container-fluid.detail-product .quantity input').on('paste', function (e) {
        var clipboardData = e.originalEvent.clipboardData.getData('text');
        if (!$.isNumeric(clipboardData)) {
            e.preventDefault();
        }
    });

    // add to cart
    $(".container-fluid.detail-product .btn-cart").click(function () {
        var status = $(".container-fluid.detail-product .status span").text();
        if (status === "Hết hàng") {
            Swal.fire({
                title: "Mặc hàng hiện tại đã hết!",
                text: "Vui lòng chọn sản phẩm khác",
                icon: "warning",
            });
            return;
        }

        var url = new URLSearchParams(window.location.search);
        var id = url.get("idProduct");
        var size = $(".container-fluid.detail-product .size button.selected").text();
        var quantity = $(".container-fluid.detail-product .quantity input").val();
        if ($(".container-fluid.detail-product .price-and-star span").length == 2) {
            var price = $(".container-fluid.detail-product .price-and-star span.current-price").text().replace(/đ|\./g, "");
        }
        else {
            var price = $(".container-fluid.detail-product .price-and-star span").text().replace(/đ|\./g, "");
        }
        price = Number(price);

        $.ajax({
            type: "POST",
            url: "./gui/carts.php",
            data: {
                'add-cart': true,
                'idProduct': id,
                'size': size,
                'quantity': quantity,
                'price': price
            },
            dataType: "html",
            success: function (response) {
                console.log(response);
                if (response === "fail") {
                    Swal.fire({
                        title: "Bạn chưa đăng nhập!",
                        text: "Vui lòng đăng nhập hoặc tạo tài khoản để mua hàng",
                        icon: "warning",
                    });
                }
                else {
                    Swal.fire({
                        title: "Thêm thành công",
                        text: "",
                        icon: "success",
                    });
                    $(".offcanvas-body").html(response);
                }
            }
        });
    });

    // buy now
    $(".container-fluid.detail-product .btn-buy").click(function () {
        var url = new URLSearchParams(window.location.search);
        var id = url.get("idProduct");
        var size = $(".container-fluid.detail-product .size button.selected").text();
        var quantity = $(".container-fluid.detail-product .quantity input").val();
        if ($(".container-fluid.detail-product .price-and-star span").length == 2) {
            var price = $(".container-fluid.detail-product .price-and-star span.current-price").text().replace(/đ|\./g, "");
        }
        else {
            var price = $(".container-fluid.detail-product .price-and-star span").text().replace(/đ|\./g, "");
        }
        price = Number(price);
        $.when(
            $.ajax({
                type: "POST",
                url: "./gui/carts.php",
                data: {
                    'add-cart': true,
                    'idProduct': id,
                    'size': size,
                    'quantity': quantity,
                    'price': price
                },
                dataType: "html",
            })
        ).done(function (data) {
            if (data === "fail") {
                Swal.fire({
                    title: "Bạn chưa đăng nhập",
                    text: "Vui lý đăng nhập hoặc tạo tài khoản để mua hàng",
                    icon: "warning",
                });
            }
            else {
                $(".offcanvas-body").html(data);
                $(".offcanvas-body input[type='checkbox']:first").prop("checked", true);
                var total = CaculateTotal();
                $(".offcanvas-body .total .value").text(total.toLocaleString("de-DE") + "đ");
                $(".offcanvas").offcanvas("show");
            }
        })
    });
});