<?php
    session_start();
    if (!isset($_SESSION['role']) || !isset($_GET['bookingID']) || $_SESSION['role'] != 'user') {
        header('location: myBookings.php');
    }

    require_once 'connect.php';

    // to check whether the booking belongs to the suer
    $userID = $_SESSION['userID'];
    $sql = "SELECT DISTINCT bookingID FROM bookings WHERE userID='$userID'";
    $result = $mysqli -> query($sql);
    $correctUser = false;
    while ($row = $result -> fetch_assoc()) {
        if ($row['bookingID'] == $_GET['bookingID']) {
            $correctUser = true;
            break;
        }
    }
    if (!$correctUser) {
        echo "<script>alert('This booking doesn\'t belongs to you!');
            window.location.href = 'myBookings.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="style/bookingDetails.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'userHeader.php';
    ?>
    <main>
        <h1>Your Booking Details</h1>
        <hr>

        <div id="mainDiv1" class="flex-col flex-sa-c flex-fs">

            <!-- User Information -->
            <div class="subTitle"><h2>User Information</h2><hr></div>
            <div class="subMain flex-sa-c flex-fs flex-col">
                <?php
                    $accID = $_SESSION['accID'];
                    // rename column name in sql
                    $sql = "SELECT accID AS 'Email / Username', 
                            uName AS 'Name', 
                            uContact AS 'Contact', 
                            uGender AS 'Gender', 
                            uDOB AS 'Date of Birth'
                            FROM users WHERE accID='$accID'";
                    $userResult = $mysqli -> query($sql);
                    $row = $userResult -> fetch_assoc();

                    foreach ($row as $label => $value) {
                        // change null value
                        if ($value == '') {
                            $value = 'Not Available';
                        }
                        // format casing
                        if ($label == 'Gender') {
                            $value = ucfirst($value);
                        }
                        echo '<div class="item flex-sa-c"><div class="itemLabel">';
                        echo $label;
                        echo '</div><div class="itemValue">';
                        echo $value;
                        echo '</div></div>';
                    }
                ?>
            </div>

            <!-- Booking Information -->
            <div class="subTitle"><h2>Booking Information</h2><hr></div>
            <div class="subMain flex-sa-c flex-fs flex-col">
                <?php
                    $bookingID = $_GET['bookingID'];
                    // rename column name in sql
                    $sql = "SELECT listingID,
                            bookingID AS 'Booking ID', 
                            bookingDT AS 'Booking Made On', 
                            startDate AS 'Check-in Date', 
                            endDate AS 'Check-out Date', 
                            bookingStatus AS 'Booking Status'
                            FROM bookings WHERE bookingID='$bookingID'";
                    $userResult = $mysqli -> query($sql);
                    $row = $userResult -> fetch_assoc();

                    foreach ($row as $label => $value) {
                        // skip listingID as it no need to be displayed
                        if ($label == 'listingID') {
                            $listingID = $value;
                            continue;
                        }
                        // format casing, add duration and amount before status
                        if ($label == 'Booking Status') {
                            $bookingStatus = $value;
                            $value = ucfirst($value);

                            // creating date object for startDate and endDate
                            $start = strtotime($row['Check-in Date']);
                            $end = strtotime($row['Check-out Date']);
                            // calculate the differences
                            $duration = $end - $start;
                            // one day = 86400 seconds 
                            $days = round($duration / 86400);

                            // cannot use GET to pass from previous page, can mod
                            $sql = "SELECT rate FROM listings WHERE listingID = '$listingID'";
                            $result = $mysqli -> query($sql);
                            $row = $result -> fetch_assoc();

                            // round off the duration to strip decimals
                            $amount = 'RM ' . number_format(($days * intval($row['rate'])), 2);


                            // DURATION DURATION DURATION
                            echo '<div class="item flex-sa-c"><div class="itemLabel">';
                            echo 'Duration';
                            echo '</div><div class="itemValue">';
                            echo $days . ' day(s)';
                            echo '</div></div>';


                            // AMOUNT AMOUNT AMOUNT
                            echo '<div class="item flex-sa-c"><div class="itemLabel">';
                            echo 'Amount';
                            echo '</div><div class="itemValue">';
                            echo $amount;
                            echo '</div></div>';
                        }
                        echo '<div class="item flex-sa-c"><div class="itemLabel">';
                        echo $label;
                        echo '</div><div class="itemValue">';
                        echo $value;
                        echo '</div></div>';
                    }
                ?>
            </div>

            <!-- Payment Information (if paid) -->
            <?php
                if ($bookingStatus == 'confirmed' || $bookingStatus == 'completed') {
                    echo '<div class="subTitle"><h2>Payment Information</h2><hr></div>
                            <div class="subMain flex-sa-c flex-fs flex-col">';
                    
                    $sql = "SELECT paymentID AS 'Payment ID',
                            ctCard AS 'Card Number',
                            chName AS 'Name on Card',
                            expiry AS 'Good Thru',
                            amount AS 'Debited Amount'
                            FROM payments WHERE bookingID='$bookingID'";
                    $paymentResult = $mysqli -> query($sql);
                    $row = $paymentResult -> fetch_assoc();

                    foreach ($row as $label => $value) {
                        // cyphering the ctcard number
                        if ($label == 'Card Number') {
                            $value = '**** - **** - **** - ' . substr($value, 12);
                        }

                        // process expiry date
                        if ($label == 'Good Thru') {
                            // gmdate(intended format, datetime value)
                            $paymentDT = gmdate('F Y',strtotime($value));
                            $value = $paymentDT;
                        }

                        if ($label == 'Debited Amount') {
                            $value = 'RM ' . number_format(intval($value), 2);
                        }

                        echo '<div class="item flex-sa-c"><div class="itemLabel">';
                            echo $label;
                            echo '</div><div class="itemValue">';
                            echo $value;
                            echo '</div></div>';
                    }
                    
                    echo '</div>';
                }
            ?>

            <!-- Stay Information -->
            <div class="subTitle"><h2>Stay Information</h2><hr></div>
            <div class="subMain flex-sa-c flex-fs flex-col">
                <?php
                        // rename column name in sql
                        $sql = "SELECT l.title AS 'Stay',
                                l.location AS 'Location', 
                                l.rate AS 'Daily Rate', 
                                l.guest AS 'Guest Capacity', 
                                h.hName AS 'Host Name', 
                                h.hContact AS 'Host Contact'
                                FROM listings l INNER JOIN hosts h ON l.hostID = h.hostID
                                WHERE l.listingID='$listingID'";
                        $userResult = $mysqli -> query($sql);
                        $row = $userResult -> fetch_assoc();

                        foreach ($row as $label => $value) {
                            // display amount as RM xxx.xx
                            if ($label == 'Daily Rate') {
                                
                                $value = 'RM ' . number_format((intval($value)), 2);
                            }
                            // display pax for guest capacity
                            else if ($label == 'Guest Capacity') {
                                $value .= ' pax';
                            }
                            // display text str for null field
                            else if ($label == 'Host Contact') {
                                if ($value == '') {
                                    $value = 'Not Available';
                                }
                            }

                            echo '<div class="item flex-sa-c"><div class="itemLabel">';
                            echo $label;
                            echo '</div><div class="itemValue">';
                            echo $value;
                            echo '</div></div>';
                        }
                    ?>
            </div>

            <!-- Button Div -->
            <div class="flex-c-c btnDiv">
                <?php
                    // send a variable to JS
                    echo '<script>var bookingID =' . $bookingID . ';</script>';
                    
                    $pay = "payment.php?bookingID=$bookingID";
                    $review = "review.php?bookingID=$bookingID";

                    $buttonID = ['pay', 'cancel', 'review', 'back'];
                    $href = [$pay, '', $review, 'myBookings.php'];
                    $text = ['Pay Now', 'Cancel Booking', 'Review', 'Back'];

                    // using if block to decide buttons to display based on booking status
                    if ($bookingStatus == 'booked') {
                        $action = [0, 1, 3];
                    }
                    else if ($bookingStatus == 'confirmed') {
                        $action = [1, 3];
                    }
                    else if ($bookingStatus == 'cancelled') {
                        $action = [3];
                    }
                    else if ($bookingStatus == 'completed') {
                        $action = [2, 3];
                    }

                    // after deccided buttons that should display, echo them
                    foreach($action as $i) {
                        echo '<a id="' . $buttonID[$i] . '" class="actionBtn" href="' . $href[$i] . '">' . $text[$i] . '</a>';
                    }

                    // this block is to cancel the booking, if triggered
                    if (isset($_GET['realCancel']) && $_GET['realCancel'] == 'y') {
                        $sql = "UPDATE bookings SET bookingStatus = 'cancelled' WHERE bookingID = '$bookingID'";
                        $mysqli -> query($sql);
                        if ($mysqli -> affected_rows == 1) {
                            echo "<script>alert('Booking cancelled successfully.');
                                    window.location.href = 'bookingDetails.php?bookingID=$bookingID';
                                    </script>";
                        }
                    }
                ?>
            </div>
        </div>
    </main>
    
    <?php
        // footer section 
        require_once 'masterFooter.php';
        $mysqli -> close();
    ?>
    <script src="script/master.js"></script>
    <script src="script/bookingDetails.js"></script>
</body>
</html>