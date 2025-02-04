const rangeMin = 1000000;
const range = document.querySelector(".range-selected");
const rangeInput = document.querySelectorAll(".range-input input");
const labelMinPrice = $(".min-price-label");
const labelMaxPrice = $(".max-price-label");
let queryPrice = "";
rangeInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minRange = parseInt(rangeInput[0].value);
    let maxRange = parseInt(rangeInput[1].value);
    if (maxRange - minRange < rangeMin) {
      if (e.target.className === "min") {
        rangeInput[0].value = maxRange - rangeMin;
      } else {
        rangeInput[1].value = minRange + rangeMin;
      }
    } else {
      labelMinPrice.text(
        minRange
          .toLocaleString("vi-VN", { style: "currency", currency: "VND" })
          .replace("₫", "đ")
      );
      labelMaxPrice.text(
        maxRange
          .toLocaleString("vi-VN", { style: "currency", currency: "VND" })
          .replace("₫", "đ")
      );
      range.style.left = (minRange / rangeInput[0].max) * 100 + "%";

      range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";
      queryPrice = `CURRENTPRICE BETWEEN ${minRange} AND ${maxRange}`;
    }
  });
});

const getFilter = () => {
  let queryOrder = $("#sort-product").val();
  let querySize = $(".filter .size input:checked")
    .map(function () {
      return $(this).val();
    })
    .get();
  return {
    queryOrder: queryOrder,
    queryPrice: queryPrice,
    querySize: querySize,
  };
};

export { getFilter };
