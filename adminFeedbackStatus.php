<?php
include 'connect.php';
// update status of the review ticket
$ticketStatus = $_GET['ticketStatus'];
$ticketID = $_GET['ticketID'];
$sql="UPDATE contactus SET ticketStatus = '$ticketStatus' WHERE ticketID = '$ticketID'";

if($mysqli -> query($sql) === TRUE){
    echo '<script>alert("Record updated to '.$ticketStatus.' successfully");</script>';
} 
else {
  echo '<script>alert("Error updating record: ");</script>' . $mysqli -> error;
}
echo '<script> window.location.href = "adminFeedbackDetails.php?ticketID='.$ticketID.'"; </script>'
?>
