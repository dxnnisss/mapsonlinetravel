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
    <link rel="stylesheet" href="style/adminListingDetailsPage.css">
    <link rel="stylesheet" href="style/adminOverlay.css">

</head>
<body>
    <!-- header section -->
    <?php include('adminHeader.php'); ?>
    <main>
        <!-- navigational section -->
        <?php include 'topnav.php'?>
        
        
        <?php
            include('connect.php');

            $ListingID = $_GET['listingID'];
            

            

            $sql = "SELECT h.hostID ,h.accID,h.hName as 'Name' ,h.hContact as 'Contact',l.listingID,l.title,l.location as 'Location',l.description as 'Description',l.rate,l.guest as 'Guest',l.listingStatus FROM HOSTS h INNER JOIN listings l ON h.hostID = l.hostID INNER JOIN accounts a ON a.accID = h.accID where l.listingID = $ListingID";
            
            
            $result = $mysqli -> query($sql);
            $row_cnt = $result -> num_rows;
            if($row_cnt > 0){

                while($row = $result -> fetch_assoc()){
                    // tittle
                    echo    '<div>
                                <h1 style="margin-left:5%;margin-top:20px">Id : '.$row['listingID'].'&nbsp; Title :&nbsp;'.$row['title'].' </h1>
                                <hr>
                            </div>';


                    echo   '<div class="ALD_bigcontainer ">
                            <div class="parentbox">
                            <div>
                            <div class="images">';
                    // not working the picture
                    // find solution to it
                    $pic_sql = 'SELECT p.photo,l.listingID FROM addphotos p inner join listings l on p.listingID = l.listingID where l.listingID = '.$row['listingID'].'';
                    // $pic_sql = 'SELECT uPicture FROM users where userID = 1';
                    $pic_result = $mysqli ->query($pic_sql);
                    $pic_row_cnt = $pic_result -> num_rows;
                    if($pic_row_cnt > 0 ){
                        while ($row_pic = $pic_result -> fetch_assoc()) {
                            
                            $pic = 'data:image/jpg;base64,'.base64_encode($row_pic['photo']);
                            echo '<img src="'.$pic.'" class="ALD_image">';

                                
                            }
                        }
                    

                    echo '</div>';
                    // looping every data in the row variable 
                    foreach($row as $key =>$value){
                        if($value != ''){
                            $content_detail[$key] = $value;
                            continue;
                        }
                        else{
                            $content_detail[$key] = 'N/A';
                        }
                    }
                    echo ' <div class="ALD_bigcontent font_20px">';
                    echo    '<div class="text-row">

                                <div class="ALD_title">
                                    Account ID
                                </div>

                                <div class="ALD_content">
                                <a href="adminUserAccount.php?accID='.$row['accID'].'&type_role=host">
                                    '.$row['accID'].'
                                </a>
                                </div>

                                </div>';
                    foreach($content_detail as $key=> $value){
                        if($key =='listingStatus'|| $key =='title' || $key =='rate'|| $key =='listingID' || $key =='accID'||$key=='hostID'){
                            continue;
                        }
                        else {
                            echo    '<div class="text-row">

                                        <div class="ALD_title">
                                            '.$key.'
                                        </div>

                                        <div class="ALD_content">
                                            '.$value.'
                                        </div>

                                    </div>';
                        }
                    }

                    echo   '</div>
                            </div>
                            </div>';

                    // showing the daily price of the listing
                    echo '<div class="ALD_columnright">
                            <div class="ALD_rcrow">
                                <div id="DP" class="boxrounding">
                                    <div >Daily Price:</div>
                                    <div >RM'.$row['rate'].'</div>
                                </div>';
                    // redirect to view review page
                    echo   '<a id="ALD_review" href="adminListingReview.php?listingID='.$row['listingID'].'&accID='.$row['accID'].'" class="boxrounding" style="padding-top: 50px;">
                                Review
                            </a>';
           
                    echo    '</div>';

                    echo    '<div class="ALD_rcrow">';
                    // to have the function to activate or deactivate the listing
                    echo    '<a id="ALD_action" href="adminListingStatus.php?listingID='.$row['listingID'].'&listStatus='.$row['listingStatus'].'&accID='.$row['accID'].'" onclick="return confirm("Delete") class="boxrounding" style="padding-top: 35px;">
                            Activate/ 
                            Deactivate
                            </a>';
                    echo    '<div id="ALD_ban"  class="boxrounding" style="padding-top: 50px;">
                            '.$row['listingStatus'].'
                            </div>';
                    echo    '</div>
                            </div>
                            </div>';
                }
            }
        ?>
        

                        
    </main>
    <script src="script/adminOverlay.js"></script>
</body>
</html>
