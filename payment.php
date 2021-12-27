<?php
    session_start();
    if (!isset($_SESSION['role']) || !isset($_GET['bookingID']) || $_SESSION['role'] != 'user') {
        header('location: index.php');
    }

    require_once 'connect.php';

    // to check whether the booking belongs to the suer
    $userID = $_SESSION['userID'];
    $sql = "SELECT bookingID FROM bookings WHERE userID='$userID' AND bookingStatus = 'booked'";
    $result = $mysqli -> query($sql);
    $valid = false;
    while ($row = $result -> fetch_assoc()) {
        if ($row['bookingID'] == $_GET['bookingID']) {
            $valid = true;
            break;
        }
    }
    if (!$valid) {
        echo "<script>alert('This booking doesn\'t belongs to you or it\'s paid!\\nTerminating payment gateway...');
                window.location.href = 'index.php';
                window.close();</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment [SECURED]</title>
    <link rel="stylesheet" href="style/payment.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <header>SECURED PAYMENT GATEWAY</header>
    <main>
        <div id="mainDiv1" class="flex-col flex-sa-c flex-fs">

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
                            $numAmount = $days * intval($row['rate']);
                            $amount = number_format($numAmount, 2);


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
                            echo 'RM ' . $amount;
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

            <div class="subTitle"><h2>Payment Information</h2><hr></div>
            <form class="subMain flex-sa-c flex-fs flex-col" method="POST">
                <div class="item flex-sa-c">
                    <label for="ctCard" class="itemLabel">Card Number</label>
                    <div id="ctCard">
                        <input type="text" name="ctCard1" id="ctCard1" class="itemValue" minlength="4" maxlength="4" onkeyup="autoJump(this, 'ctCard2')" required>
                        <span>-</span>
                        <input type="text" name="ctCard2" id="ctCard2" class="itemValue" minlength="4" maxlength="4" onkeyup="autoJump(this, 'ctCard3')" required>
                        <span>-</span>
                        <input type="text" name="ctCard3" id="ctCard3" class="itemValue" minlength="4" maxlength="4" onkeyup="autoJump(this, 'ctCard4')" required>
                        <span>-</span>
                        <input type="text" name="ctCard4" id="ctCard4" class="itemValue" minlength="4" maxlength="4" onkeyup="autoJump(this, 'chName')" required>
                    </div>
                </div>

                <div class="item flex-sa-c">
                    <label for="chName" class="itemLabel">Name on Card</label>
                    <input type="text" name="chName" id="chName" placeholder="John Doe" required>
                </div>

                <div class="item flex-sa-c">
                    <label for="expiry" class="itemLabel">Good Thru</label>
                    <input type="month" name="expiry" id="expiry" class="itemValue" required>
                </div>

                <div class="item flex-sa-c">
                    <label for="cvv" class="itemLabel">CVV</label>
                    <input type="text" name="cvv" id="cvv" class="itemValue" minlength="3" maxlength="3" required>
                </div>

                <?php
                    echo '<div class="item flex-sa-c"><div class="itemLabel">';
                    echo 'Payable';
                    echo '</div><div class="itemValue">';
                    echo 'RM ' . $amount;
                    echo '</div></div>';

                ?>

                <div id="agreement" class="item flex-sa-c">
                    <input type="checkbox" name="agree" id="agree" class="itemValue" required>
                    <label for="agree">I/We, the legitimate bearer of the card, hereby authorise <b>MAPS</b> to debit the mentioned amount from my/our card.</label>
                </div>

                <div id="payAbort" class="flex-c-c">
                    <button type="submit" id="pay" name="pay">Pay</button>
                    <button type="button" id="abort">Abort</button>
                </div>
            </form>
        </div>
    </main>

    

    <?php
        if (isset($_POST['pay'])) {
            $ctCard = '';
            $fourFields = ['ctCard1', 'ctCard2', 'ctCard3', 'ctCard4'];
            foreach ($fourFields as $number) {
                $ctCard .= $_POST[$number];
            }
            $ctCard = escaped($ctCard);
            $chName = escaped(strtoupper($_POST['chName']));
            $expiry = escaped($_POST['expiry']) . '-01';
            $cvv = escaped($_POST['cvv']);

            $sql = "INSERT INTO payments (bookingID, ctCard, chName, expiry, cvv, amount) 
                    VALUES ($bookingID, '$ctCard', '$chName', '$expiry', $cvv, $numAmount);";

            $sql2 = "UPDATE bookings SET bookingStatus='confirmed' WHERE bookingID='$bookingID'";

            $mysqli -> query($sql);

            if ($mysqli -> affected_rows != 1) {
                echo "<script>alert('An error has occured.');
                        window.opener.location.reload(true);
                        window.close();
                        </script>";
            }
            else {
                $mysqli -> query($sql2);
                if ($mysqli -> affected_rows != 1) {
                    echo "<script>alert('An error has occured.');
                            window.opener.location.reload(true);
                            window.close();
                            </script>";
                }
                else {
                    echo "<script>alert('Payment successful!');
                            window.opener.location.reload(true);
                            window.close();
                            </script>";
                }
            }
        }
        $mysqli -> close();
    ?>

    <script src="script/payment.js"></script>
</body>
</html>