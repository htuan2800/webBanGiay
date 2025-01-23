$(document).ready(function () {
  // slide show banner
  $(".slide-image").slick({
    autoplay: true, // Tự động chuyển slide
    autoplaySpeed: 2000, // Tốc độ chuyển slide (ms)
    dots: false, // Hiện thị chấm chuyển slide (cần css lại cho đẹp hơn)
    arrows: false, // Hiển thịz mũi tên chuyển slide
    infinite: true, // Lặp lại vô tận
    speed: 500, // Tốc độ chuyển đổi slide (ms)
    slidesToShow: 1, // Số lượng slide hiển thị cùng một lúc
    slidesToScroll: 1, // Số lượng slide chuyển khi bạn nhấn nút Previous/Next
    accessibility: true, //cho phép chuyển động bằng phím
    responsive: [
      // Cấu hình hiện thị khi chuyển động slide
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });

  // best seller
  $(".best-seller .products,.product-new .products ").slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 4,
    autoplay: false,
    autoplaySpeed: 2000,
    prevArrow:
      '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
    nextArrow:
      '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
    arrows: true,
    dots: false,
    responsive: [
      {
        breakpoint: 992,
        dots: false,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
});
