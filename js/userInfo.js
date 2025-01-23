$(document).ready(function () {
  // tooltip Bootstrap
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  // load js
  $.when(
    $.getScript("./js/contentDialog.js"),
    $.getScript("./js/validate.js")
  ).done(function () {});

  // update avatar
  $(".info").on("click", "#update-avatar", function (e) {
    e.preventDefault();
    $("#avatar-input").click();
  });

  $(".info").on("change", "#avatar-input", function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append("avatar", this.files[0]);
    formData.append("update-avatar", true);
    $("#avatar").attr("src", URL.createObjectURL(this.files[0]));

    $.ajax({
      type: "POST",
      url: "./gui/userInfo.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log(response);
        window.location.reload();
      },
    });
  });

  // swap menu
  $(".container-fluid.user-info .function .load-link").click(function (e) {
    e.preventDefault();
    var href = $(this).attr("href");
    if ($(this).hasClass("selected")) {
      return;
    }
    $(".function a").removeClass("selected");
    $(this).addClass("selected");
    $(".loading").css("display", "block");
    $.ajax({
      type: "GET",
      url: href,
      dataType: "html",
      success: function (response) {
        $(".info").html(response);
        const tooltipTriggerList = document.querySelectorAll(
          '[data-bs-toggle="tooltip"]'
        );
        const tooltipList = [...tooltipTriggerList].map(
          (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
        );
        $(".loading").css("display", "none");
      },
    });
  });

  // show modal add address
  $(".info").on("click", ".address .title button", function (e) {
    $(".modal").html(contentAddAddress());
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");
    var Parameter = {
      url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
      method: "GET",
      responseType: "application/json",
    };
    var promise = axios(Parameter);
    promise.then(function (result) {
      renderCity(result.data);
    });

    function renderCity(data) {
      for (const x of data) {
        citis.options[citis.options.length] = new Option(x.Name, x.Id);
      }
      citis.onchange = function () {
        district.length = 1;
        ward.length = 1;
        if (this.value != "") {
          const result = data.filter((n) => n.Id === this.value);

          for (const k of result[0].Districts) {
            district.options[district.options.length] = new Option(
              k.Name,
              k.Id
            );
          }
        }
      };
      district.onchange = function () {
        ward.length = 1;
        const dataCity = data.filter((n) => n.Id === citis.value);
        if (this.value != "") {
          const dataWards = dataCity[0].Districts.filter(
            (n) => n.Id === this.value
          )[0].Wards;

          for (const w of dataWards) {
            wards.options[wards.options.length] = new Option(w.Name, w.Id);
          }
        }
      };
    }
    $(".modal").modal("show");
  });

  // save address or update
  $(".modal").on("click", ".modal-footer button", function (e) {
    var type = $(this).attr("data-type");
    var name = $("#recipient-name").val();
    var phone = $("#phone").val();
    var city = $("#city option:selected").text();
    var district = $("#district option:selected").text();
    var ward = $("#ward option:selected").text();
    var address = $("textarea[name=address]").val();

    var checkEmpty =
      validateEmpty(name) || validateEmpty(phone) || validateEmpty(address);
    if (checkEmpty == true) {
      Swal.fire({
        title: "Không bỏ trống các thông tin trên!!",
        text: "Vui lòng điền đầy đủ",
        icon: "error",
      });
      return;
    }
    if (
      $("#city option:selected").val() == "" ||
      $("#district option:selected").val() == "" ||
      $("#ward option:selected").val() == "" ||
      $("#city option:selected").val() == "0" ||
      $("#district option:selected").val() == "0" ||
      $("#ward option:selected").val() == "0" ||
      $("#city option:selected").length == 0 ||
      $("#district option:selected").length == 0 ||
      $("#ward option:selected").length == 0
    ) {
      Swal.fire({
        title: "Vui lòng chọn đầy đủ thành phố, quận huyện, phương xã",
        text: "",
        icon: "error",
      });
      return;
    }

    $("#recipient-name ~ .error").text(validateFullname(name));
    $("#phone ~ .error").text(validatePhone(phone));
    $("textarea[name=address] ~ .error").text(validateAddress(address));

    if (
      validateFullname(name) == "" &&
      validatePhone(phone) == "" &&
      validateAddress(address) == ""
    ) {
      address = city + ", " + district + ", " + ward + ", " + address;
      var oldName = "";
      var oldPhone = "";
      var oldAddress = "";
      if (type == "update-address") {
        oldName = $("#recipient-name").attr("data-old-name");
        oldPhone = $("#phone").attr("data-old-phone");
        oldAddress = $("textarea[name=address]").attr("data-old-address");
      }
      $.ajax({
        type: "POST",
        url: "./gui/addressInfo.php",
        data: {
          type: type,
          name: name,
          phone: phone,
          address: address,
          oldName: oldName,
          oldPhone: oldPhone,
          oldAddress: oldAddress,
        },
        dataType: "html",
        success: function (response) {
          $(".modal").modal("hide");
          $(".info").html(response);
          const tooltipTriggerList = document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'
          );
          const tooltipList = [...tooltipTriggerList].map(
            (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
          );
        },
      });
    }
  });

  // delete address
  $(".info").on("click", ".address .show-address .remove", function (e) {
    var trParent = $(this).parent().parent();
    var name = trParent.find(".name").text();
    var phone = trParent.find(".phone").text();
    var address = trParent.find(".address").text();

    $.ajax({
      type: "POST",
      url: "./gui/addressInfo.php",
      data: {
        "delete-address": true,
        name: name,
        phone: phone,
        address: address,
      },
      dataType: "html",
      success: function (response) {
        $(".info").html(response);
        const tooltipTriggerList = document.querySelectorAll(
          '[data-bs-toggle="tooltip"]'
        );
        const tooltipList = [...tooltipTriggerList].map(
          (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
        );
      },
    });
  });

  // set default
  $(".info").on("click", ".address .show-address .set-default", function (e) {
    var trParent = $(this).parent().parent();
    var name = trParent.find(".name").text();
    var phone = trParent.find(".phone").text();
    var address = trParent.find(".address").text();

    $.ajax({
      type: "POST",
      url: "./gui/addressInfo.php",
      data: {
        "set-default": true,
        name: name,
        phone: phone,
        address: address,
      },
      dataType: "html",
      success: function (response) {
        $(".info").html(response);
        const tooltipTriggerList = document.querySelectorAll(
          '[data-bs-toggle="tooltip"]'
        );
        const tooltipList = [...tooltipTriggerList].map(
          (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
        );
      },
    });
  });

  // show update address
  $(".info").on("click", ".address .show-address .update", function (e) {
    var trParent = $(this).parent().parent();
    var name = trParent.find(".name").text();
    var phone = trParent.find(".phone").text();
    var address = trParent.find(".address").text();
    var arr_string = address.split(", ");
    var city = arr_string[0];
    var district = arr_string[1];
    var ward = arr_string[2];
    address = arr_string[3];
    $(".modal").html(
      contentUpdateAddress(name, address, phone, city, district, ward)
    );
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");
    var Parameter = {
      url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
      method: "GET",
      responseType: "application/json",
    };
    var promise = axios(Parameter);
    promise.then(function (result) {
      renderCity(result.data);
    });

    function renderCity(data) {
      for (const x of data) {
        citis.options[citis.options.length] = new Option(x.Name, x.Id);
      }
      citis.onchange = function () {
        districts.length = 0;
        wards.length = 0;
        if (this.value != "") {
          const result = data.filter((n) => n.Id === this.value);

          for (const k of result[0].Districts) {
            districts.options[districts.options.length] = new Option(
              k.Name,
              k.Id
            );
          }
        }
      };
      districts.onchange = function () {
        ward.length = 0;
        const dataCity = data.filter((n) => n.Id === citis.value);
        if (this.value != "") {
          const dataWards = dataCity[0].Districts.filter(
            (n) => n.Id === this.value
          )[0].Wards;

          for (const w of dataWards) {
            wards.options[wards.options.length] = new Option(w.Name, w.Id);
          }
        }
      };
    }
    $(".modal").modal("show");
  });

  // swap show bill
  $(".info").on("click", ".info-bill .title span", function (e) {
    $(".info-bill .title span").removeClass("selected");
    $(this).addClass("selected");
    var type = $(this).data("type");
    $(".loading").css("display", "block");

    var url = "";

    switch (type) {
      case 1:
        url = "./gui/showBookedBill.php";
        break;
      case 2:
        url = "./gui/showApprovedBill.php";
        break;
      case 3:
        url = "./gui/showBillInDelivery.php";
        break;
      case 4:
        url = "./gui/showBillDelivered.php";
        break;
      case 0:
        url = "./gui/showBillCancelled.php";
        break;
    }
    $.ajax({
      type: "POST",
      url: url,
      dataType: "html",
      success: function (response) {
        $(".loading").css("display", "none");
        $(".info-bill .show-bill").html(response);
      },
    });
  });
});
