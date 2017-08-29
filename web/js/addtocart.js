$ ('.add_to_cart_button').click(function () {
    var addid = $(this).attr('data-product_id');
    $.ajax({
        type: "POST",
        url: "/cart/add",
        data: {id:addid},
        dataType: "json",
        cache: false ,
        success: function(data){
            loadcart()}
    });
    return false;
});


function loadcart() {
    $.ajax({
        type: "POST",
        url: "ShopBundle\Controller\CartloadController",
        datatype: "json",
        cache: false,
        success: function (data) {
            if (data = "0") {
                $(".cart-amunt > a ").html("Cart is empty");
            }
            else {
                $(".cart-amunt > a").html(data);
            }
        }

    });
    return false;
}
