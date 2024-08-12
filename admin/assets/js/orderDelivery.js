$(document).ready(function () {
    // deliver order
    $('.container').on('click', '.table-responsive .deliver-order', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var btn = $(this);
        $.ajax({
            type: "POST",
            url: "./gui/tableOrderdelivery.php",
            data: {
                'id': id,
                'deliver-bill': true
            },
            dataType: "html",
            success: function (response) {
                console.log(response);
                Swal.fire({
                    title: "Đơn hàng đã giao cho đơn vị vận chuyển",
                    text: "",
                    icon: "success"
                });

                btn.css({
                    'background-color': 'orange',
                    'border': 'none'
                });

                btn.prop("disabled", true);

                if ($('.table-responsive .approve-order').length == 0) {
                    var pageCurrent = $('.container .info-order-delivery .pagination li.active').text();
                    var itemOfPage = $('.container .info-order-delivery .order-delivery-tools #itemOfPage').val();

                    $.ajax({
                        type: "POST",
                        url: "./gui/tableOrderdelivery.php",
                        data: {
                            'page': pageCurrent,
                            'itemOfPage': itemOfPage
                        },
                        dataType: "html",
                        success: function (response) {
                            $('.container .info-order-delivery .table-order-delivery').html(response);

                            $.ajax({
                                type: "POST",
                                url: "./gui/tableOrderdelivery.php",
                                data: {
                                    'get-count': true
                                },
                                dataType: "html",
                                success: function (response) {
                                    var count = Number(response);
                                    if (count == 0) {
                                        $('.container .info-order-delivery .pagination').html('');
                                        return;
                                    }
                                    var page = Math.ceil(count / itemOfPage);
                                    var content = '';
                                    content += `
                                    <li class="page-item">
                                        <a class="page-link previous disabled" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    `;

                                    for (var i = 1; i <= page; i++) {
                                        if (i == 1) {
                                            content += `
                                            <li class="page-item active">
                                                <a class="page-link" href="#">${i}</a>
                                            </li>
                                            `;
                                        } else {
                                            content += `
                                            <li class="page-item">
                                                <a class="page-link" href="#">${i}</a>
                                            </li>
                                            `;
                                        }
                                    }

                                    if (page == 1) {
                                        content += `
                                        <li class="page-item">
                                            <a class="page-link next disabled" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                        `;
                                    } else {
                                        content += `
                                        <li class="page-item">
                                            <a class="page-link next" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                        `;
                                    }
                                    $('.container .info-order-delivery .pagination').html(content);
                                }
                            });
                        }
                    })
                }

            }
        });

    })
});