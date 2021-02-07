$( document ).ready(function() {
  
  // set handlers for buttons
  $('#pay-order').on('click', createOrder);

  $('.syncBtn').on('click', function() { 
    var prod = this.value;
    var quantity = $("#prod"+prod +" #quantity").val(); 
    updateCart(prod,quantity); 
    
  });

$('.removeBtn').on('click', function() { 
  var prod = this.value;
  removeCart(prod); 
})

});


/**
 * Create a new order and if it is created 
 * succesful, redirect to orders page
 */
function createOrder() {
  $.post('cart', {op: 'order'}, function(response) {
        if(response.code) 
          $(location).attr('href', 'my')
          
    showNotificationBar(response.description);
}, 'json');
}

/**
 * Remove an item to the cart. Reflect the modification on
 * the displayed price and the cart badge
 * @param {*} prod_id id of the product which will be removed
 */
function removeCart(prod_id) {
    $.post('cart', {op: 'remove', prod_id : prod_id}, function(response) {
      if(response.code == 1) {
        var data = response.data;
        updatePrice(data.total_price);
        updateNumProd(data.total_quantity);
        updateBadge(data.total_quantity);
        $('#prod'+prod_id).remove();

      }

      showNotificationBar(response['description']);
    }, 'json');
  }

/**
 * Update the number of product for an already existing product in cart. 
 * Reflect the modification on the displayed price and the cart badge
 * @param {*} prod_id id of the product which will be updated
 * @param {*} quantity new quantity 
 */
function updateCart(prod_id, quantity) {
    $.post('cart', {op: 'update', prod_id : prod_id, quantity: quantity}, function(response) {
      if(response.code == 1) {
        var data = response.data;
        updatePrice(data.total_price);
        updateNumProd(data.total_quantity);
        updateBadge(data.total_quantity);
      }
      showNotificationBar(response['description']);
      }, 'json');
}

/**
 * update the displayed price on the cart
 * @param {*} value new price
 */
function updatePrice(value) {
  $('#total-price').text(value.toFixed(2) + "€");
}

/**
 * update the number of product of the cart
 * @param {*} value new quantity
 */
function updateNumProd(value) {
$("#num-cart").text(value);
}
