<?php
    session_start();
    
    $accID = $_SESSION['accID'];

    include("connect.php");

    $hName = escaped($_POST['hostName']);
    $hContact= str_replace(' ', '', escaped($_POST['hostContact']));
    $hContact = str_replace('-', '', $hContact);
    $hGender= escaped($_POST['hostGender']); 
    $hDOB=escaped($_POST['hostDOB']); 

    if ($_FILES['hostpic']['name'] == NULL) {
        $sql = "UPDATE hosts SET
            hName = ?,
            hContact = ?,
            hGender = ?,
            hDOB = ?
            WHERE accID = '$accID'";

        $stmt= $mysqli->prepare($sql);
        $stmt->bind_param("ssss",$hName, $hContact, $hGender, $hDOB);
        $stmt->execute();
    }
    else {
        $sql = "UPDATE hosts SET
            hName = ?,
            hContact = ?,
            hGender = ?,
            hDOB = ?,
            hPicture = ?
            WHERE accID = '$accID'";
            
        $image = $_FILES['hostpic']['tmp_name'];
        $hPicture= file_get_contents($image);

        $stmt= $mysqli->prepare($sql);
        $stmt->bind_param("sssss",$hName, $hContact, $hGender, $hDOB, $hPicture);
        $stmt->execute();

    }

    if($mysqli -> affected_rows == 1){  
        echo '<script>alert("Record Saved!");
        window.location.href= "host.php"; 
        </script>';
    }
    else { echo '<script>alert ("Could not upload or no changes made!"); window.location.href="host.php"; </script>'; }
    ?>