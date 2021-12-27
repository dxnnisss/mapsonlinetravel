<?php 
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'host') {
        header('location: index.php');
    }
    include("connect.php");
    $accID = $_SESSION['accID'];
    $hostID = $_SESSION['hostID'];
    $result = $mysqli-> query("SELECT listings.hostID, listings.title, users.uName, bookings.bookingDT, datediff(endDate, startDate) as duration, rate*(datediff(endDate, startDate)) as trxn FROM listings, users, bookings WHERE listings.listingID = bookings.listingID AND bookings.userID = users.userID and listings.hostID = '$hostID' and bookingStatus = 'completed'");
?>

<!DOCTYPE html>
<html lang="en">
    <head>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | Host Wallet</title>
        <link rel="stylesheet" href="style/hostTrxn.css?">
        <link rel="tab icon" href = "images/maps icon.png">
    </head>

    <body>
        <?php require_once 'hostHeader.php'; ?>


        <main>
        <div class = 'host_property'>
                <section id="greetings">Transactions</section><br>
        </div>
        
        <br>
        
        <div class = "walletBal">
            
            <?php 
                $wallet = $mysqli -> query("SELECT walletBalance FROM hosts WHERE hostID = $hostID");
                $walletBal = $wallet->fetch_assoc();
            ?>
            <div class="walletBalName flex-sa-c"> Wallet Balance: RM <?php echo $walletBal['walletBalance']?></div>
        </div>
        <br>
        <div class = "center">
            <br>
            <table id="trxn" width = '1300px' border = '1' cellspacing='1' cellpadding='3'>
                <tr>
                    <td>Property</td>
                    <td>Customer</td>
                    <td>Booking Date/Time</td>
                    <td>Stay Duration (Days)</td>
                    <td>Transaction</td>
                    
                </tr>
                <?php

                    
                    $num = $result -> num_rows;
                    if ($num != 0) {
                        while ($row = $result->fetch_assoc()){
                            $propertyTitle = $row['title'];
                            $custName = $row['uName'];
                            $bookingDT = $row['bookingDT'];
                            $duration = $row['duration'];
                            $trxnAmt = $row['trxn'];
                            
                            echo "<tr>";

                            echo "<td>";
                            echo $propertyTitle;
                            echo "</td>";

                            echo "<td>";
                            echo $custName;
                            echo "</td>";

                            echo "<td>";
                            echo $bookingDT;
                            echo "</td>";

                            echo "<td>";
                            echo $duration;
                            echo "</td>";
                            
                            echo "<td>";
                            echo "RM ";
                            echo $trxnAmt;
                            echo "</td>";
                            }

                            echo "</tr>";
                                                        
                    }
                    else {
                        echo "There are no records to available just yet!";                        }
                ?>
            </table> 
        </div>
        </main>

        <?php require_once 'hostFooter.php';?>
        <script src = "script/hostOverlay.js"></script>

    </body>
</html>