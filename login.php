<?php
    session_start();
    require_once 'connect.php';
    $accID = escaped($_POST['accID']);
    $password = escaped($_POST['password']);
    $sql = "SELECT accID, role, accStatus FROM accounts WHERE accID='$accID' AND password='$password'";
    $result = $mysqli -> query($sql);

    if ($result -> num_rows != 1) {
        session_destroy();
        echo "<script>alert('Wrong credentials!');";
        echo "window.location.href='index.php';</script>";
    }

    else {
        $row = $result -> fetch_assoc();

        if ($row['accStatus'] != 'active') {
            session_destroy();
            echo "<script>alert('Account deactivated.\\nPlease contact us for more info.');";
            echo "window.location.href='index.php';</script>";
        }

        // filter the type of user from here
        $_SESSION['role'] = $row['role'];
        $_SESSION['accID'] = $row['accID'];
        // $_SESSION['lastActivity'] = time();

        $accID = $_SESSION['accID'];

        switch ($_SESSION['role']) {
            case 'admin':
                $colName = 'adminID';
                $tableName = 'admin';
                $sql = "SELECT $colName FROM $tableName WHERE accID='$accID'";

                $result = $mysqli -> query($sql);
                $row = $result -> fetch_assoc();
                $_SESSION['adminID'] = $row['adminID'];

                // run bgMod to cancel idle bookings and update status
                require_once 'bgMod.php';

                echo "<script>window.location.href='adminManageAccount.php';</script>";
                break;
            
            case 'host':
                $colName = 'hostID';
                $tableName = 'hosts';
                $sql = "SELECT $colName FROM $tableName WHERE accID='$accID'";

                $result = $mysqli -> query($sql);
                $row = $result -> fetch_assoc();
                $_SESSION['hostID'] = $row['hostID'];

                echo "<script>window.location.href='host.php';</script>";
                break;

            case 'user';
                $colName = 'userID';
                $tableName = 'users';
                $sql = "SELECT $colName FROM $tableName WHERE accID='$accID'";

                $result = $mysqli -> query($sql);
                $row = $result -> fetch_assoc();
                $_SESSION['userID'] = $row['userID'];

                echo "<script>window.location.href='myInfo.php';</script>";
                break;
        }
    }
    $mysqli -> close();
?>