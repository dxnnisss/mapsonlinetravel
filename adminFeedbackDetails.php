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
    <link rel="stylesheet" href="style/adminFeedbackDetails.css">
    <link rel="stylesheet" href="style/adminOverlay.css">

</head>

<body>
    <!-- header section -->
    <?php include('adminHeader.php');?>
    <main>
        <!-- navigational section -->
        <?php include 'topnav.php'?>
        <?php 
        
        include('connect.php');
        $ticket_id = $_GET['ticketID'];
        $sql = 'SELECT ticketID,ticketStatus,ticketDT,name,contact,email,type,subject,message FROM contactus where ticketID =  '.$ticket_id.'';
        // getting data from table review 
        $result = $mysqli -> query($sql);

        $row_cnt = $result -> num_rows;

        if($row_cnt>0){
            while ($row = $result-> fetch_assoc()) {
                
               
                
                    // top side of basic info content

                echo '';
                echo '<div class="bigcontainer">
                        <div style="text-align: center;font-size: 25px;">Basic Info</div>
                        <hr>
                        <div class="wrapbox">
                        <div class="toprow">
                            <div class="Acontent">
                                <div class="tittle_text">
                                    Subject
                                </div>
                                 <div class="content_text">';
                echo                 $row['subject'];
                echo            '</div>
                            </div>
                            <div id="rightcolumn" class="Acontent">
                            <div class="tittle_text">
                                Sender
                            </div>
                            <div class="content_text">';
                echo        $row['name'];
                echo    '   </div>
                            </div>
                        </div>
                        <div class="secrow">
                            <div class="Acontent">
                                <div class="tittle_text">
                                Ticket Status
                                </div>
                                <div class="content_text">';
                echo            $row['ticketStatus'];
                echo   '</div>
                        </div>
                        <div id="rightcolumn" class="Acontent">
                            <div class="tittle_text">
                                Email
                            </div>
                            <div class="content_text">';
                echo        $row['email'];
                echo    '</div>
                        </div>
                        </div>
                        </div>';

                // showing the external info to the admin
                echo    '<div>
                    <div style="text-align: center;font-size: 25px;margin-top: 20px;">External Info</div>
                    <hr>
                        <div class="thirdrow">
                            <div class="Acontent">
                                <div class="tittle_text">
                                    TicketID
                                </div>
                                <div class="content_text">
                                    '.$row['ticketID'].'
                                </div>
                            </div>
                            <div  class="Acontent">
                                <div class="tittle_text">
                                    Date and Time
                                </div>
                                <div class="content_text">
                                    '.$row['ticketDT'].'
                                </div>
                            </div>
                        </div>
                        <div class="fourthrow">
                            <div  class="Acontent">
                                <div class="tittle_text">
                                    Contact
                                </div>
                                <div class="content_text">
                                    '.$row['contact'].'
                                </div>
                            </div>
                            <div  class="Acontent">
                                <div class="tittle_text">
                                    Type
                                </div>
                                <div class="content_text">
                                    '.$row['type'].'
                                </div>
                            </div>
                        </div>
                        ';


                echo        '   <div style="text-align: center;font-size: 25px;margin-top: 20px;">Message</div>
                                <hr>
                                <div class="message_detail">
                                <div id="title_msg">
                                Message   :
                                </div>
                                
                                <div id="content_msg">';
                echo                $row['message'];
                echo    '       </div>
                            </div>
    
                        </div>';
                echo    '
                         <hr>
                         <div id="form_row">';
                echo    '<a href="mailto:'.$row['email'].'" id="reply_box" class="mediumtext"> Reply</a>';
                // option that select for the review ticket to change
                echo   '<form action="adminFeedbackStatus.php" method="GET">
                            <select name="ticketStatus" id="select_action" class="mediumtext">';?>
                                <!-- multiple option for admin to change the status and it will  -->
                                <option <?php if(isset($row['ticketStatus']) && $row['ticketStatus']=='new' ) echo "selected = 'selected'";?> value ="New">
                                    new
                                </option>

                                <option <?php if(isset($row['ticketStatus']) && $row['ticketStatus']=='replied' ) echo "selected = 'selected'";?> value ="Replied">
                                    replied
                                </option>

                                <option <?php if(isset($row['ticketStatus']) && $row['ticketStatus']=='active' ) echo "selected = 'selected'";?> value ="Active">
                                    active
                                </option>

                                <option <?php if(isset($row['ticketStatus']) && $row['ticketStatus']=='awaiting' ) echo "selected = 'selected'";?> value ="Awaiting">
                                    awaiting
                                </option>

                                <option <?php if(isset($row['ticketStatus']) && $row['ticketStatus']=='cancelled' ) echo "selected = 'selected'";?> value ="Cancelled">
                                    cancelled
                                </option>

                                <option <?php if(isset($row['ticketStatus']) && $row['ticketStatus']=='completed' ) echo "selected = 'selected'";?> value ="Completed"> 
                                    completed
                                </option>

        <?php              
                echo            '</select>';
                                
                echo            '<label id="labelticket">Id:</label>
                                <input type="text" name="ticketID" value="'.$ticket_id.'" id="ticketID" class="mediumtext" readonly>';
                        // displaying read only id for admin as a references
                        // to change the status
                echo    '<button type="submit" name="replyTicket" id="submitbtn" class="mediumtext">Change</button>
                         </form>';
                echo    '</div>';
                    }
                }
        ?>



    </main>
    <script src="script/adminOverlay.js"></script>
</body>

</html>