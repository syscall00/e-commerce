// General product function 

/**
 * Generate the html code for visualize the stars
 * @param {*} ratingNumber number of stars which will be generated
 */
function generateStars(ratingNumber) {
    var result = "";
    var i =1;
    for(; i <= ratingNumber; i++) {
      result+='<i class="fas fa-star fa-sm text-primary"></i>';
    }
    for(; i <= 5; i++) {
      result+='<i class="far fa-star fa-sm text-primary"></i>'
    }
    return result;

  }

