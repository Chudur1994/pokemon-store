var catalogPreloader = $('.catalog-preloader');

function showPage(page, types) {
    $.ajax({
        type: 'POST',
        url: 'catalog.php',
        data: {
            page: page,
            types: types
        },
        success: function (data) {
            $('#catalog').html(data);
        },
        beforeSend: function () {
            console.log('hello');
            $(catalogPreloader).show();
        },
        complete: function () {
            $(catalogPreloader).hide();
        }
    });
}

$(document).on('click', '.add-to-cart', function (e) {
    e.preventDefault();
    Materialize.toast('Add To Cart', 1000, 'blue')
});

$(document).on('click', '.pagination_link', function (e) {
    e.preventDefault();
    var page = $(this).attr("id");
    showPage(page, checkedTypes());
});

$(document).on('click', '.previous_link', function (e) {
    e.preventDefault();
    if (!$(this).hasClass('disabled')) {
        // if not disabled
        var activeLink = parseInt($('ul.pagination').find('li.active').children(0).attr("id"));
        showPage((activeLink - 1).toString(), checkedTypes());
    }
});

$(document).on('click', '.next_link', function (e) {
    e.preventDefault();
    if (!$(this).hasClass('disabled')) {
        // if not disabled
        var activeLink = parseInt($('ul.pagination').find('li.active').children(0).attr("id"));
        showPage((activeLink + 1).toString(), checkedTypes());
    }
});

function filterType() {
    showPage(1, checkedTypes());
}

function checkedTypes() {
    var types = document.getElementsByClassName('type');
    var checkedTypes = [];
    for (i = 0; i < types.length; i++) {
        if (types[i].checked) {
            checkedTypes.push(types[i].id);
        }
    }

    return checkedTypes;
}