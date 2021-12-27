<?php
    session_start();
    require_once 'connect.php';
    $accID = $_POST['accID'];
    $sql = "SELECT accID FROM accounts WHERE accID='$accID'";
    $result = $mysqli -> query($sql);

    // check if email aka username is taken
    if ($result -> num_rows != 0) {
        echo "<script>alert('This email is taken. Nice try!');";
        echo "window.location.href='index.php';</script>";
    }

    else {
        $sql1 = "INSERT INTO accounts (accID, role, password) VALUES (?, ?, ?);";
        $stmt1 = $mysqli -> prepare($sql1);
        $accID = $mysqli -> real_escape_string($_POST['accID']);
        $role = 'user';
        $password = $mysqli -> real_escape_string($_POST['password']);
        $stmt1 -> bind_param('sss', $accID, $role, $password);

        $sql2 = "INSERT INTO users (accID, uName, uDOB) VALUES (?, ?, ?);";
        $stmt2 = $mysqli -> prepare($sql2);
        $uName = escaped($_POST['uName']);
        $uDOB = escaped($_POST['uDOB']);
        $stmt2 -> bind_param('sss', $accID, $uName, $uDOB);
        
        if ($stmt1 -> execute() && $stmt2 -> execute()) {
            $_SESSION['role'] = 'user';
            $_SESSION['accID'] = $accID;
            $_SESSION['userID'] = $mysqli -> insert_id;
            // $_SESSION['lastActivity'] = time();
            echo "<script>alert('Welcome to MAPS, " . $_POST['uName'] . "!');";
            echo "window.location.href='myInfo.php';</script>";
        }
    }
    $mysqli -> close();
?>