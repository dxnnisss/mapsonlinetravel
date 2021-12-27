<?php
    require_once("connect.php");
    if (!isset($_GET['listingID'])) {
        header('location: index.php');
    }

    $listingID = $_GET['listingID'];
    $sql = "SELECT * FROM hosts h INNER JOIN listings l ON h.hostID = l.hostID WHERE l.listingID = $listingID";
    $result = $mysqli ->query($sql);
    $row_cnt = $result -> num_rows;


    if($row_cnt > 0){
        $row = $result -> fetch_assoc();
        if ($row['listingStatus'] != 'activated') {
            echo '<script>alert("This listing is not available.");
                        window.location.href = "index.php";</script>';
        }
        
        foreach($row as $key=> $value){
            if(empty($value)){
                $value = 'N/A';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $row['title']; ?></title>
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
        <h1><?php echo $row['title']; ?></h1>
        <hr>
    <?php 

        $sql_review = "SELECT listingID, title, guest, rate, avgStars, recordCount FROM ( 
            SELECT l.listingID, l.title, l.guest, l.rate, AVG(r.stars) avgStars, COUNT(r.stars) recordCount 
            FROM listings l INNER JOIN bookings b ON l.listingID = b.listingID 
            INNER JOIN reviews r ON r.bookingID = b.bookingID 
            WHERE l.listingID = $listingID
            GROUP BY l.listingID, l.title, l.guest, l.rate) averageStars";

        $result_review = $mysqli ->query($sql_review);

        // for title, star and location display
        if ($result_review -> num_rows != 1) {
            $i = 0;
            echo '<div class="star">';
            while ($i++ < 5) {
                echo '&#9734; ';
            }
            echo '</div>';

            $avgStars = '0.0';
            $recordCount = 'No review yet';
        }

        else {
            $row_review = $result_review -> fetch_assoc();
            $starsToDiplay = round($row_review['avgStars']);

            echo '<div class="star">';
            for ($i = 0; $i < $starsToDiplay; $i++) {
                echo '&#9733; ';
            }

            while ($i++ < 5) {
                echo '&#9734; ';
            }
            echo '</div>';

            $avgStars = number_format($row_review['avgStars'], 1);
            $recordCount = $row_review['recordCount'] . ' reviews';
        }
        
        echo '<style>
                    .star::after {
                        content: "' . $row['location'] . '";

                        margin-top: 5px;
                        float: right;

                        color: black;
                        font-size: 1.3rem;
                        text-shadow: none;
                    }
                </style>';

        echo '<div id="starInfo">(' . $avgStars . ') ' . $recordCount . '</div>';


        // photo display
        echo    '<div class="B_container">';

        $sql_photo = "SELECT * FROM addphotos a INNER JOIN listings l on a.listingID = l.listingID WHERE l.listingID = $listingID";

        $result_photo = $mysqli -> query($sql_photo);

        $row_cnt_photo = $result_photo -> num_rows;

        if($row_cnt_photo > 0){
            while($row_photo = $result_photo -> fetch_assoc()){
                $photos = 'data:image/jpg;base64,'.base64_encode($row_photo['photo']);
                echo    '<div class="myImages fade">

                        <img src="'.$photos.'" id="B_image" style="vertical-align: middle;min-width: 70vw;height: 500px;" class="center">

                        </div>';
            }
        }
        else {
            echo    'There are no photos available just yet!';
        }

        echo   '<a class="prev" onclick="nextImage(-1)">&#10094;</a>
                <a class="next" onclick="nextImage(1)">&#10095;</a>
                </div>
                <br>';
        
        echo   '<div style="text-align:center">';
        $x = 0;
        for($i = 0; $i > $row_cnt_photo; $i++){
            $x += 1;
            echo '<span class="dot" onclick="currentImage('.$x.')"></span>';
        }

        echo   '</div><br><br>';

        $hostContact = 'Not Available';
        if ($row['hContact'] != null || $row['hContact'] != '' ) {
            $hostContact = $row['hContact'];
        }

        // host and listing info
        echo   '<div id="C_Container" class="C_Container flex-sa-c ">
                <div id="C_leftColumn" >
            
                <div class="C_childbox">
                    <b class="itemTitle">Hosted By:</b><br> ' . $row['hName'].'
                </div>

                <div class="C_childbox">
                <b class="itemTitle">Host Contact:</b><br> ' . $hostContact . '
                </div>

                <div class="C_childbox">
                <b class="itemTitle">Guest Capacity:</b><br> ' . $row['guest'] . ' pax
                </div>

                <div class="C_childbox">
                <b class="itemTitle">Listing Description:</b><br>' . $row['description'] . '
                </div>';
                    
        echo    '<div class="C_childbox">';

        // generating tags
        $sql_tags = "SELECT * FROM tags t 
                        inner join listingtag lt ON t.tagID = lt.tagID 
                        INNER JOIN listings l ON l.listingID = lt.listingID 
                        WHERE l.listingID = $listingID";

        $result_tag = $mysqli -> query($sql_tags) ;

        $row_cnt_tag = $result_tag -> num_rows;

        if($row_cnt_tag != 0 ){
            echo '<b class="itemTitle">Tags:</b><br>';
            $tagArray = [];
            while($row_tag = $result_tag -> fetch_assoc() ){
                array_push($tagArray, $row_tag['tName']);
            }
            echo join(', ', $tagArray);
        }

        echo '</div></div>'; 


        // booking form
        echo '<form id="bookingForm" method="post">
                    <b>BOOK THIS STAY</b>
                <div id="C_rightColumn">
                    <div class="C_rcTopBox flex-c-c flex-col">
                        Day Rate<br><b>RM ' . number_format(intval($row['rate']), 2) . '</b>
                    </div>
                    
                    <div class="C_rcTopBox flex-c-c flex-col">
                        <label>Check-In Date</label>
                        <input type="text" id="listingCheckIn" name="checkin" class="date" autocomplete="off" required>
                    </div>

                    <div class="C_rcTopBox flex-c-c flex-col">
                        <label>Check-Out Date</label>
                        <input type="text" id="listingCheckOut" name="checkout" class="date" autocomplete="off" required>
                    </div>

                    <button type="submit" class="btn" name="bookProperty">Book Now!</button>
                    
                </div>
            </div></form>';

        // comprehend array and echo to JS for datepicker
        $today = date("Y-m-d");
        $sql_date = $mysqli ->query("SELECT startDate, endDate 
                                        FROM bookings WHERE listingID = $listingID 
                                        AND endDate >= '$today' 
                                        AND bookingStatus != 'cancelled'
                                        ORDER BY startDate ASC");

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

        echo '<script> var dateCheck = ' . $dateArray . ';</script>';   
        
        echo '<br><br><br><div>';

        echo '<h2>Customer Reviews</h2><br>';

        // customer review      
        echo    '<div id="D_reviews">';
        
        $sql_review_content = "SELECT u.userID, u.uName, u.uPicture, b.listingID, b.bookingID, r.stars, r.review 
                                FROM bookings b INNER JOIN reviews r 
                                ON b.bookingID = r.bookingID 
                                INNER JOIN users u ON b.userID = u.userID 
                                WHERE listingID = $listingID";
        
        $result_review_content = $mysqli -> query($sql_review_content);

        $row_cnt_review_content = $result_review_content -> num_rows;

        if($row_cnt_review_content != 0 ){
            while($row_review_content = $result_review_content -> fetch_assoc()) {
                $ownerPhoto = 'images/profile picture.png';
                if ($row_review_content['uPicture'] != null) {
                    $ownerPhoto = 'data:image/jpg;base64,'.base64_encode($row_review_content['uPicture']);
                }
                echo    '<div id="D_contentOwner">
                            <div class="D_children">
                                <div id="D_image">
                                <img src="' . $ownerPhoto . '" class="D_ownerPhoto">
                                </div>
                                
                                <div class="dName"><b>' . $row_review_content['uName'] . '</b><br>' . 
                                $row_review_content['review'] . ' </div>
                                
                            </div>
                        
                        </div>';
            }
        }
        else {
            echo '<span>There are no reviews just yet!</span>';
        }
    echo        '</div>
            </div>';      
    
    // else {
    //     echo '<script>alert("Listing is currently unavailable"); window.location.href="index.php";</script>';
    // }
      


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
                echo '<script>alert("Successfully booked!"); 
                window.location.href="bookingDetails.php?bookingID=' . $mysqli -> insert_id . '";</script>;';
            }

            else {
                echo ("Error: " . $mysqli -> error);
                echo '<script>alert("Something went wrong."); window.location.href="index.php";</script>;';
                exit();
            }
        }   
    }
?>

</main>

<?php
    require_once 'masterFooter.php';
?>

<script src="script/listing.js"></script>
<script src="script/master.js"></script>
</body>

</html>