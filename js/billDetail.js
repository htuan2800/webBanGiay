$(document).ready(function () {

    // receive order
    $('.container').on('click', '.button-order button', function () {
        var status = $(this).data('status');
        var idBill = new URLSearchParams(window.location.search).get('idBill');

        $.ajax({
            type: "POST",
            url: "./billDetail.php",
            data: {
                'idBill': idBill,
                'status': status,
                'updateStatus': true
            },
            dataType: "html",
            success: function (response) {
                window.location.reload();
            }
        });

    });

    // show rate
    $('.container').on('click', '.bill-detail .bill-button button', function () {
        var idProduct = $(this).data('id-product');
        $.ajax({
            type: "POST",
            url: "./gui/rateProduct.php",
            data: {
                'idProduct': idProduct
            },
            dataType: "html",
            success: function (response) {
                $('.modal-dialog').html(response);
            }
        });
    })

    // rate
    var buttonRate;
    $('.modal-dialog').on('click', '.modal-footer button', function () {
        var idProduct = $(this).data('id-product');
        var idBill = new URLSearchParams(window.location.search).get('idBill');
        var star = $('.modal-dialog .modal-body .star-wrap input:checked').data('star')
        var comment = $('.modal-dialog .modal-body .content textarea').val();
        buttonRate = $(this);

        console.log(comment.length)
        if (comment.length > 250) {
            Swal.fire({
                icon: 'error',
                title: 'Đánh giá vượt giới hạn!',
                text: 'Đánh giá tối đa 250 ký tự',
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: "./billDetail.php",
            data: {
                'idProduct': idProduct,
                'idBill': idBill,
                'star': star,
                'comment': comment,
                'updateRate': true
            },
            dataType: "html",
            success: function (response) {
                buttonRate.addClass('btn-success').removeClass('btn-primary').text('Đã đánh giá');
                buttonRate.attr('disabled', true);

                $('.modal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Đánh giá thành công!',
                    text: '',
                }).then(() => {
                    if (response == "success") {
                        location.reload();
                    }
                })
            }
        });
    })
});