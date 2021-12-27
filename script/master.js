// remove any overlaying elements, set all display to none
function backToNormal() {
    let overlays = ['vpGreyOut', 'generalOverlay', 'login', 'signup', 'joinAsHost', 'userOverlay'];
    for (i = 0; i < overlays.length; i++) {
        document.getElementById(overlays[i]).style.display = 'none';
    }
}

// FOR MASTER GENERAL --- NO ACTIVE USER SESSION
function greyOut() {
    document.getElementById('vpGreyOut').style.display = 'block';
}

function generalOverlay() {
    greyOut();
    document.getElementById('generalOverlay').style.display = 'flex';
}

function login() {
    backToNormal();
    greyOut();
    document.getElementById('login').style.display = 'flex';
}

function signup() {
    backToNormal();
    greyOut();
    document.getElementById('signup').style.display = 'flex';
}

function joinAsHost() {
    backToNormal();
    greyOut();
    document.getElementById('joinAsHost').style.display = 'flex';
}

// FOR MASTER USER --- WITH ACTIVE USER SESSION
function userOverlay() {
    greyOut();
    document.getElementById('userOverlay').style.display = 'flex';
}

