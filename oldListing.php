<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MAPS | Your Destination</title>
    <link rel="stylesheet" href="style/listing.css">
    <link rel="tab icon" href="images/maps icon.png">
    <link href="http://code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script> 
    
</head>

<body>
    <?php
    session_start();
        // header section and overlays
    require_once 'masterHeader.php';
    $listingID = intval($_GET['listingID']);
    ?>
    <main>
    <?php 
    require_once("connect.php");
    $sql = "SELECT * FROM hosts h INNER JOIN listings l ON h.hostID = l.hostID where l.listingID LIKE '%$listingID%'";
    $result = $mysqli ->query($sql);
    $row_cnt = $result -> num_rows;


    if($row_cnt > 0){
        $row = $result -> fetch_assoc();
            foreach($row as $key=> $value){
                if(empty($value)){
                    $value = 'N/A';
                }
                else{
                    continue;
                }
            }
            echo '<div class="A_Container">';
            echo ' <div class="topDiv_title">
                        '.$row['title'].'
                    </div>';
            echo '<hr>';
            echo ' <div class="topDiv_btm">';
            echo '<div class="star">
                    &#9734
                  </div>';
                ?><?php
            $sql_review = "SELECT listingID, title, guest, rate, avgStars, recordCount FROM ( 
                            SELECT l.listingID, l.title, l.guest, l.rate, AVG(r.stars) avgStars, COUNT(r.stars) recordCount 
                            FROM listings l INNER JOIN bookings b ON l.listingID = b.listingID 
                            INNER JOIN reviews r ON r.bookingID = b.bookingID 
                            WHERE l.listingID LIKE '%$listingID%' 
                            GROUP BY l.listingID, l.title, l.guest, l.rate) averageStars";

            $result_review = $mysqli ->query($sql_review);

            $row_cnt_review = $result_review -> num_rows;

            if($row_cnt_review == 1){
                $row_review = $result_review -> fetch_assoc();
                    
                    $avgStars = number_format($row_review['avgStars'],1);


                    $recordCount = $row_review['recordCount'];
                    echo '<div class="text-center" id="review_top">
                            '.$avgStars.' ('.$recordCount.' REVIEWS)
                            </div>';
                
            }
            else{
                echo    '<div class="text-center" id="review_top">
                        0.0 (0 REVIEWS)
                        </div>';
            }
            echo    '<div class="text-center" id="location_top">';

            echo    $row['location'];

            echo    '</div>
                    </div>
                    </div>';
              
            echo    '<hr>';

            echo    '<div class="B_container">';

            $sql_photo = "SELECT * FROM addphotos a INNER JOIN listings l on a.listingID = l.listingID WHERE l.listingID = $listingID";

            $result_photo = $mysqli -> query($sql_photo);

            $row_cnt_photo = $result_photo -> num_rows;

            if($row_cnt_photo >0){
                while($row_photo = $result_photo -> fetch_assoc()){
                    $photos = 'data:image/jpg;base64,'.base64_encode($row_photo['photo']);
                    echo    '<div class="myImages fade">

                            <img src="'.$photos.'" id="B_image" style="vertical-align: middle;min-width: 70vw;height: 500px;" class="center">
    
                            </div>';
                }
            }
            else{
                echo    'There are no photos available just yet!';
            }

            echo   '<a class="prev" onclick="nextImage(-1)">&#10094;</a>
                    <a class="next" onclick="nextImage(1)">&#10095;</a>
                    </div>
                    <br>';
            
            echo   '<div style="text-align:center">';
            $x = 0;
            for($i = 0; $i > $row_cnt_photo;$i++){
                $x += 1;
                echo '<span class="dot" onclick="currentImage('.$x.')"></span>';
            }

            echo   '</div>
                       <hr>';

            echo   '<div id="C_Container" class="C_Container flex-sb-c ">
                    <div id="C_leftColumn" >
                
                        <div class="C_childbox">
                            Hosted By: '.$row['hName'].'
                        </div>

                        <div class="C_childbox">
                            Host Contact&nbsp;:&nbsp;'.$row['hContact'].'
                        </div>

                        <div class="C_childbox">
                            Guest&nbsp;Capacity&nbsp;:&nbsp;'.$row['guest'].'
                        </div>

                        <div class="C_childbox">
                            Listing Description: '.$row['description'].'
                        </div>';
                        
                echo    '<div class="C_childbox">';

                $sql_tags = "SELECT * FROM tags t 
                             inner join listingtag lt ON t.tagID = lt.tagID 
                             INNER JOIN listings l ON l.listingID = lt.listingID 
                             WHERE l.listingID LIKE '%$listingID%'";

                $result_tag = $mysqli -> query($sql_tags) ;

                $row_cnt_tag = $result_tag -> num_rows;

                if($row_cnt_tag != 0 ){
                    echo 'Tags: ';
                    while($row_tag = $result_tag -> fetch_assoc() ){
                        echo ''.$row_tag['tName'].',&nbsp;';
                    }
                }

                

                // <!-- FORM -->

                $row_review = $result_review -> fetch_assoc();
                    
                    $avgStars = number_format($row_review['avgStars'],1);

                    $recordCount = $row_review['recordCount'];

                echo    '</div>
                        </div>';

                echo    '<form id="bookingForm" method="post">
                        <div id="C_rightColumn">
                            <div class="C_rcTopBox flex-c-c">
                                Booking Rate per Day: &nbsp;RM'.$row['rate'].'
                            </div>
                            
                            <div class="C_rcTopBox flex-c-c">
                                <label>Check-In Date:&nbsp; </label>
                                <input type="text" id="listingCheckIn" name="checkin" class="date">
                            </div>

                            <div class="C_rcTopBox flex-c-c">
                                <label>Check-Out Date:&nbsp;</label>
                                <input type="text" id="listingCheckOut" name="checkout" class="date">
                            </div>

                            <div class="C_rcBtmBox flex-c-c">
                                <button type="submit" class="btn" name="bookProperty">Book Now!</button>
                            </div>
                         </div>
                    </div></form>';

                    $sql_date = $mysqli ->query("SELECT startDate, endDate FROM bookings WHERE listingID LIKE '%$listingID%'");

                    $countDate = $sql_date ->num_rows;
                    if ($countDate !=0 ){
                        while ($dates = $sql_date ->fetch_array(MYSQLI_NUM)) {
                            
                            $date1 = $dates[0];
                            $date2 = $dates[1];

                            $date_array = array();

                            $var1 = strtotime($date1);
                            $var2 = strtotime($date2);

                            for ($currentDate = $var1; $currentDate<=$var2; $currentDate += (86400)) {
                                $store = date('Y-m-d', $currentDate);
                                $array[] = $store;
                            }
                            
                        }
                        
                        $dateArray = "['" . join("', '", $array) . "']";
                    }
                    else {
                        $dateArray = "[]";
                    }

                        
                
                    
                echo '<script type="text/javascript"> var dateCheck = '.$dateArray.';</script>';    
                
                echo    '<div class="D_container">
                            <div>
                                <div id="D_star">
                                    &#9734
                                </div>
                                <div>
                                    '.$avgStars.' ('. $recordCount.' Reviews);
                                </div>
                            </div>
                            &nbsp; <br>
                            <hr>
                            <div id="D_reviews">';
              
                $sql_review_content = "SELECT u.userID, u.uName,u.uPicture ,b.listingID , b.bookingID , r.stars, r.review FROM bookings b INNER JOIN reviews r ON b.bookingID = r.bookingID INNER JOIN users u ON b.userID = u.userID WHERE listingID LIKE '%$listingID%'";
                
                $result_review_content = $mysqli -> query($sql_review_content) ;

                $row_cnt_review_content = $result_review_content -> num_rows;

                if($row_cnt_review_content != 0 ){
                    while($row_review_content = $result_review_content -> fetch_assoc() ){
                        $ownerPhoto = 'data:image/jpg;base64,'.base64_encode($row_review_content['uPicture']);
                        echo    '<div id="D_contentOwner">
                                    <div>
                                    
                                    </div>
                                        <div class="D_children">
                                            <div id="D_image">
                                            <img src="'.$ownerPhoto.'" class="D_ownerPhoto">
                                            
                                            <div class="dName">
                                            '.$row_review_content['uName'].' <br>
                                            Review: '.$row_review_content['review'].'
                                           </div>
                                           </div>
                                            
                                        </div>
                                    
                                    </div>
                                    
                                
                                    <hr>';
                   }
                }
                else {
                    echo 'There are no reviews just yet!';
                }
            echo        '</div>
                    </div>';      
    }
    // else {
    //     echo '<script>alert("Listing is currently unavailable"); window.location.href="index.php";</script>';
    // }
      
?>

<?php 

    if (isset($_POST['bookProperty'])) {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != "user") {
            echo '<script>alert("Please login to make a booking!");</script>';
        }
        else {
            
            $userID = $_SESSION['userID'];
            $startDate = $_POST['checkin'];
            
            $newStartDate= date('Y-m-d', strtotime($startDate));
            
            $endDate = $_POST['checkout'];
            
            $newEndDate = date('Y-m-d', strtotime($endDate));
            

            $sqlInsert = "INSERT INTO bookings (listingID, userID, startDate, endDate) 
                            VALUES ($listingID, $userID, '$newStartDate', '$newEndDate')";

            if ($mysqli->query($sqlInsert)) {
                echo '<script>alert("Your booking is confirmed!"); window.location.href="index.php";</script>;';
            }
            else {
                echo ("Error: " . $mysqli ->error);
                echo '<script>alert("Something went wrong"); window.location.href="index.php";</script>;';
                exit();
            }
        }
        
        
    }
?>

</main>

<script src="script/listing.js"></script>
<script src="script/master.js"></script>
</body>

</html>