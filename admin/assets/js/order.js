import { showRow } from "./page.js";
import { swapPage } from "./page.js";
import { nextPage } from "./page.js";
import { previousPage } from "./page.js";

$(document).ready(function () {
    function checkButtonSwapPage(page) {
        var nextPage = page.parent().next().find('a')
        if (nextPage.hasClass('next')) {
            nextPage.addClass('disabled');
        }

        var previousPage = page.parent().prev().find('a')
        if (previousPage.hasClass('previous')) {
            previousPage.addClass('disabled');
        }
    }

    // show row of page
    showRow('.info-order-approval .order-approval-tools #itemOfPage', './gui/tableOrderApproval.php', '.info-order-approval .table-order-approval', '.info-order-approval .pagination ul.pagination')

    showRow('.info-order-delivery .order-delivery-tools #itemOfPage', './gui/tableOrderdelivery.php', '.info-order-delivery .table-order-delivery', '.info-order-delivery .pagination ul.pagination')

    showRow('.info-order-deliveried .order-deliveried-tools #itemOfPage', './gui/tableOrderdeliveried.php', '.info-order-deliveried .table-order-deliveried', '.info-order-deliveried .pagination ul.pagination')

    // swap page
    swapPage('.info-order-approval .pagination ul.pagination .page-item .page-link:not(.previous):not(.next)', '.info-order-approval .pagination ul.pagination .page-item', "./gui/tableOrderApproval.php", '.info-order-approval .order-approval-tools #itemOfPage', '.info-order-approval .table-order-approval')

    swapPage('.info-order-delivery .pagination ul.pagination .page-item .page-link:not(.previous):not(.next)', '.info-order-delivery .pagination ul.pagination .page-item', "./gui/tableOrderdelivery.php", '.info-order-delivery .order-delivery-tools #itemOfPage', '.info-order-delivery .table-order-delivery')

    swapPage('.info-order-deliveried .pagination ul.pagination .page-item .page-link:not(.previous):not(.next)', '.info-order-deliveried .pagination ul.pagination .page-item', "./gui/tableOrderdeliveried.php", '.info-order-deliveried .order-deliveried-tools #itemOfPage', '.info-order-deliveried .table-order-deliveried')

    // next page
    nextPage('.info-order-approval .pagination ul.pagination .page-item .page-link.next', '.info-order-approval .pagination ul.pagination .page-item.active a', '.info-order-approval .pagination ul.pagination .page-item', "./gui/tableOrderApproval.php", '.info-order-approval .order-approval-tools #itemOfPage', ".info-order-approval .table-order-approval")

    nextPage('.info-order-delivery .pagination ul.pagination .page-item .page-link.next', '.info-order-delivery .pagination ul.pagination .page-item.active a', '.info-order-delivery .pagination ul.pagination .page-item', "./gui/tableOrderdelivery.php", '.info-order-delivery .order-delivery-tools #itemOfPage', ".info-order-delivery .table-order-delivery")

    nextPage('.info-order-deliveried .pagination ul.pagination .page-item .page-link.next', '.info-order-deliveried .pagination ul.pagination .page-item.active a', '.info-order-deliveried .pagination ul.pagination .page-item', "./gui/tableOrderdeliveried.php", '.info-order-deliveried .order-deliveried-tools #itemOfPage', ".info-order-deliveried .table-order-deliveried")

    // previous page
    previousPage('.info-order-approval .pagination ul.pagination .page-item .page-link.previous', '.info-order-approval .pagination ul.pagination .page-item.active a', '.info-order-approval .pagination ul.pagination .page-item', "./gui/tableOrderApproval.php", '.info-order-approval .order-approval-tools #itemOfPage', ".info-order-approval .table-order-approval")

    previousPage('.info-order-delivery .pagination ul.pagination .page-item .page-link.previous', '.info-order-delivery .pagination ul.pagination .page-item.active a', '.info-order-delivery .pagination ul.pagination .page-item', "./gui/tableOrderdelivery.php", '.info-order-delivery .order-delivery-tools #itemOfPage', ".info-order-delivery .table-order-delivery")

    previousPage('.info-order-deliveried .pagination ul.pagination .page-item .page-link.previous', '.info-order-deliveried .pagination ul.pagination .page-item.active a', '.info-order-deliveried .pagination ul.pagination .page-item', "./gui/tableOrderdeliveried.php", '.info-order-deliveried .order-deliveried-tools #itemOfPage', ".info-order-deliveried .table-order-deliveried")

    // show bill
    $('.container').on('click', '.table-responsive.bill .fa-eye.show-bill', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "./gui/showBill.php",
            data: {
                'id': id
            },
            dataType: "html",
            success: function (response) {
                $('.container .modal-dialog').html(response);
            }
        });
    })
});