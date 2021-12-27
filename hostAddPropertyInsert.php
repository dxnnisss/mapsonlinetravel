<?php 
session_start();
include("connect.php"); 
$hostID = $_SESSION['hostID'];

$sql = "INSERT INTO listings (hostID, title, location, description, rate, guest) 
VALUES ('$hostID', '$_POST[propertyName]', '$_POST[propertyLocation]','$_POST[propertyDescription]', '$_POST[propertyRate]', '$_POST[propertyCapacity]')";

if ($mysqli->query($sql)){

    echo '<script>alert("1 record added! Edit your property to add more to attract renters!");
    window.location.href= "hostManageProperty.php"; 
    </script>';
}

else {
    echo '<script>alert("Something went wrong!"); window.location.href= "hostManageProperty.php";</script>';
}


?>
