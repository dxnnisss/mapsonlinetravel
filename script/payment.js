const subMain = document.getElementsByClassName('subMain');
var size = subMain.length;

// adding some margin-top to the div, for the sake of bg color
for (var i = 0; i < size; i++) {
    // subMain[i].children[0].style.margin = '20px 0 25px 0';
    subMain[i].style.padding = '20px 0 0 0';
}

// bold the booking status and amount
subMain[0].children[5].children[1].style.fontWeight = 'bold';
subMain[0].children[5].children[1].style.fontSize = '1.3rem';
subMain[0].children[6].children[1].style.fontWeight = 'bold';
subMain[0].children[6].children[1].style.fontSize = '1.3rem';
subMain[1].children[4].children[1].style.fontWeight = 'bold';
subMain[1].children[4].children[1].style.fontSize = '1.3rem';


// -------------------------------------------------------------------------


// to get today date and its string format
const today = new Date();
var year = today.getFullYear();
// month displayed in 0 - 11
var month = today.getMonth() + 1;
var day = today.getDate();
if (String(month).length < 2) {
    // add leading zero
    month = '0' + month;
}
const strToday = String(year) + '-' + month;

// max expiry date (5 years)
const maxExpiry = String(year + 5) + '-' + month;

// setting min and max date
const expiry = document.getElementById('expiry');
expiry.min = strToday;
expiry.max = maxExpiry;


// -------------------------------------------------------------------------


// auto jump to next field (keyup == when user release a key)
function autoJump(element, nextID) {
    // isNaN = is not a number
    if (isNaN(element.value)) {
        element.value = '';
    }
    if (element.value.length == element.maxLength) {
        document.getElementById(nextID).focus();
    }
}

document.getElementById('abort').addEventListener('click', function(){
    var abort = confirm('Are you sure to abort this payment?');
    if (abort) {
        // reload the parent page that opened the current page
        window.opener.location.reload(true);
        window.close();
    }
})


