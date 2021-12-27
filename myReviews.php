<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reviews</title>
    <link rel="stylesheet" href="style/myReviews.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'connect.php';
        require_once 'userHeader.php';
        $userID = $_SESSION['userID'];

        $sql = "SELECT r.bookingID AS 'Booking ID',
                    r.stars AS 'stars',
                    r.review AS 'Review',
                    l.title AS 'Stay' FROM 
                    reviews r INNER JOIN bookings b ON
                    b.bookingID=r.bookingID INNER JOIN listings l ON 
                    l.listingID=b.listingID
                    WHERE b.userID = '$userID'";

        $result = $mysqli -> query($sql);
    ?>
    <main>
        <h1>My Reviews</h1>
        <hr>
        <p>This page will only show your pass reviews and allow you to manage recent reviews. 
            To make a review on bookings, click the "Review" button at the respective booking page.</p>
            <br><br>
        
        <form id="search" method="post">
            Search: <input type="text" name="keyword" placeholder="Booking ID">
            <button name="searchBtn" type="submit">GO</button>
        </form>
            
        <?php
            if (isset($_POST['searchBtn'])) {
                $keyword = $_POST['keyword'];
                $sql .= " AND r.bookingID LIKE '%$keyword%'";
                $result = $mysqli -> query($sql);
            }

            if ($result -> num_rows == 0) {
                echo '<div id="noRecord">No record found!</div>';
            }
            else {
                while ($row = $result -> fetch_assoc()) {
                    echo '<div class="horiBar flex-sa-c">
                            <div class="barContentCol flex-sa-c flex-fs flex-col">
                                <div class="contentRow flex-sb-c">
                                    <div class="label">Booking ID</div>';
                    
                    echo '<div class="value">' . $row['Booking ID'] . '</div></div>';
    
                    $stay = $row['Stay']; 
                    if (strlen($row['Stay']) > 44) {
                        $stay = substr($row['Stay'], 0, 44) . ' ...';
                    }
                    echo '<div class="contentRow flex-sb-c">
                            <div class="label">Stay</div>
                            <div class="value">' . $stay . '</div></div></div>';
    
                    echo '<div class="barContentCol flex-sa-c flex-fs flex-col">
                            <div class="contentRow flex-sb-c">
                                <div class="label">Rating</div>
                                <div id="ratingContainer" class="value starDisplay">';
    
                    for ($i = 0; $i < $row['stars']; $i++) {
                        echo '<div class="stars">&#9733;</div>';
                    }
    
                    while ($i++ < 5) {
                        echo '<div class="stars">&#9734;</div>';
                    }
                    echo '</div></div>';
    
                    // slicing the string if its too long for brief
                    $review = $row['Review'];
                    if (strlen($row['Review']) > 22) {
                        $review = substr($row['Review'], 0, 22) . ' ...';
                    }
                    
                    echo '<div class="contentRow flex-sb-c">
                            <div class="label">Review</div>
                            <div class="value">' . $review . '</div></div></div>';
    
                    echo '<a href="review.php?bookingID=' . $row['Booking ID'] . '" class="checkBtn">View</a></div>';
                }
            }
        ?>
    </main>
    
    <?php
        // footer section 
        require_once 'masterFooter.php';
        $mysqli -> close();
    ?>
    <script src="script/master.js"></script>
    <script src="script/myReviews.js"></script>
</body>
</html>