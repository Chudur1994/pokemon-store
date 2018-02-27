function showPage(page, types) {
    $.post('catalog.php', {
        page: page,
        types: types
    }, function (data) {
        $('#catalog').html(data);
    });
}

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