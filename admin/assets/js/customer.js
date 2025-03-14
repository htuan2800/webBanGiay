$(document).ready(function () {
    $(".main-panel").on('click', '.container .info-customer tbody .btn', function (e) {
        e.preventDefault();
        var id = $(this).closest('tr').find('img').data('id');
        if ($(this).hasClass('btn-success')) {
            Swal.fire({
                title: "Bạn có chắc muốn khóa tài khoản này?",
                text: "",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Khóa tài khoản",
                cancelButtonText: "Hủy bỏ"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đã khóa tài khoản",
                        text: "",
                        icon: "success"
                    });

                    $(this).removeClass('btn-success').addClass('btn-danger');
                    $(this).text('Khoá hoạt động');
                    $.ajax({
                        type: "POST",
                        url: "./gui/infoCustomer.php",
                        data: {
                            "id": id,
                            'block-customer': true
                        },
                        dataType: "html",
                        success: function (response) {

                        }
                    });
                }
            });
        }
        else if ($(this).hasClass('btn-danger')) {
            Swal.fire({
                title: "Bạn muốn mở khóa tài khoản này?",
                text: "",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Mở tài khoản",
                cancelButtonText: "Hủy bỏ"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đã mở tài khoản",
                        text: "",
                        icon: "success"
                    });

                    $(this).removeClass('btn-danger').addClass('btn-success');
                    $(this).text('Được hoạt động');
                    $.ajax({
                        type: "POST",
                        url: "./gui/infoCustomer.php",
                        data: {
                            "id": id,
                            'unblock-customer': true
                        },
                        dataType: "html",
                        success: function (response) {

                        }
                    });
                }
            });
        }
    });
});



  // remove customer
  $(".container").on(
    "click",
    ".info-customer .table tbody .fa-trash",
    function () {
      var id = $(this).data("id");
      var parent = $(this).closest("tr");

      Swal.fire({
        title: "Bạn có muốn xoá khách hàng này?",
        text: "",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy bỏ",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Đã xoá khách hàng",
            text: "",
            icon: "success",
          });
          parent.remove();
          $.ajax({
            type: "POST",
            url: "./gui/infoCustomer.php",
            data: {
              id: id,
              "remove-customer": true,
            },
            dataType: "html",
            success: function (response) {},
          });
        }
      });
    }
  );

  // edit customer
  var row = "";
  $(".container").on("click", ".info-customer .table tbody .fa-edit", function () {
    console.log($(this).data("id"));
    var id = $(this).data("id");
    row = $(this).closest("tr");
    $.ajax({
      type: "POST",
      url: "./gui/editCustomer.php",
      data: {
        id: id,
        "edit-customer": true,
      },
      dataType: "html",
      success: function (response) {
        $(".info-customer .modal-dialog").html(response);
      },
    });
  });

  var file = "";

  $(".container").on(
    "click",
    ".info-customer .modal-dialog #remove-avatar",
    function (e) {
      e.preventDefault();
      $("#avatar-img").attr("src", "../avatar/default-avatar.jpg");
      $("#avatar-input").val("");
      file = "default";
    }
  );

  $(".container").on(
    "click",
    ".info-customer .modal-dialog #change-avatar",
    function (e) {
      e.preventDefault();
      $("#avatar-input").click();
    }
  );

  $(".container").on("change", "#avatar-input", function (e) {
    file = e.target.files[0];
    console.log(file);
    $("#avatar-img").attr("src", URL.createObjectURL(file));
  });

  $(".container").on(
    "click",
    ".info-customer .modal-dialog #save-btn",
    function (e) {
      e.preventDefault();
      console.log(file);
      var idUser = $(this).data("id");
      var fullName = $("#full-name").val();
      var phoneNumber = $("#phone-number").val();
      var email = $("#email").val();

      if (fullName == "" || phoneNumber == "") {
        Swal.fire({
          icon: "error",
          title: "Không bỏ trống trường nào!",
          text: "Vui lòng điền đầy đủ thông tin",
        });
        return;
      }

      $("#full-name ~ span").text(validateFullname(fullName));
      $("#phone-number ~ span").text(validatePhone(phoneNumber));

      var check =
        validateFullname(fullName) == "" && validatePhone(phoneNumber) == "";
      if (!check) {
        return;
      }

      if (email != "Không có") {
        $("#email ~ span").text(validateEmail(email));

        check = validateEmail(email) == "";
        if (!check) {
          return;
        }
      } else {
        $("#email ~ span").text("");
      }

      var formData = new FormData();
      if (file != "default" && file != "") {
        formData.append("avatar", file);
      } else {
        formData.append("avatarDefault", true);
      }
      formData.append("fullName", fullName);
      formData.append("phoneNumber", phoneNumber);
      formData.append("email", email);
      formData.append("id", idUser);
      formData.append("edit", true);

      $.ajax({
        type: "POST",
        url: "./gui/editCustomer.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if (response == "1") {
            Swal.fire({
              icon: "success",
              title: "Đã lưu!",
            });
            row.find("td").eq(0).text(fullName);
            row.find("td").eq(1).text(phoneNumber);
            row.find("td").eq(2).text(email);
            row
              .find("td")
              .eq(3)
              .find("img")
              .attr("src", URL.createObjectURL(file));
          } else {
            Swal.fire({
              icon: "error",
              title: "Đã xảy ra lỗi!",
              text: response,
            });
          }
        },
      });
    }
  );