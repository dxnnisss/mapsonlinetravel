<?php

require_once "connect.php";

$accID = $_GET['accID'];
$action_check=$_GET['action'];
$role =$_GET['type_role'];

// changing account status
if($action_check == 'active'){
    $sql = "UPDATE accounts SET accStatus = 'active' WHERE accID = '$accID'";
    
    $after_status = 'active';
}

elseif($action_check == 'banned'){
    $sql = "UPDATE accounts SET accStatus ='banned' WHERE accID = '$accID' ";
    if($role == 'host'){
        // when account being banned host listing will deactivated together
        echo'alert("checkpoint")';
        $id =$_GET['id'];
        $sql_listing = "UPDATE listings SET listingStatus ='deactivated' WHERE hostID =$id ";
        $mysqli -> query($sql_listing);
    }
    $after_status = 'banned';
}

// to prompt the admin that the sql is working
if($mysqli -> query($sql) === TRUE){
    echo '<script>alert("Record updated to '.$after_status.' successfully");</script>';
}
else {
  echo '<script>alert("Error updating record: ");</script>' . $mysqli -> error;
  
}
// relocate the pages
echo '<script> window.location.href = "adminUserAccount.php?accID='.$accID.'&type_role='.$role.'"; </script>'
?>