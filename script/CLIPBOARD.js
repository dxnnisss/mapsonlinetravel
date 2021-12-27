
$( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );

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
		return '+1y';
	}
}

let checkIn = document.getElementById('listingCheckIn');
let checkOut = document.getElementById('listingCheckOut');
  
$("#listingCheckIn").datepicker({beforeShowDay: disableDates , minDate : 0, dateFormat: "yy-mm-dd", 
	//upon selection     
	onSelect: function(){
		const max = getNearestDateFromArray();
		$("#listingCheckOut").datepicker("option","minDate", $("#listingCheckIn").datepicker("getDate")); //2nd datepicker to set min value for 1st datepicker
		$("#listingCheckOut").datepicker("option","maxDate", max);
	}
});
  
$("#listingCheckOut").datepicker({beforeShowDay: disableDates , minDate : 0 , dateFormat: "yy-mm-dd"});

      
//   $("#listingCheckOut").datepicker({beforeShowDay: disableDates , minDate : 0 , dateFormat: "yy-mm-dd"});
    

// checkOut.addEventListener('click', function() {
//     if (checkIn.value != null) {
//         var checkInParsed = Date.parse(checkIn.value);
//         for (let i = 0; i < dateCheck.length; i++) {
//             var value = dateCheck[i];
//             var parsedValue = Date.parse(value);
//             let limit = false;
//             if (parsedValue >= checkInParsed) {
//                 $("#listingCheckOut").datepicker({
//                     beforeShowDay: disableDates , 
//                     minDate : checkIn.value, 
//                     maxDate: value, 
//                     dateFormat: "yy-mm-dd"});
//                 limit = true;
//                 break;
//             }
//         }

//         if (limit == false) {
//             $("#listingCheckOut").datepicker({
//                 beforeShowDay: disableDates , 
//                 minDate : checkIn.value,
//                 maxDate: '2020-08-18',
//                 dateFormat: "yy-mm-dd"});
//         }
//     }
// })

getElementById
document.getElementsByClassName('jom').style.fontSize = '1.1rem';