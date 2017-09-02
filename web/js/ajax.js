$('.add_to_cart_button').click(function () {
    var addid = $(this).attr('data-product_id');
    var prodAmount = $('.qty').val();
    $.ajax({
        type: "POST",
        url: "/cart/add",
        data: {
            product: addid,
            amount: prodAmount
        },
        dataType: "json",
        success: function (data) {
            if (data['status'] === 'error') {
                window.location.href = "/login";
            } else {

                var oldCost = $('.cart-amunt').text();
                $('.cart-amunt').text( Number(oldCost) + Number(data['data']['cost']));
                if (data['data']['amount']) {
                    var oldCount = $('.product-count').text();
                    $('.product-count').text(Number(oldCount) + Number(data['data']['amount']));
                }
            }
        }
    });
});
$('.add_to_wishlist_button').click(function () {
    var addid = $(this).attr('data-product_id');
    $.ajax({
        type: "POST",
        url: "/wishlist/add-to-wishlist",
        data: {
            product: addid
        },
        dataType: "json",
        success: function (data) {
            if (data['status'] === 'error') {
                window.location.href = "/login";
            }
        }
    });
});
