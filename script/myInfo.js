function enableEdit() {
    document.getElementById('userEditProfile').style.display = 'none';
    document.getElementById('userSaveProfile').style.display = 'block';

    document.getElementById('uPicture').removeAttribute('disabled');
    document.getElementById('uName').removeAttribute('readonly');
    document.getElementById('uDOB').removeAttribute('readonly');
    document.getElementById('male').removeAttribute('disabled');
    document.getElementById('female').removeAttribute('disabled');
    document.getElementById('uContact').removeAttribute('readonly');
    document.getElementById('about').removeAttribute('readonly');
}


var upload = document.getElementById('uPicture');
var display = document.getElementById('uPicDisplay');

// FileReader: similar to file_get_contents() in PHP
var reader = new FileReader();

upload.addEventListener('change', function () {
    // getting the dataURL content of uplaoded file (data:image/jpg;base64,)
    reader.readAsDataURL(upload.files[0]);
    
    // when the reader finish reading and load the file, run this function
    reader.onload = function () {
        display.src = reader.result;
    } 
})
    