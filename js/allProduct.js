$(document).ready(function () {
  $(".paging-all-product").on("click", ".page-item", function (e) {
    e.preventDefault();
    let pageCurrent = $(this).text();

    $(".paging-all-product .page-item").removeClass("active");

    $(this).addClass("active");

    $.ajax({
      type: "GET",
      url: "./database/ajaxAllProduct.php",
      data: {
        page: pageCurrent,
      },
      dataType: "html",
      success: function (response) {
        console.log(response);
        $(".show-product").html("");
        $(".show-product").html(response);
      },
    });
  });
});
