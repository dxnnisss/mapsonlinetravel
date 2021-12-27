<?php require_once 'connect.php';
$sql="SELECT bookingID FROM payments";
$masterResult=$mysqli ->query($sql);

while ($row=$masterResult -> fetch_assoc()) {
    $bookingID=$row['bookingID'];
    $sql="SELECT listingID,
bookingID AS 'Booking ID',
    bookingDT AS 'Booking Made On',
    startDate AS 'Check-in Date',
    endDate AS 'Check-out Date',
    bookingStatus AS 'Booking Status'
    FROM bookings WHERE bookingID='$bookingID'";
$userResult=$mysqli ->query($sql);
    $row=$userResult ->fetch_assoc();

    $listingID=$row['listingID'];

    // creating date object for startDate and endDate
    $start=strtotime($row['Check-in Date']);
    $end=strtotime($row['Check-out Date']);
    // calculate the differences
    $duration=$end - $start;
    // one day = 86400 seconds 
    $days=round($duration / 86400);

    // cannot use GET to pass from previous page, can mod
    $sql="SELECT rate FROM listings WHERE listingID = '$listingID'";
    $result=$mysqli ->query($sql);
    $row=$result ->fetch_assoc();

    // round off the duration to strip decimals
    $amount=($days * intval($row['rate']));

    $sql="UPDATE payments SET amount = $amount WHERE bookingID = $bookingID";
    $mysqli ->query($sql);

    if ($mysqli -> affected_rows==1) {
        echo "<script>alert('Done for Booking number: $bookingID!');</script>";
    }
}