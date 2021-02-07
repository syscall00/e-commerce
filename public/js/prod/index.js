var rating = -1;

$( document ).ready(function() {
  
  // add button handlers and initialize UI
  prodID = $('#prodId').val();

  $('#cartbtn').on('click', function() { quantity = $("#quantity").val(); addCart($('#prodId').val(),quantity);})
  $('#wishaddbtn').on('click', function() { addWish(prodID); });
  $('#wishrmvbtn').on('click', function() { removeWish(prodID); });

  addSlick();
  handleStars();
  handlerReview(prodID);
});



// CART FUNCTION

/**
 * add a product to cart
 * @param {*} prod_id id of the product which will be added
 * @param {*} quantity quantity of the product
 */
function addCart(prod_id, quantity) {
  $.post('cart', {op: 'add', prod_id : prod_id, quantity: quantity}, function(response) {
    if(response.code) {
      updateBadge(response.data['cnt']);
    }
    showNotificationBar(response['description']);
  }, 'json');
}



// WISHLIST FUNCTIONS
/**
 * invert the visibility of the two wish buttons
 */
function invertWish() {
  if($('#wishaddbtn').hasClass('d-none')) {
    $('#wishaddbtn').removeClass('d-none'); 
    $('#wishrmvbtn').addClass('d-none');
  }
  else {
    $('#wishrmvbtn').removeClass('d-none'); 
    $('#wishaddbtn').addClass('d-none');
  }
}

/**
 * add a product to wishlist
 * @param {*} prod_id id of the product which will be added
 */
function addWish(prod_id) {
  $.post('wish', {op: 'add', prod_id: prod_id}, function(response) {
    console.log(response);
    if(response.code == 1) 
      invertWish();
    showNotificationBar(response.description);
  }, 'json');
}

/**
 * remove a product to wishlist
 * @param {*} prod_id id of the product which will be removed
 */
function removeWish(prod_id) {
  $.post('wish', {op: 'remove', prod_id: prod_id}, function(response) {
    if(response.code == 1) 
      invertWish();
    showNotificationBar(response.description);
  }, 'json');
}


// STARS RATING FUNCTIONS
/**
 * add handlers to the add review stars
 */
function handleStars() {

  $('.star').mouseover(function () {
        
    removeHighlight(); 

    var index = parseInt($(this).data('index'));
    for(var i = 0; i <= index; i++){
      $('.star:eq('+i+')>i').addClass('fas').removeClass('far');
    }
});

$('.star').mouseleave(function () {
  if(rating == -1)
    removeHighlight(); 
});


$('.star').on('click', function() {
  var index = parseInt($(this).data('index'));
  rating = index;

  for(var i = 0; i <= index; i++){
    $('.star:eq('+i+')>i').addClass('fas').removeClass('far');
  }

});
}

/**
 * clear the stars highlight
 */
function removeHighlight() {
  $('.star').each(function() {
      $('.star>i').addClass('far').removeClass('fas');

  });
}


// REVIEWS FUNCTIONS

/**
 * add the handler for adding a new review
 * @param {*} prod_id id of the product which will be reviewed
 */
function handlerReview(prod_id) {

  $('#add-review').on('click', function() {
    var reviewText = $('#form-review').val();
    $.post('prod', {op: 'addReview', prod_id: prod_id, vote: rating+1, review: reviewText}, function(response) {
      showNotificationBar(response.description);
      if(response.code == 1) {
        $('#add-review-box').remove();
        
        var count = parseInt($('#rating-value').text());
        var value = parseFloat($('#rating-count').text());
        $('#rating-value').text((value+rating+1)/(count+1));
        $('#rating-count').text(count+1);
        visualizeReview(response.data[0]);
      }
    }, 'json');
  });

}

/**
 * generate the html for visualizing a new review. used on 
 * addreview
 * @param {*} review new review which will be displayed
 */
function visualizeReview(review) {

  var stars = generateStars(review['vote']);

  $('#reviews-container').append(`<hr><div class="media mt-4 mb-4">
  <div class="media-body">
      <p class="mb-0">
        <strong>${review['name']} ${review['surname']}</strong>
        <span> – </span><span>${review['time']} </span>
      </p>
      <div class="rating">
      ${stars}
      <div>
    <p class="mb-0">${review['review']}</p>
  </div></div>
  `);
}


/**
 * add slick slider
 */
function addSlick() {
  $('.slider').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: false,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
}