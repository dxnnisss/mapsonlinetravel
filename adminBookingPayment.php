<?php 
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPS | Your Destination</title>
    <link rel="stylesheet" href="style/master.css">
    <link rel="tab icon" href="images/maps icon.png">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="style/adminBookingPayment.css">
    <link rel="stylesheet" href="style/adminOverlay.css">

</head>
<body>
    <!-- header section -->
    <?php include('adminHeader.php');?>
    <main>
        <!-- navigational section -->
        <?php include 'topnav.php'?>
            
            
        
        <div class="parentbox">
            <a href="adminBooking.php" class="ABP_childbox">
                <div class="insidebox">
                Booking Record
                </div>  
            </a>
            <a href="adminPayment.php" class="ABP_childbox">
                <div class="insidebox">
                Payment Record
                </div>
            </a>
        </div>

    </main>
    <script src="script/adminOverlay.js"></script>
    </body>
    </html>