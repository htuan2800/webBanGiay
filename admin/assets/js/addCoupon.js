$(document).ready(function () {
    // add coupon
    $(".container").on('click', '#save-coupon', function (e) {
        e.preventDefault();

        // check coupon name
        var codeName = $("#coupon-name").val();
        if (codeName === "") {
            Swal.fire({
                icon: 'error',
                title: 'Tên sản phẩm không được để trống!',
                text: 'Xin vui nhập tên sản phẩm',
            });
            return;
        }

        var price = $("#percent-discount").val();
        // check price
        if (price === "") {
            Swal.fire({
                icon: 'error',
                title: 'Tỉ lệ giảm giá không được để trống!',
                text: 'Xin vui nhập tỉ lệ',
            });
            return;
        }
        if (isNaN(price) || price < 0 || price >100) {
            Swal.fire({
                icon: 'error',
                title: 'Dữ liệu không hợp lệ!',
                text: 'Giá phải là số nguyên dương và không lớn hơn 100',
            });
            return;
        }

        var startDate = $("#start-date").val();
        if (startDate === "") {
            Swal.fire({
                icon: 'error',
                title: 'Ngày bắt đầu không để trống!',
                text: 'Xin vui nhập ngày bắt đầu',
            });
            return;
        }

        var endDate = $("#end-date").val();
        if (endDate === "") {
            Swal.fire({
                icon: 'error',
                title: 'Ngày kết thúc không để trống!',                
                text: 'Xin vui nhập ngày kết thúc',
            });
            return;
        }

        if(startDate > endDate){
            Swal.fire({
                icon: 'error',
                title: 'Ngày kết thúc không hợp lệ!',
                text: 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
            });
            return;
        }
        var formData = new FormData();
        formData.append("add-coupon", true);
        formData.append("name", codeName);
        formData.append("percent", price);
        formData.append("start-date", startDate);
        formData.append("end-date", endDate);

        $.ajax({
            type: "POST",
            url: "./gui/addCoupon.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var data = JSON.parse(response);
                console.log(data);
                    swal.fire({
                        icon: 'success',
                        title: 'Đã thêm mã giảm giá',
                        text: '',
                    });
                    $("#coupon-name").val('')
                    $("#percent-discount").val('')
                    $("#start-date").val('')
                    $("#end-date").val('')
            }
        });
    })
});