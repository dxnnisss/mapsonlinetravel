<?php 
    // session will needed to be admin or else will redirect to index.php
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
    <link rel="stylesheet" href="style/adminFeedback.css">
    <link rel="stylesheet" href="style/adminOverlay.css">

</head>

<body>
    <!-- header section -->
    <?php include('adminHeader.php'); ?>
    <main>
        <!-- navigational section -->
        <?php include 'topnav.php'?>
        <div class="parentbox">
            <?php 
            include('connect.php');

            $sql = 'SELECT ticketID,ticketStatus,ticketDT,name,contact,email,type,subject,message FROM contactus';

            $result = $mysqli -> query($sql);

            $row_cnt = $result -> num_rows;

            if($row_cnt>0){
                while ($row = $result -> fetch_assoc()) {
                    echo '<a href="adminFeedbackDetails.php?ticketID='.$row['ticketID'].'" class="AFB_childbox">';
                    // linking the pages to another pages with the id 
                    echo '  
                                <div class="AFC_topcontent">
                            
                            
                                    <div class="AFB_text-box">
                                        <div id="title">
                                            Subject :
                                        </div>
                                        <div id="content">
                                            '.$row['subject'].'
                                        </div>
                                    </div>
                                    
                                    <div class="AFB_text-box">
                                        <div id="title">
                                            Type :
                                        </div>
                                        <div id="content">
                                            '.$row['type'].'
                                        </div>
                                    </div>
                                    
                                    <div id="AFB_by" class="AFB_text-box">
                                        <div id="title">
                                            Datetime :
                                        </div >
                                        <div id="content">
                                            '.$row['ticketDT'].'
                                        </div>
                                    </div>
                            
                                </div>
                            
                                <div class="rightcolumn">
                                <div id="AFB_datetime" style="min-width:200px;">
                            
                                    <div style="min-width: 20px;">
                                        By :
                                    </div>
                                    <div style="margin-left: 10px;min-width: 50px;">
                                        '.$row['name'].'
                                    </div>
                                </div>
                            
                                <div id="AFB_status">
                                    '.$row['ticketStatus'].'
                                </div>
                                </div>
                            
                            
                            
                        </a>';
                }
            }
            ?>



        </div>
    </main>
    <script src="script/adminOverlay.js"></script>
</body>

</html>