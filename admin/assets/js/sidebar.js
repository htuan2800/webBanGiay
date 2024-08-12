$(document).ready(function () {
    $(".sidebar .sidebar-wrapper .nav-item .collapse a").click(function (e) {
        e.preventDefault();
        var href = $(this).attr("href");
        $(".sidebar .sidebar-wrapper .nav-item").removeClass("active");
        $(this).parent().addClass("active");
        $(".main-panel .container").load(href);
    })
});