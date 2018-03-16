$(document).ready(function () {
    renderCatalog(1);
    renderInventory(1);

    $('.modal').modal();
    $('select').material_select();

    const inventory = $("#inventory");
    const inventoryPagination = $("#inventory-pagination");

    function renderInventory(pageNumber) {
        $.ajax({
            method: 'POST',
            url: 'catalog.php',
            data: {
                pageNumber: pageNumber,
                item: 'inventory'
            },
            dataType: 'json'
        })
            .done(function (data) {
                // console.log(data);
                inventory.html(data["items"]);
                inventoryPagination.html(data["pagination"]);
            })
    }

    const careItems = $(".cart-item");
    $(careItems).css({
        opacity: 0,
        left: '-20rem'
    });

    $(careItems).each(function (index) {
        $(this).animate({
            opacity: 1,
            left: 0
        }, (index + 1) * 100);
    });


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
                    // console.log(returnedData);
                    saleAddToCart.html(returnedData["addToCart"]);
                    $('#sale-info .item-name').text(returnedData["name"]);
                    $('#sale-info .item-desc').text(returnedData["description"]);
                });
        }
    });

    const catalog = $("#catalog");
    const filterChips = $("#filter-chips");
    const catalogPagination = $("#catalog-pagination");

    function renderCatalog(pageNumber, types) {
        $.ajax({
            method: "POST",
            url: "catalog.php",
            data: {
                pageNumber: pageNumber,
                item: 'catalog',
                types: types
            },
            dataType: "json"
        })
            .done(function (data) {
                // console.log(data);
                filterChips.html(data[0]);
                catalog.html(data[1]);
                catalogPagination.html(data[2]);
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

    const cart = $("#cart");
    const cartTotal = $("#total");

    function removeFromCart(item, el) {
        $.ajax({
            method: 'POST',
            url: 'catalog.php',
            data: {
                itemRemoved: item
            },
            dataType: "json"
        })
            .done(function (data) {
                if (data["empty"]) {
                    cart.html(data["empty"]);
                } else {
                    $(el).animate({
                        opacity: 0,
                        left: "-20rem"
                    }, 300, function () {
                        $(el).remove();
                    });
                }
                cartTotal.html(data["total"]);
            })
    }

    $(document).on('click', '.remove-from-cart', function (e) {
        e.preventDefault();
        const $containerCard = $(this).parent().parent();
        removeFromCart(JSON.parse(this.dataset.pokemon), $containerCard);
    });

    $(document).on('click', '.add-to-cart', function (e) {
        e.preventDefault();
        addToCart(JSON.parse(this.dataset.pokemon));
    });

    $(document).on('click', '.pagination_link', function (e) {
        e.preventDefault();
        const page = $(this).attr("id");
        const pagination = $(this).parent().parent().attr("id");

        if (pagination == "inventory-pagination") {
            renderInventory(page);
        } else if (pagination == "catalog-pagination") {
            renderCatalog(page, checkedTypes());
        }
    });

    $(document).on('click', '.previous_link', function (e) {
        e.preventDefault();
        const pagination = $(this).parent().parent().attr("id");

        if (!$(this).hasClass('disabled')) {
            // if not disabled
            const activeLink = parseInt($('ul.pagination').find('li.active').children(0).attr("id"));

            if (pagination == "inventory-pagination") {
                renderInventory((activeLink - 1).toString());
            } else if (pagination == "catalog-pagination") {
                renderCatalog((activeLink - 1).toString(), checkedTypes());
            }
        }
    });

    $(document).on('click', '.next_link', function (e) {
        e.preventDefault();
        const pagination = $(this).parent().parent().attr("id");

        if (!$(this).hasClass('disabled')) {
            // if not disabled
            const activeLink = parseInt($('ul.pagination').find('li.active').children(0).attr("id"));

            if (pagination == "inventory-pagination") {
                renderInventory((activeLink + 1).toString());
            } else if (pagination == "catalog-pagination") {
                renderCatalog((activeLink + 1).toString(), checkedTypes());
            }
        }
    });

    $(document).on('change', '.type', function (e) {
        e.preventDefault();
        renderCatalog(1, checkedTypes());
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