$(document).ready(function () {
    // move filter moblie
    $(window).resize(function () {
        if ($(window).width() < 992) {
            $(".filter-lg .filter").appendTo(".offcanvas.offcanvas-start .offcanvas-body");
        }
        else {
            $(".offcanvas.offcanvas-start .offcanvas-body .filter").appendTo(".filter-lg");
        }
    })

    // swap page
    $(document).on("click", ".pagination .page-item:not(.previous):not(.next)", function (e) {
        e.preventDefault();
        var pageCurrent = $(".pagination .page-item.active").text();
        $(".pagination .page-item").removeClass("active");
        $(this).addClass("active");
        var page = $(this).text();
        if (pageCurrent == page) {
            return;
        }
        var designType = new URLSearchParams(window.location.search).get("designType");
        var idBrand = new URLSearchParams(window.location.search).get("idBrand");
        $.ajax({
            type: "GET",
            url: "./database/ajaxProducts.php",
            data: {
                'page': page,
                'designType': designType,
                'idBrand': idBrand
            },
            dataType: "html",
            success: function (response) {
                $(".show-product").html(response);
            }
        })


    })
});