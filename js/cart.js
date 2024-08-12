$(document).ready(function () {

    // encode URL
    function encodeJSON(json) {
        return btoa(encodeURIComponent(json));
    }

    // Calculate total
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

    // continue shopping
    $(".offcanvas-body").on("click", ".products .btn-continue-shopping", function () {
        $(".offcanvas").offcanvas("hide");
    })

    // delete cart
    $(".offcanvas-body").on("click", ".product-name i", function () {
        var id = $(this).data("id-product");
        var parent = $(this).closest(".product-item");
        var quantity = parent.find(".quantity input").val();
        var price = parent.find(".product-price span").text().replace(/đ|\./g, "");
        price = Number(price);
        quantity = Number(quantity);
        $.ajax({
            type: "POST",
            url: "./gui/carts.php",
            data: {
                'delete-product-cart': true,
                'idProduct': id,
                'quantity': quantity,
                'price': price
            },
            dataType: "html",
            success: function (response) {
                parent.remove();
                var total = CaculateTotal();
                $(".offcanvas-body .total .value").text(total.toLocaleString("de-DE") + "đ");
            }
        });
    });

    // select product
    $(".offcanvas-body").on("change", ".product-image input", function () {
        var total = CaculateTotal();
        $(".offcanvas-body .total .value").text(total.toLocaleString("de-DE") + "đ");
    })

    // change quantity
    $(".offcanvas-body").on("click", ".quantity button", function () {
        if ($(this).text() == "+" && Number($(this).prev().attr("max")) > $(this).prev().val()) {
            $(this).prev().val(Number($(this).prev().val()) + 1);
        }
        else if ($(this).text() == "-") {
            if ($(this).next().val() > 1) {
                $(this).next().val(Number($(this).next().val()) - 1);
            }
        }

        var parent = $(this).closest(".product-item");

        var quantity = Number(parent.find(".quantity input").val());
        var idProduct = parent.find(".product-name i").data("id-product");
        var price = parent.find(".product-price span").text().replace(/đ|\./g, "");
        price = Number(price);

        $.ajax({
            type: "POST",
            url: "./gui/carts.php",
            data: {
                'update-product-cart': true,
                'idProduct': idProduct,
                'quantity': quantity,
                'price': price
            },
            dataType: "html",
            success: function (response) {
                console.log(response);
            }
        });

        var total = CaculateTotal();
        $(".offcanvas-body .total .value").text(total.toLocaleString("de-DE") + "đ");
    })

    $(".offcanvas-body").on("change", ".quantity input", function () {
        var total = CaculateTotal();
        $(".offcanvas-body .total .value").text(total.toLocaleString("de-DE") + "đ");
    })

    // payment
    $(".offcanvas-body").on("click", ".total button", function () {
        var selected = $(".offcanvas-body .product-image input:checked");
        if (selected.length == 0) {
            Swal.fire({
                title: "Chưa chọn sản phẩm!!",
                text: "Vui lòng chọn sản phẩm để mua",
                icon: "warning",
                showConfirmButton: false
            });
            return;
        }
        var products = [];
        $.each(selected, function (i, val) {
            var parent = $(val).closest(".product-item");
            var id = parent.find(".product-name i").data("id-product");
            var size = parent.find(".product-size span").text().replace("Size: ", "");
            products.push({ id: id, size: size });
        });

        // console.log(products)

        window.location.href = "buyProduct.php?products=" + encodeJSON(JSON.stringify(products));
    })
});