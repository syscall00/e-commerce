/**
 * Show a notification bar 
 * @param {string} message message which will be displayed
 * @param {int} duration time of display
 */
function showNotificationBar(message, duration) {
 
    /*set default values*/
    duration = typeof duration !== 'undefined' ? duration : 2000;

    /*create the notification bar div if it doesn't exist*/
    if ($('#notification-bar').length != 0) {
        $('#notification-bar').remove();
    }
        var HTMLmessage = "<div class='notification-message'> " + message + " </div>";
        $('body').append("<div id='notification-bar'>" + HTMLmessage + "</div>");

    /*animate the bar*/
    $('#notification-bar').slideDown(function() {
        setTimeout(function() {
            $('#notification-bar').slideUp(function() {});
        }, duration);
    });
}


$( document ).ready(function() {

    $.post('cart', {op: 'count'}, function(response) {
        if(response.code) 
            updateBadge(response.data['cnt']);
    }, 'json');


});


/**
 * Set the cart badge
 * @param {int} value number to be set on the badge
 */
function updateBadge(value) {
    $('#cart-prod').text(value);

}