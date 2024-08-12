// show row
export function showRow(select, url, contentLoad, loadPage) {
    $(".container").on('change', select, function () {
        var value = $(this).val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'itemOfPage': value,
                'page': 1
            },
            dataType: "html",
            success: function (response) {
                $(contentLoad).html(response);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'get-count': true
                    },
                    dataType: "html",
                    success: function (response) {
                        var count = Number(response);
                        var page = Math.ceil(count / value);
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
                        $(loadPage).html(content);
                    }
                });
            }
        });
    });
}

// swap page
export function swapPage(select, pageItem, url, rowShow, contentLoad) {
    $(".container").on('click', select, function (e) {
        e.preventDefault();
        var page = $(this).text();

        $(pageItem).removeClass('active');
        $(this).parent().addClass('active');

        $(pageItem).find('a').removeClass('disabled');

        checkButtonSwapPage($(this))

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'page': page,
                'itemOfPage': $(rowShow).val()
            },
            dataType: "html",
            success: function (response) {
                $(contentLoad).html(response);
            }
        });
    })
}

// next page
export function nextPage(select, pageC, pageItem, url, rowShow, contentLoad) {
    $(".container").on('click', select, function (e) {
        e.preventDefault();

        var pageCurrent = $(pageC);
        $(pageItem).find('a').removeClass('disabled');

        if (pageCurrent.text() == $(pageItem).length) {
            return;
        }

        $(pageItem).removeClass('active');
        pageCurrent.parent().next().addClass('active');


        var page = $(pageC)

        checkButtonSwapPage(page)
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'page': Number(page.text()),
                'itemOfPage': $(rowShow).val()
            },
            dataType: "html",
            success: function (response) {
                console.log(response)
                $(contentLoad).html(response);
            }
        });
    })
}

// previous page
export function previousPage(select, pageC, pageItem, url, rowShow, contentLoad) {
    $(".container").on('click', select, function (e) {
        e.preventDefault();
        var pageCurrent = $(pageC);

        $(pageItem).find('a').removeClass('disabled');

        if (pageCurrent.text() == 1) {
            return;
        }

        $(pageItem).removeClass('active');
        pageCurrent.parent().prev().addClass('active');

        var page = $(pageC);

        checkButtonSwapPage(page)

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'page': Number($(pageC).text()),
                'itemOfPage': $(rowShow).val()
            },
            dataType: "html",
            success: function (response) {
                $(contentLoad).html(response);
            }
        });
    })
}
