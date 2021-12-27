<?php
    session_start();
    session_destroy();
    echo "<script>alert('You have been logged out. See you!');";
    echo "window.location.href = 'index.php'</script>";
?>