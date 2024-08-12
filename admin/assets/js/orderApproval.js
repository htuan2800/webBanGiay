

$(document).ready(function () {

    // approve order
    $('.container').on('click', '.table-responsive .approve-order', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var btn = $(this);
        $.ajax({
            type: "POST",
            url: "./gui/tableOrderApproval.php",
            data: {
                'id': id,
                'approve-bill': true
            },
            dataType: "html",
            success: function (response) {
                console.log(response);
                Swal.fire({
                    title: "Đã duyệt đơn hàng",
                    text: "Hãy chuẩn bị đơn hàng và giao hàng",
                    icon: "success"
                });

                btn.closest('tr').remove();

                if ($('.table-responsive .approve-order').length == 0) {
                    var pageCurrent = $('.container .info-order-approval .pagination li.active').text();
                    var itemOfPage = $('.container .info-order-approval .order-approval-tools #itemOfPage').val();

                    $.ajax({
                        type: "POST",
                        url: "./gui/tableOrderApproval.php",
                        data: {
                            'page': pageCurrent,
                            'itemOfPage': itemOfPage
                        },
                        dataType: "html",
                        success: function (response) {
                            $('.container .info-order-approval .table-order-approval').html(response);

                            $.ajax({
                                type: "POST",
                                url: "./gui/tableOrderApproval.php",
                                data: {
                                    'get-count': true
                                },
                                dataType: "html",
                                success: function (response) {
                                    var count = Number(response);
                                    if (count == 0) {
                                        $('.container .info-order-approval .pagination').html('');
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
                                    $('.container .info-order-approval .pagination').html(content);
                                }
                            });
                        }
                    })
                }

            }
        });

    })

});