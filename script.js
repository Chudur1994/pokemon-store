$(document).ready(function () {
    showPage(1);

    const saleAddToCart = $("#sale-add-to-cart");

    $('.carousel').carousel({
        onCycleTo: function (data) {
            $.ajax({
                type: 'POST',
                url: 'catalog.php',
                data: {
                    salePokemon: $(data).data('salepokemon')
                },
                dataType: 'json'
            })
                .done(function (returnedData) {
                    console.log(returnedData);
                    saleAddToCart.html(returnedData["addToCart"]);
                    $('#sale-info .item-name').text(returnedData["name"]);
                    $('#sale-info .item-desc').text(returnedData["description"]);
                });
        }
    });

    const catalog = $("#catalog");
    const filterChips = $("#filter-chips");
    const pagination = $(".pagination");

    function showPage(page, types) {
        $.ajax({
            method: "POST",
            url: "catalog.php",
            data: {
                page: page,
                types: types
            },
            dataType: "json"
        })
            .done(function (data) {
                filterChips.html(data[0]);
                catalog.html(data[1]);
                pagination.html(data[2]);
            });
    }

    function addToCart(item) {
        $.ajax({
            method: 'POST',
            url: 'catalog.php',
            data: {
                itemAdded: item
            },
            dataType: "json"
        })
            .done(function (data) {
                Materialize.toast(data[0], 1000, data[1]);
            })
    }

    const cartItems = $("#cart");
    const cartTax = $("#tax");
    const cartTotal = $("#total");

    function removeFromCart(item) {
        $.ajax({
            method: 'POST',
            url: 'catalog.php',
            data: {
                itemRemoved: item
            },
            dataType: "json"
        })
            .done(function (data) {
                cartItems.html(data["item"]);
                cartTax.html(data["tax"]);
                cartTotal.html(data["total"]);
            })
    }

    $(document).on('click', '.remove-from-cart', function (e) {
        e.preventDefault();
        removeFromCart(JSON.parse(this.dataset.pokemon));
    });

    $(document).on('click', '.add-to-cart', function (e) {
        e.preventDefault();
        addToCart(JSON.parse(this.dataset.pokemon));
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

    $(document).on('change', '.type', function (e) {
        e.preventDefault();
        showPage(1, checkedTypes());
    });

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
});