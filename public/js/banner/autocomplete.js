$( document ).ready(function() {
  // initialize autocompleter for search bar
$( '.input-group > input[type="text"]' ).autocomplete({
    source: function( request, response ) {
      $.ajax( {
        method:'POST',
        url: "search",
        dataType: "json",
        data: {
          op: 'getSearch',
          search: request.term
        },
        success: function( data ) {
          response( data.slice(0,5) );
        }
      } );
    },
    minLength: 1,
    select: function( event, ui ) {
      $(location).attr('href', 'prod/' + ui.item.id);

    }
  });
});