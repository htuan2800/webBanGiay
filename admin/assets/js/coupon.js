$(document).ready(function () {
    // load js
    $.when($.getScript("../js/validate.js")).done(function () { });
  
    // show coupon
    $(".main-panel").on(
      "change",
      ".container .info-coupon .coupon-tools .show select",
      function () {
        var value = $(this).val();
        $.ajax({
          type: "POST",
          url: "./gui/tableCoupon.php",
          data: {
            itemOfPage: value,
          },
          dataType: "html",
          success: function (response) {
            $(".container .info-coupon .table-coupon").html(response);
            if ($(".container .info-coupon .pagination li").length - 2 == 1) {
              $(".container .info-coupon .pagination .next").addClass(
                "disabled"
              );
            }
          },
        });
      }
    );
  
    // search coupon
    $(".main-panel").on(
      "keyup change",
      ".container .info-coupon .coupon-tools .search input",
      () => {
        var valueInput = $(
          ".main-panel .container .info-coupon .coupon-tools .search input"
        ).val();
        var valueItem = $(
          ".main-panel .container .info-coupon .coupon-tools .search select"
        ).val();
        $.ajax({
          type: "POST",
          url: "./gui/tableCoupon.php",
          data: {
            itemOfPage: valueItem,
            valueSearch: valueInput,
          },
          dataType: "html",
          success: function (response) {
            $(".container .info-coupon .table-coupon").html(response);
            if ($(".container .info-coupon .pagination li").length - 2 == 1) {
              $(".container .info-coupon .pagination .next").addClass(
                "disabled"
              );
            }
          },
        });
      }
    );
  
    // Delete coupon
    $(".main-panel").on(
      "click",
      ".container .info-coupon tbody .fa-trash",
      function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        Swal.fire({
          title: "Bạn có muốn xóa mã?",
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
              title: "Đã xóa mã",
              text: "",
              icon: "success",
            });
            $.ajax({
              type: "POST",
              url: "./gui/tableCoupon.php",
              data: {
                id: id,
                "delete-coupon": true,
              },
              dataType: "html",
              success: function (response) {
                console.log(response);
                $.ajax({
                  type: "POST",
                  url: "./gui/infoCoupon.php",
                  dataType: "html",
                  success: function (response) {
                    $(".main-panel .container").html(response);
                  },
                });
  
              },
            });
          }
        });
      }
    );
  
    // show edit coupon
    $(".main-panel").on(
      "click",
      ".container .info-coupon tbody .fa-edit",
      function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        $.ajax({
          type: "POST",
          url: "./gui/editCoupon.php",
          data: {
            id: id,
            "edit-coupon": true,
          },
          dataType: "html",
          success: function (response) {
            $(".main-panel .container .info-coupon .modal-dialog").html(
              response
            );
            $(".main-panel .container .info-coupon .modal").modal("show");
          },
        });
      }
    );

    $(".container").on(
        "click",
        ".info-coupon .modal-dialog #save-btn-coupon",
        function (e) {
          e.preventDefault();
          console.log(file);
          var idCoupon = $(this).data("id");
          var codename = $("#coupon-name").val();
          var percent = $("#percent-discount").val();
          var start_date = $("#start-date").val();
          var end_date = $("#end-date").val();
    
          if (codename == "" || percent == "", start_date == "", end_date == "") {
            Swal.fire({
              icon: "error",
              title: "Không bỏ trống trường nào!",
              text: "Vui lòng điền đầy đủ thông tin",
            });
            return;
          }

          if(percent > 100 || percent < 0){
            Swal.fire({
              icon: "error",              
              text: "Vui lòng nhập giá trị từ 0 đến 100",
            });
            return;
          }

          if(start_date > end_date){
            Swal.fire({
              icon: "error",              
              text: "Ngày kết thúc phải lớn hơn ngày bắt đầu",
            });
            return;
          }

          var formData = new FormData();
          if (file != "default" && file != "") {
            formData.append("avatar", file);
          } else {
            formData.append("avatarDefault", true);
          }
          formData.append("codename", codename);
          formData.append("percent", percent);
          formData.append("start_date", start_date);
          formData.append("end_date", end_date);
          formData.append("id", idCoupon);
          formData.append("editCoupon", true);
    
          $.ajax({
            type: "POST",
            url: "./gui/editCoupon.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              if (response == "1") {
                Swal.fire({
                  icon: "success",
                  title: "Đã lưu!",
                });
                row.find("td").eq(0).text(codename);
                row.find("td").eq(1).text(percent);
                row.find("td").eq(2).text(start_date);
                row.find("td").eq(3).text(end_date);
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
  
    // swap page
    


  });
  