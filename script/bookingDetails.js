const subMain = document.getElementsByClassName('subMain');
var size = subMain.length;

// adding some margin-top to the div, for the sake of bg color
for (var i = 0; i < size; i++) {
    document.getElementsByClassName('subMain')[i].children[0].style.margin = '20px 0 25px 0';
}



// bold the booking status and amount
subMain[1].children[5].children[1].style.fontWeight = 'bold';
subMain[1].children[5].children[1].style.fontSize = '1.3rem';
subMain[1].children[6].children[1].style.fontWeight = 'bold';
subMain[1].children[6].children[1].style.fontSize = '1.3rem';



// double confirm to before cancelling a booking
var cancelTag = document.getElementById('cancel');
if (cancelTag != null) {
    // remove the href as redirection will be done by JS
    cancelTag.removeAttribute('href');
    cancelTag.addEventListener('click', function() {
        var cancel = confirm('Are you sure to cancel this booking?\nBooking ID: ' + bookingID);
        if (cancel) {
            var realCancel = confirm('This booking (ID: ' + bookingID + ') will be cancelled.\nClick \'OK\' to proceed.');
            if (realCancel) {
                // modify the url and trigger the cancel block
                window.location.href  = 'bookingDetails.php?bookingID=' + bookingID + '&realCancel=y';
            }
        }   
    });
}



var payNow = document.getElementById('pay');
if (pay != null) {
    payNow.removeAttribute('href');
    payNow.addEventListener('click', function() {
        // open in new popup window
        // open(url, target, attr)
        window.open('payment.php?bookingID=' + bookingID, 'SECURED PAYMENT GATEWAY', 'width=1000px, height=500px');
    })
}

