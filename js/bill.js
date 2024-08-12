$(document).ready(function () {
    // delete bill
    $(".info").on('click', '.bill-delete button', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: "Bạn có muốn hủy đơn hàng?",
            text: "",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "hủy",
            cancelButtonText: "Hủy bỏ"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Đã hủy đơn hàng",
                    text: "",
                    icon: "success"
                });
                $(this).closest('.bill-item').remove();

                $.ajax({
                    type: "POST",
                    url: "./gui/showBookedBill.php",
                    data: {
                        'id': id,
                        'delete-bill': true
                    },
                    dataType: "html",
                    success: function (response) {
                        console.log(response);
                    }
                });

            }
        })
    });

    // receive bill
    $(".info").on('click', '.bill-button-receive .receive-bill', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var parent = $(this).closest('.bill-item');

        $.ajax({
            type: "POST",
            url: "./gui/showBillInDelivery.php",
            data: {
                'id': id,
                'receive-bill': true
            },
            dataType: "html",
            success: function (response) {
                console.log(response);
                parent.remove();
                Swal.fire({
                    title: "Đã nhận đơn hàng",
                    text: "",
                    icon: "success"
                }).then(() => {
                    window.location.href = "http://localhost/webBanGiay/billDetail.php?idBill=" + id;
                })

            }
        });

    });

})