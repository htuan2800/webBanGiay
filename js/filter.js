const getFilter = () => {
  let queryOrder = $("#sort-product").val();
  let queryPrice = "";

  if ($(".filter .price input:checked").length > 0) {
    $.map(
      $(".filter .price input:checked"),
      function (elementOrValue, indexOrKey) {
        queryPrice += $(elementOrValue).val() + " OR ";
      }
    );
  }

  if (queryPrice.length > 0) {
    queryPrice = "(" + queryPrice.slice(0, queryPrice.length - 3) + ")";
  }

  return {
    queryOrder: queryOrder,
    queryPrice: queryPrice,
  };
};

export { getFilter };
