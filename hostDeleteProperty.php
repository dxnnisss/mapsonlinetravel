<?php 
    include("connect.php");
    $id = intval($_GET['id']);
   
    $result = $mysqli->query("UPDATE listings
    SET listingStatus = 'deactivated' 
    WHERE listingID=$id");

    if($mysqli -> affected_rows == 1){ 
        echo '<script>alert("Record Saved");
        window.location.href= "hostManageProperty.php"; 
        </script>';
    }
    else { echo '<script>alert ("Error!"); window.location.href="host.php"; </script>'; 
    }
    ?>