<?php
    session_start();
    $accID = $_SESSION['accID'];

    include("connect.php");

$sql = "UPDATE hosts SET 
bankName = '$_POST[bankName]',
bankAccNo = '$_POST[bankAccNum]',
bankAccName = '$_POST[bankAccName]'

WHERE hostID='$_POST[hostID]';";

if ($mysqli->query($sql)) {

    echo '<script>alert("Record Saved!");
    window.location.href= "host.php"; 
    </script>';
}
else { echo '<script>alert ("Could not upload or no changes made!"); window.location.href="host.php"; </script>'; 
}
?>