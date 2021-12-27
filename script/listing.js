//Datepicker JS
function disableDates(date){
  var string = jQuery.datepicker.formatDate("yy-mm-dd", date);
  return [ dateCheck.indexOf(string) == -1 ]
}

function getNearestDateFromArray() {
  if (checkIn.value != null) {
      var checkInParsed = Date.parse(checkIn.value);
      for (let i = 0; i < dateCheck.length; i++) {
          var value = dateCheck[i];
          var parsedValue = Date.parse(value);
          if (parsedValue >= checkInParsed) {
              return value;
          }
      }
      return null;
  }
}

function formatDate(date) {
  var d = new Date(date),
      month = '' + (d.getMonth() + 1);
      day = '' + d.getDate();
      year = d.getFullYear();

  if (month.length < 2) {
    month = '0' + month;
  }
  if (day.length < 2) {
    day = '0' + day;
  }
  return [year, month, day].join('-');
}

// sort the date array ascendingly
dateCheck.sort();

let checkIn = document.getElementById('listingCheckIn');
let checkOut = document.getElementById('listingCheckOut');

$("#listingCheckIn").datepicker({beforeShowDay: disableDates, minDate: 0, maxDate: '+1y', dateFormat: "yy-mm-dd",
  // upon selection     
  onSelect: function() {
      let max = getNearestDateFromArray();
      if (max == null) {
        // if no bookings in middle, max interval = 3 months
        let minDate = new Date($("#listingCheckIn").datepicker("getDate"));
        minDate.setMonth(minDate.getMonth() + 3);
        max = formatDate(minDate);
      }
      $("#listingCheckOut").datepicker("option","minDate", $("#listingCheckIn").datepicker("getDate")); // 2nd datepicker to set min value for 1st datepicker
      $("#listingCheckOut").datepicker("option","maxDate", max);
  }
});

$("#listingCheckOut").datepicker({beforeShowDay: disableDates, minDate: 0, dateFormat: "yy-mm-dd"});

//Picture slideshow//

var imageIndex = 1;
changeImages(imageIndex);

function nextImage(n) {
  changeImages(imageIndex += n);
}

function currentImage(n) {
  changeImages(imageIndex = n);
}

function changeImages(n) {
  var i;
  var images = document.getElementsByClassName("myImages");
  var dots = document.getElementsByClassName("dot");
  if (n > images.length) {imageIndex = 1}    
  if (n < 1) {imageIndex = images.length}
  for (i = 0; i < images.length; i++) {
      images[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  images[imageIndex-1].style.display = "block";  
  dots[imageIndex-1].className += " active";
}







// function disableDates(date){
//   alert('hi')
//   var string = jQuery.datepicker.formatDate("yy-mm-dd", date);
//   return [ dateCheck.indexOf(string) == -1 ]
//   }


//   $("#listingCheckIn").datepicker({beforeShowDay: disableDates , minDate : 0, dateFormat: "yy-mm-dd",
//       showOn: "both",  
//       //upon selection     
//       onSelect: function(dateText, inst){
//          $("#listingCheckOut").datepicker("option","minDate",
//          $("#listingCheckIn").datepicker("getDate")); //2nd datepicker to set min value for 1st datepicker
//       }
//     });
    
//     $("#listingCheckOut").datepicker({beforeShowDay: disableDates , minDate : 0 , dateFormat: "yy-mm-dd",
//       onSelect: function(dateText, inst){
//         $("#listingCheckOut").datepicker("option","minDate",
//         $("#listingCheckIn").datepicker("getDate")); //2nd datepicker to set min value for 1st datepicker
//    }});


// let checkIn = document.getElementById('listingCheckIn');
// let checkOut = document.getElementById('listingCheckOut');


// // $("#listingCheckOut").datepicker({beforeShowDay: disableDates , minDate : 0 , maxDate: '2021-11-27', dateFormat: "yy-mm-dd"});



// checkOut.addEventListener('click', function() {
//     if (checkIn.value != null) {
//       var checkInParsed = Date.parse(checkIn.value);
//       for (let i = 0; i < dateCheck.length; i++) {
//         var value = dateCheck[i];
//         var parsedValue = Date.parse(value);
//         let limit = false;
//         if (parsedValue >= checkInParsed) {
//             $("#listingCheckOut").datepicker({beforeShowDay: disableDates , minDate : 0 , maxDate: value, dateFormat: "yy-mm-dd"});
//             limit = true;
//             break;
//         }
//       }
//     }

//     if (limit == false) {
//       $("#listingCheckOut").datepicker({beforeShowDay: disableDates , minDate : 0 , maxDate: '2021-12-31', dateFormat: "yy-mm-dd"});
//     }
// })





