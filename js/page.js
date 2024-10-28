import { getFilter } from "./filter.js";

const previousOrNextPage = (button, type) => {
  if (button.hasClass("disabled")) {
    return;
  }
  let pageCurrent = Number($(".pagination .page-item.active").text());

  pageCurrent = type == "previous" ? pageCurrent - 1 : pageCurrent + 1;

  $(".pagination .page-item").removeClass("active");
  $(".pagination .page-item").eq(pageCurrent).addClass("active");

  if (type == "previous") {
    if (pageCurrent === 1) {
      button.addClass("disabled");
    }
  }

  let totalPage = $(".pagination .page-item").length - 2;

  if (pageCurrent == totalPage) {
    $(".pagination .page-item.next").addClass("disabled");
  } else {
    $(".pagination .page-item.next").removeClass("disabled");
  }

  if (pageCurrent > 1) {
    $(".pagination .page-item.previous").removeClass("disabled");
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
      page: pageCurrent,
      designType: designType,
      idBrand: idBrand,
      queryOrder: obj.queryOrder,
    },
    dataType: "html",
    success: function (response) {
      $(".show-product").html(response);
    },
  });
};

export { previousOrNextPage };
