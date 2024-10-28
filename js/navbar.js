$(document).ready(function () {
  // load js
  $.when($.getScript("./js/contentDialog.js")).done(function () {});

  // dropdown menu
  function toggleDropdownEvent() {
    if ($(window).width() >= 992) {
      $(".nav-link").click(function (e) {
        $("dropdown-menu").data("bs-popper", null);
        $(".dropdown-menu").removeClass("show");
        $(this).removeClass("show");
      });
    } else {
      $(".nav-link").click(function (e) {
        $(this).addClass("show");
        $(this).parent().find(".dropdown-menu").data("bs-popper", "static");
        $(this).parent().find(".dropdown-menu").addClass("show");
      });
    }
  }

  toggleDropdownEvent();

  // event resize
  $(window).resize(function () {
    toggleDropdownEvent();
    if ($(window).width() >= 992) {
      $(".nav-link").removeClass("show");
      $("dropdown-menu").data("bs-popper", null);
      $(".dropdown-menu").removeClass("show");
    }
  });

  // show search form
  $("#search").click(function (e) {
    e.preventDefault();

    var content = contentSearch();
    $(".modal").html(content);

    $(".modal").modal("show");
  });

  // show login form
  $(".function-group #login").click(function (e) {
    e.preventDefault();

    var content = new Promise(function (resolve, reject) {
      $.get(
        "./gui/login.php",
        function (data, textStatus, jqXHR) {
          resolve(data);
        },
        "html"
      );
    });
    content.then(function (value) {
      $(".modal").html(value);
      $(".modal").modal("show");
    });
  });

  // swap page products
  $(".nav-link").click(function (e) {
    if ($(e.target).is("i")) {
      e.preventDefault();
    } else {
      var url = $(this).attr("href");
      window.location.href = url;
    }
  });

  // show menu mobile
  $(".nav-link i").click(function (e) {
    e.preventDefault();
  });

  // scroll > 200
  $(window).scroll(function () {
    if ($(window).scrollTop() > 100) {
      var height = $(".navbar").height() + 20;
      $(".fake-navbar").css({
        height: height + "px",
      });
      $(".navbar").addClass("fixed");
    } else {
      $(".fake-navbar").css({
        height: "auto",
      });
      $(".navbar").removeClass("fixed");
    }
  });
});
