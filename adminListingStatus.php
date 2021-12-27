<?php
include("connect.php");

$listingID= $_GET['listingID'];
$accID=$_GET['accID'];
$listingStatus=$_GET['listStatus'];

if($listingStatus == 'activated'){
    $sql = "UPDATE listings SET listingStatus='deactivated' WHERE listingID = $listingID";
}
elseif($listingStatus =='deactivated'){
    $sql = "UPDATE listings SET listingStatus='activated' WHERE listingID = $listingID";
}
else {
    echo '<script>alert("Error occured!!!");</script>';
}

if($mysqli -> query($sql) === TRUE){
    echo '<script>alert("Record updated successfully");</script>';
} 
else {
  echo '<script>alert("Error updating record: ");</script>' . $mysqli -> error;
}

echo '<script> window.location.href = "adminListingDetails.php?accID='.$accID.'&listingID='.$listingID.'"; </script>'
?>