import { previousOrNextPage } from "./page.js";
import { getFilter } from "./filter.js";

$(document).ready(function () {
  // move filter moblie
  $(window).resize(function () {
    if ($(window).width() < 992) {
      $(".filter-lg .filter").appendTo(
        ".offcanvas.offcanvas-start .offcanvas-body"
      );
    } else {
      $(".offcanvas.offcanvas-start .offcanvas-body .filter").appendTo(
        ".filter-lg"
      );
    }
  });

  // swap page
  $(document).on(
    "click",
    ".pagination .page-item:not(.previous):not(.next)",
    function (e) {
      e.preventDefault();
      var pageCurrent = $(".pagination .page-item.active").text();
      $(".pagination .page-item").removeClass("active");
      $(this).addClass("active");
      var page = $(this).text();
      if (pageCurrent == page) {
        return;
      }

      let totalPage = $(".pagination .page-item").length - 2;

      if (page > 1) {
        $(".pagination .page-item.previous").removeClass("disabled");
      } else {
        $(".pagination .page-item.previous").addClass("disabled");
      }
      if (page == totalPage) {
        $(".pagination .page-item.next").addClass("disabled");
      } else {
        $(".pagination .page-item.next").removeClass("disabled");
      }

      var designType = new URLSearchParams(window.location.search).get(
        "designType"
      );
      var idBrand = new URLSearchParams(window.location.search).get("idBrand");

      let obj = getFilter();

      $.ajax({
        type: "GET",
        url: "./database/ajaxProducts.php",
        data: {
          page: page,
          designType: designType,
          idBrand: idBrand,
          queryOrder: obj.queryOrder,
        },
        dataType: "html",
        success: function (response) {
          $(".show-product").html(response);
        },
      });
    }
  );

  //   previous page
  $(".pagination").on("click", ".page-item.previous", function (e) {
    e.preventDefault();
    previousOrNextPage($(this), "previous");
  });

  //   next page
  $(".pagination").on("click", ".page-item.next", function (e) {
    e.preventDefault();
    previousOrNextPage($(this), "next");
  });

  //   filter sort product
  $(".filter-nav").on("change", "#sort-product", function () {
    let obj = getFilter();

    var designType = new URLSearchParams(window.location.search).get(
      "designType"
    );
    let querySize = "";
    var idBrand = new URLSearchParams(window.location.search).get("idBrand");

    $(".pagination .page-item").removeClass("active");
    $(".pagination .page-item").eq(1).addClass("active");
    $(".pagination .page-item.previous").addClass("disabled");
    $(".pagination .page-item.next").removeClass("disabled");

    if (obj.querySize.length !== 0) {
      for (let i = 0; i < obj.querySize.length; i++) {
        if (i === obj.querySize.length - 1) {
          querySize += obj.querySize[i];
        } else {
          querySize += obj.querySize[i] + " OR ";
        }
      }
      querySize = "(" + querySize + ")";
    }

    $.ajax({
      type: "GET",
      url: "./database/ajaxProducts.php",
      data: {
        page: 1,
        designType: designType,
        idBrand: idBrand,
        queryOrder: obj.queryOrder,
        queryPrice: obj.queryPrice,
        querySize: querySize,
      },
      dataType: "html",
      success: function (response) {
        $(".show-product").html(response);
      },
    });
  });

  //   filter other
  $(".filter").on("change", "input", function () {
    let filter = getFilter();
    var designType = new URLSearchParams(window.location.search).get(
      "designType"
    );
    let querySize = "";
    var idBrand = new URLSearchParams(window.location.search).get("idBrand");

    $(".pagination .page-item").removeClass("active");
    $(".pagination .page-item").eq(1).addClass("active");
    $(".pagination .page-item.previous").addClass("disabled");
    $(".pagination .page-item.next").removeClass("disabled");

    if (filter.querySize.length !== 0) {
      for (let i = 0; i < filter.querySize.length; i++) {
        if (i === filter.querySize.length - 1) {
          querySize += filter.querySize[i];
        } else {
          querySize += filter.querySize[i] + " OR ";
        }
      }
      querySize = "(" + querySize + ")";
    }

    $.ajax({
      type: "GET",
      url: "./database/ajaxProducts.php",
      data: {
        page: 1,
        designType: designType,
        idBrand: idBrand,
        queryOrder: filter.queryOrder,
        queryPrice: filter.queryPrice,
        querySize: querySize,
      },
      dataType: "html",
    }).then((response) => {
      // console.log(response);
      $(".show-product").html(response);
    });

    $.ajax({
      type: "GET",
      url: "./gui/paging.php",
      data: {
        idBrand: idBrand,
        designType: designType,
        queryPrice: filter.queryPrice,
        querySize: querySize,
      },
      dataType: "html",
    }).then((response) => {
      // console.log(response);
      $(".paging").html(response);
    });
  });

  // filter size
  $(".filter").on("change", ".size input", function () {
    let filter = getFilter();
    var designType = new URLSearchParams(window.location.search).get(
      "designType"
    );
    let querySize = "";
    var idBrand = new URLSearchParams(window.location.search).get("idBrand");

    $(".pagination .page-item").removeClass("active");
    $(".pagination .page-item").eq(1).addClass("active");
    $(".pagination .page-item.previous").addClass("disabled");
    $(".pagination .page-item.next").removeClass("disabled");

    if (filter.querySize.length !== 0) {
      for (let i = 0; i < filter.querySize.length; i++) {
        if (i === filter.querySize.length - 1) {
          querySize += filter.querySize[i];
        } else {
          querySize += filter.querySize[i] + " OR ";
        }
      }
      querySize = "(" + querySize + ")";
    }

    $.ajax({
      type: "GET",
      url: "./database/ajaxProducts.php",
      data: {
        page: 1,
        designType: designType,
        idBrand: idBrand,
        queryOrder: filter.queryOrder,
        queryPrice: filter.queryPrice,
        querySize: querySize,
      },
      dataType: "html",
    }).then((response) => {
      $(".show-product").html(response);
    });

    $.ajax({
      type: "GET",
      url: "./gui/paging.php",
      data: {
        idBrand: idBrand,
        designType: designType,
        queryPrice: filter.queryPrice,
        querySize: querySize,
      },
      dataType: "html",
    }).then((response) => {
      // console.log(response);
      $(".paging").html(response);
    });
  });
});
