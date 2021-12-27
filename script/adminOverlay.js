
// remove any overlaying elements, set all display to none
function backToNormal() {
    let overlays = ['vpGreyOut', 'generalOverlay', 'banConfirm','actConfirm','disConfirm','adminOverlay'];
    for (i = 0; i < overlays.length; i++) {
        if (document.getElementById(overlays[i])){
            document.getElementById(overlays[i]).style.display = 'none';
        }
        
    }
}
// changing the display to block the rest is flex at below
function greyOut() {
    document.getElementById('vpGreyOut').style.display = 'block';
}

function generalOverlay() {
    greyOut();
    document.getElementById('generalOverlay').style.display = 'flex';
}

function ban() {
    backToNormal();
    greyOut();
    document.getElementById('banConfirm').style.display = 'flex';
}

function activate() {
    backToNormal();
    greyOut();
    document.getElementById('actConfirm').style.display = 'flex';
}


function adminOverlay() {
    greyOut();
    document.getElementById('adminOverlay').style.display = 'flex';
}

// by using function to redirect the value to the specific page
function redAction(accID,action,role,id){
    window.location.href='adminUserStatuschange.php?accID='+ accID + '&action=' + action +'&type_role=' + role + '&id=' + id;
}