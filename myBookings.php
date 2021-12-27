<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
        header('location: index.php');
    }

    require_once 'connect.php';
    $userID = $_SESSION['userID'];
    $sql = "SELECT * FROM bookings b INNER JOIN listings l 
        ON b.listingID = l.listingID 
        WHERE b.userID = '$userID'";
    $result = $mysqli -> query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="style/myBookings.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'userHeader.php';
    ?>
    <main>
        <h1>My Bookings</h1>
        <hr>
        <form id="search" method="post">
            Search: <input type="text" name="keyword" placeholder="Booking ID">
            <button name="searchBtn" type="submit">GO</button>
        </form>

        <div id="cardContainer">
            <?php
                if (isset($_POST['searchBtn'])) {
                    $keyword = $_POST['keyword'];
                    $sql .= " AND b.bookingID LIKE '%$keyword%'";
                    $result = $mysqli -> query($sql);
                }

                if ($result -> num_rows == 0 ) {
                    echo '<div id="noRecord">No record found!</div>';
                }
                
                
                else {
                    while ($row = $result -> fetch_assoc()) {
                        echo '<div class="bookingCard">
                            <div>
                            <div class="itemTitle">Booking ID:</div>
                            <div class="itemValue">';

                        echo $row['bookingID'];

                        echo '</div></div><div>
                            <div class="itemTitle">Stay:</div>
                            <div class="itemValue">';

                        echo $row['title'];

                        echo '</div></div><div>
                            <div class="itemTitle">Booked Date:</div>
                            <div class="itemValue">';

                        // creating date object for startDate and endDate
                        $start = strtotime($row['startDate']);
                        $end = strtotime($row['endDate']);
                        
                        // 'Y-m-d' ---> 2021-01-01
                        $startDate = date('Y-m-d', $start);
                        $endDate = date('Y-m-d', $end);

                        echo $startDate . ' to ' . $endDate;

                        echo '</div></div><div>
                        <div class="itemTitle">Status:</div>
                        <div class="itemValue">';

                        // first char to upper case
                        echo ucfirst($row['bookingStatus']);

                        echo '</div></div><div>
                        <div class="itemTitle">Amount:</div>
                        <div class="itemValue">';

                        // calculate the differences
                        $duration = $end - $start;
                        // one day = 86400 seconds, round off the duration to strip decimals
                        $days = round($duration / 86400);
                        // display amount as RM xxx.xx
                        $amount = 'RM ' . number_format(($days * intval($row['rate'])), 2);

                        echo $amount; 

                        echo '</div></div><div class="flex-c-c"><a href="';
                        echo 'bookingDetails.php?bookingID=' . $row['bookingID'];

                        echo '"class="actionBtn">CHECK</a></div></div>';
                    }
                }
            ?>
        </div>

    </main>
    
    <?php
        // footer section 
        require_once 'masterFooter.php';
        $mysqli -> close();
    ?>
    <script src="script/master.js"></script>
</body>
</html>