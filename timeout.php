<?php
    // considered inactive after x seconds
    $inactivity = 10;
    // calculate the duration in seconds after since activity
    $duration = time() - $_SESSION['lastActivity'];

    // destroy session if exceed inactivity period
    if ($duration > $inactivity) {
        session_destroy();
        header('location: index.php');
    }

    // reassign the current time into the variable
    $_SESSION['lastActivity'] = time();
?>