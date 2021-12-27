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

        <div class="bp_search_bar">
            <form method="post">
            <label style='margin-left: 10px;'> Search : </label> 
            <input type="text" name="bp_search_key" class="search_input"> 
            <button type="submit" name="bp_btn" class="button"><i class="uil uil-search"></i></button>
            </form>
        </div> 
        
        <!-- table  -->
        <div class="divTable" style="width: 90%;border: 2px solid black;" >
            <div class="divTableHeading">
                <div class="divTableRow">
                    <div class="divTabeCell">
                        Payment ID
                    </div>
                    <div class="divTableCell">
                        Booking ID
                    </div>
                    <div class="divTableCell">
                        User ID 
                    </div>
                    <div class="divTableCell">
                        Credit Card
                    </div>
                    <div class="divTableCell">
                        Expiry Date
                    </div>
                    <div class="divTableCell">
                        CVV
                    </div>
                    <div class="divTableCell">
                        DateTime
                    </div>
                    <div class="divTableCell">
                        Amount(RM)
                    </div>
                </div>
            </div>
            <div class="divTableBody">
        <?php
        include('connect.php');

        $search_key = '';
        if(isset($_POST['bp_btn'])){
            $search_key = $_POST['bp_search_key'];
        }

        $sql="SELECT * FROM payments INNER JOIN bookings ON payments.bookingID = bookings.bookingID WHERE paymentID LIKE '%$search_key%' ";

        $result = $mysqli->query($sql);
        $row_cnt = $result-> num_rows;
        // fetching the data 
        if($row_cnt>0){
            while ($row = $result -> fetch_assoc()) {
                echo   '<div class="divTableRow">

                            <div class="divTableCell">
                                '.$row['paymentID'].'
                            </div>

                            <div class="divTableCell">
                            '.$row['bookingID'].'
                            </div>
                            
                            <div class="divTableCell">';
                            $sql_user = 'SELECT accID FROM users where userID = '.$row['userID'].'';
                            $result_user = $mysqli->query($sql_user);
                            $row_cnt_user = $result_user-> num_rows;
                            if($row_cnt_user == 1){
                                while($row_user = $result_user -> fetch_assoc()){
                                echo '<a href="adminUserAccount.php?accID='.$row_user['accID'].'&type_role=user">';
                                }
                            }
                            // linking the account to the user account for the admin to know which accid is who
                    echo    ''.$row['userID'].'
                            </a>
                            </div>

                            <div class="divTableCell">
                            '.$row['ctCard'].'
                            </div>

                            <div class="divTableCell">
                            '.$row['expiry'].'
                            </div>

                            <div class="divTableCell">
                            '.$row['cvv'].'
                            </div>

                            <div class="divTableCell">
                            '.$row['dateTime'].'
                            </div>

                            <div class="divTableCell">
                            '.$row['amount'].'
                            </div>
                        </div>';
            }
        }
        ?>
            </div>
        </div>
        <script src="script/adminOverlay.js"></script>