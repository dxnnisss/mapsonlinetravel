
<?php
session_start();
include("connect.php");

$listingID = $_POST['id'];

$sql = "UPDATE listings SET 
title='$_POST[propertyName]', 
location='$_POST[propertyLocation]', 
description='$_POST[propertyDescription]', 
rate='$_POST[propertyRate]', 
guest='$_POST[propertyCapacity]'

WHERE listingID = $listingID";

if ($mysqli->query($sql)) {

    $totalNewPic = count($_FILES['newPropertyImg']['tmp_name']);

    $delPhoto = $_POST["removePhoto"];

    if ($delPhoto == "Yes") {
        $sql2 = "DELETE FROM addphotos WHERE listingID = $listingID";
            $stmt1 = $mysqli->prepare($sql2);
            $stmt1 -> execute();

            if ($totalNewPic != 0) {
    
                for ($i=0; $i<$totalNewPic; $i++) {
                    
                    $image = $_FILES['newPropertyImg']['tmp_name'][$i];
                    if ($image != "") {
                        $pPicture = file_get_contents($image);
                    
                        $listingID = escaped($_POST['id']);
        
                        $sql3 = "INSERT INTO addphotos (listingID, photo) VALUES (?,?)";
                        
                        $stmt2 = $mysqli->prepare($sql3);
                        $stmt2 -> bind_param("ss", $listingID, $pPicture);
                        $stmt2 -> execute();
                    }
                    else {
                        continue;
                    }  
                }
            } 
            else {
                echo '<script>alert("Record Saved");window.location.href="hostManageProperty.php";</script>';
            }
    }
    else {
        if ($totalNewPic != 0) {
    
            for ($i=0; $i<$totalNewPic; $i++) {
                
                $image = $_FILES['newPropertyImg']['tmp_name'][$i];
                if ($image != "") {
                    $pPicture = file_get_contents($image);
                
                    $listingID = escaped($_POST['id']);
    
                    $sql3 = "INSERT INTO addphotos (listingID, photo) VALUES (?,?)";
                    
                    $stmt2 = $mysqli->prepare($sql3);
                    $stmt2 -> bind_param("ss", $listingID, $pPicture);
                    $stmt2 -> execute();
                }
                else {
                    continue;
                }  
            }
        } 
        else {
            echo '<script>alert("Record Saved");window.location.href="hostManageProperty.php";</script>';
        }

    }
    
    $proTag = isset($_POST['propertyTag']) ? $_POST['propertyTag'] : '';
    if ($proTag == "") {
        echo '<script>alert("Record Saved");window.location.href="hostManageProperty.php"</script>';
    }
    else {
        $sqlTags = "DELETE FROM listingtag WHERE listingID = $listingID";
        $tagStmt = $mysqli->prepare($sqlTags);
        $tagStmt -> execute();
        
        
        foreach($proTag as $key => $value) {
        $mysqli->query("INSERT INTO listingtag (listingID, tagID) VALUES ($listingID, $value)");
        echo '<script>alert("Record Saved");window.location.href="hostManageProperty.php"</script>';
        }
    }   
    
}
else { 
    echo '<script>alert ("Could not upload or no changes made!");window.location.href="hostManageProperty.php" ; </script>'; 
}


?>