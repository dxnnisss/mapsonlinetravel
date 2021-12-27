<?php
    session_start();
    $accID = $_SESSION['accID'];
    require_once 'connect.php';

    $uName = escaped($_POST['uName']);
    // escape spaces and dashes
    $uContact = str_replace(' ', '',escaped($_POST['uContact']));
    $uContact = str_replace('-', '',$uContact);

    $uGender = escaped($_POST['uGender']);
    $uDOB = escaped($_POST['uDOB']);
    $about = escaped($_POST['about']);

    // case of user uploaded no file
    if ($_FILES['uPicture']['name'] == NULL) {
        $sql = "UPDATE users SET 
            uName = ?,
            uContact = ?,
            uGender = ?,
            uDOB = ?,
            about = ?
            WHERE accID= '$accID'";

        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param('sssss', $uName, $uContact, $uGender, $uDOB, $about);
        $stmt -> execute();
    }
    // case of user uploaded a picture
    else {
        $sql = "UPDATE users SET 
            uName = ?,
            uContact = ?,
            uGender = ?,
            uDOB = ?,
            uPicture = ?,
            about = ?
            WHERE accID= '$accID'";

        $image = $_FILES['uPicture']['tmp_name'];
        $uPicture = file_get_contents($image);

        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param('ssssss', $uName, $uContact, $uGender, $uDOB, $uPicture, $about);
        $stmt -> execute();
    }

    if ($mysqli -> affected_rows == 1) {
        echo "<script>alert('Successfully updated!'); window.location.href='myInfo.php';</script>";
    }
    else {
        echo "<script>alert('Error occured or no changes has been made!'); window.location.href='myInfo.php';</script>";
    }
    $mysqli -> close();
?>