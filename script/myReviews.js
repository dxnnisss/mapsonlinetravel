const starList = ['star1', 'star2', 'star3', 'star4', 'star5'];

function changeColour(star) {
    // reset when customer change star
    for (var i = 0; i < starList.length; i++) {
        document.getElementById(starList[i]).innerHTML = '&#9734;';
    }
    for (var i = 0; i < star; i++) {
        document.getElementById(starList[i]).innerHTML = '&#9733;';
        document.getElementById('starRate').value = star;
    }
}

