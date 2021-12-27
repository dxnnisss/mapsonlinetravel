<?php
    require_once 'connect.php';

    // set the timezone to gmt +8
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $today = date('Y-m-d');

    // current date minus 3 day
    // if bookingDT still smaller than this, means more than 3 days already
    $minDate = date('Y-m-d H:i:s', strtotime('-3 days'));

    // select unpaid booking that more than 72 hours
    $sql = "UPDATE bookings 
            SET bookingStatus = 'cancelled' 
            WHERE bookingID IN (SELECT * FROM 
                (SELECT bookingID 
                FROM bookings 
                WHERE bookingStatus = 'booked' 
                AND bookingDT <= '$minDate') temp)";

    $mysqli -> query($sql);
    $bookingCancelled = $mysqli -> affected_rows;
    if ($bookingCancelled == -1) {
        echo "<script>alert('Error occured while cancelling idle booking(s).');</script>";
    }

    // transfer credit to host for completed bookings
    $sql = "SELECT b.bookingID, p.amount, l.hostID 
            FROM bookings b INNER JOIN payments p 
            ON b.bookingID = p.bookingID 
            INNER JOIN listings l 
            ON l.listingID = b.listingID 
            INNER JOIN hosts h 
            ON h.hostID = l.hostID
            WHERE b.bookingStatus = 'confirmed'
            AND b.startDate <= '$today'";

    $result = $mysqli -> query($sql);
    while ($row = $result -> fetch_assoc()) {
        $bookingID = $row['bookingID'];
        $hostID = $row['hostID'];
        $credit = intval($row['amount']);

        $sql = "SELECT walletBalance FROM hosts WHERE hostID = '$hostID'";
        $balance = $mysqli -> query($sql);
        $balance = $balance -> fetch_assoc();
        $balance = $balance['walletBalance'];
        $balance = intval($balance) + $credit;
        
        $sql = "UPDATE hosts SET walletBalance = $balance WHERE hostID = '$hostID'";
        $mysqli -> query($sql);
    }

    // update confirmed booking to completed once it commences
    $sql = "UPDATE bookings 
            SET bookingStatus = 'completed'
            WHERE bookingStatus = 'confirmed'
            AND startDate <= '$today'";

    $mysqli -> query($sql);
    $bookingCompleted = $mysqli -> affected_rows;
    if ($bookingCompleted == -1) {
        echo "<script>alert('Error occured while updating completed booking(s).');</script>";
    }

    echo "<script>alert('BACKGROUND MODIFICATION\\n\\nBooking CANCELLED: $bookingCancelled\\nBooking COMPLETED: $bookingCompleted\\n\\n-1: ERROR || 0: NO MOD APPLIED');</script>";

    $mysqli -> close();
?>
    
