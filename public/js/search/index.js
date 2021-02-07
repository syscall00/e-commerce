var page = 1;
var stopScrolling = false;
var filter = {available : false, starRating : 0, minPrice : 0, maxPrice : Number.MAX_VALUE};

$( document ).ready(function() {
  filterHandler();
  
  // add infinite scrolling
  $(window).scroll(function() {  
     
    if(!stopScrolling && Math.ceil($(window).scrollTop() + $(window).height()) >= $(document).height()) 
        genericLoad(true);
 });
});

/**
 * Handle the filter section 
 */
function filterHandler() {

  // Available checkbox
  $('#Check0').change(function(){
    filter.available = this.checked;
    genericLoad();
  })

  // price range filter
  $('#confirm-filter').click(function() {
    var min = $('#min-filter').val();
    var max = $('#max-filter').val();

    if(($.isNumeric(min) || $.isNumeric(max)) && (min >= 0 && max >= 0)) {
      filter.minPrice = $.isNumeric(min)? min : filter.minPrice;
      filter.maxPrice = $.isNumeric(max)? max : filter.maxPrice;
      genericLoad();
    }
    else 
      showNotificationBar("Per favore, inserisci dei valori positivi");
  });

  // reset button
  $('#reset-filter').click(function() {

    filter.minPrice = 0;
    filter.maxPrice = Number.MAX_VALUE;
    genericLoad();

  });

  // review filter
  $("input[name='filter']").change(function() {

    filter.starRating = $(this).val();
    genericLoad();

  });

}

/**
 * Generic function for loading results from a filters or from scrolling.
 * 
 * @param {*} scroll true if is a request used during infinite scrolling. if false, recharge results by first page
 * (scroll = false -> filters, scroll = true -> infinite scrolling)
 */
function genericLoad(scroll = false) {
  page = scroll? page+1: 0;
  var search = $('#search-value').text();
  $.post("search/", {op: 'getProd', search: search,  page: page, filter: filter}, function(response) {
    if(response.code == 1) { 
      if(!scroll) {
        $('.productsList').html('');
        stopScrolling = false;
      }

      var data = response.data;
      $.each(data, function(key,value) {
  
        $html = visualizeProduct(value);
        $('.productsList').append($html);
     });   
    }
    else {
      showNotificationBar(response.description);
    }

  }, "json");

}

/**
 * generate the html for visualizing a new product. used on 
 * genericLoad
 * @param {*} prod new product which will be displayed
 */
function visualizeProduct(prod) {
  if(prod['quantity'] > 0) {
    $available = "Disponibile";
    $class_available = "available";
  }
  else {
    $available = "Non disponibile";
    $class_available = "not-available";

  }
  var vote = generateStars(prod['rating']);

   return `<div class="bg-white p-3 rounded mb-3">
   <div class="row">
       <div class="col-md-3">
           <div><a href="/public/prod/${prod['id']}"><img class="img-fluid" src="/public/img/products/${prod['id']}/1.png" alt="prod${prod['id']}"></img></a></div>
       </div>
       <div class="col-md-9">
           <div class="listing-title">
               <h5><a href="/public/prod/${prod['id']}" >${prod['name']}</a></h5>
           </div>
           <div class="d-flex flex-row align-items-center">
               <div class="d-flex flex-row align-items-center ratings">
                  ${vote}
               </div>
 
           </div>
           <div class="description">
   <div><span>Venduto da <strong>${prod['seller_name']} ${prod['seller_surname']}</strong></span></div>
 <div class="price mb-2">
               <span>${prod['price']}€</span>
 </div>
           </div>
           <div class="mt-2"><span class="${$class_available}">${$available}</span></div>
       </div>



       </div>
   </div>
</div>
</div>`;
  

}
