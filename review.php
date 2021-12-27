<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user' || !isset($_GET['bookingID'])) {
        header('location: myReviews.php');
    }

    // header section and overlays
    require_once 'connect.php';
    $bookingID = $_GET['bookingID'];
    $userID = $_SESSION['userID'];
    $sql = "SELECT DISTINCT bookingID FROM bookings WHERE userID='$userID'";
    $result = $mysqli -> query($sql);
    $correctUser = false;
    while ($row = $result -> fetch_assoc()) {
        if ($row['bookingID'] == $bookingID) {
            $correctUser = true;
            break;
        }
    }
    // validating correct or wrong user
    if (!$correctUser) {
        echo "<script>alert('You can\'t reviews booking that doesn\'t belongs to you!');
            window.location.href = 'myReviews.php';</script>";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <link rel="stylesheet" href="style/review.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'userHeader.php';
    ?>
    <main>
        <h1 id="pageTitle">Review for Booking ID: <?php echo $bookingID;?></h1>
        <hr>

        <?php
            $sql = "SELECT r.bookingID, r.stars, r.review, b.endDate, b.userID, l.title
                    FROM reviews r INNER JOIN bookings b
                    ON b.bookingID = r.bookingID INNER JOIN listings l
                    ON l.listingID = b.listingID
                    WHERE r.bookingID = '$bookingID'
                    AND b.bookingStatus = 'completed';";
            
            $result = $mysqli -> query($sql);

            // case of no review record
            if ($result -> num_rows != 1) {
                $sql = "SELECT bookingStatus FROM bookings WHERE bookingID='$bookingID';";
                $statusCheck = $mysqli -> query($sql);
                $statusCheck = $statusCheck -> fetch_assoc();
                $statusCheck = $statusCheck['bookingStatus'];

                // case of correct user, but booking isnt completed yet
                if ($statusCheck != 'completed') {
                    echo "<script>alert('Come again after the booking is completed!');
                        window.location.href = 'myReviews.php';</script>";
                }

                // case of completed booking but no review, allow user to add one
                $sql = "SELECT * FROM bookings b 
                        INNER JOIN listings l ON b.listingID = l.listingID 
                        WHERE b.bookingID = '$bookingID'";
                $result = $mysqli -> query($sql);
                $row = $result -> fetch_assoc();
                $endDate = strtotime($row['endDate']);
                $maxDate = $endDate + (7 * 24 * 60 * 60); // number of seconds in 7 days
                $stay = $row['title'];

                // if more than 7 days from completion, no review permitted
                if (strtotime('now') > $maxDate) {
                    echo "<script>alert('You have exceeded 7 days from the completion of this booking.');
                            window.location.href = 'myReviews.php';</script>";
                }

                // allow to make a review
                echo '<form id="ratingInfo" method="POST" class="flex-sa-c flex-col">
                        <div class="flex-sb-c flex-col flex-fs">
                            <label for="bookingID">Booking ID</label><br>
                            <input type="text" name="bookingID" value="';
                
                echo $bookingID . '" readonly></div>';

                echo '<div class="flex-sb-c flex-col flex-fs">
                        <label for="stay">Stay</label><br>
                        <input type="text" name="stay" value="';

                echo $stay . '" readonly></div>';

                echo '<div id="starDiv" class="flex-sb-c flex-col flex-fs">
                        <label>Star Rating</label>
                        <div id="starsContainer" class="flex-sa-c">
                            <div id="star1" class="stars" onclick="changeColour(1)">&#9734;</div>
                            <div id="star2" class="stars" onclick="changeColour(2)">&#9734;</div>
                            <div id="star3" class="stars" onclick="changeColour(3)">&#9734;</div>
                            <div id="star4" class="stars" onclick="changeColour(4)">&#9734;</div>
                            <div id="star5" class="stars" onclick="changeColour(5)">&#9734;</div>
                            <input type="hidden" id="stars" name="stars" required>
                        </div></div>';

                echo '<div class="flex-sb-c flex-col flex-fs">
                        <label for="Review">Your Review</label><br>
                        <textarea name="review" id="review" placeholder="Tell us about your stay experience!" required></textarea>
                    </div>

                    <div>
                        <button id="submitBtn" name="submit" type="submit">Submit</button>
                    </div></form>';

                // insert the record into database
                if (isset($_POST['submit'])) {
                    $stars = $_POST['stars'];
                    $review = $_POST['review'];
                    $sql = "INSERT INTO reviews VALUES ($bookingID, $stars, '$review')";

                    $mysqli -> query($sql);

                    if ($mysqli -> affected_rows == 1) {
                        echo "<script>alert('Review successful!');
                                window.location.href = 'myReviews.php';</script>";
                    }
                    else {
                        echo "<script>alert('Error occured.');
                                window.location.href = 'myReviews.php';</script>";
                    }
                }

            }

            // case of having record
            else {
                $row = $result -> fetch_assoc();
                $stay = $row['title'];
                $stars = $row['stars'];
                $review = $row['review'];
                $endDate = strtotime($row['endDate']);
                $maxDate = $endDate + (7 * 24 * 60 * 60); // number of seconds in 7 days

                echo '<form id="ratingInfo" method="POST" class="flex-sa-c flex-col">
                        <div class="flex-sb-c flex-col flex-fs">
                            <label for="bookingID">Booking ID</label><br>
                            <input type="text" name="bookingID" value="';
                
                echo $bookingID . '" readonly></div>';

                echo '<div class="flex-sb-c flex-col flex-fs">
                        <label for="stay">Stay</label><br>
                        <input type="text" name="stay" value="';

                echo $stay . '" readonly></div>';

                echo '<div id="starDiv" class="flex-sb-c flex-col flex-fs">
                        <label>Star Rating</label>
                        <div id="starsContainer" class="flex-sa-c">';

                for ($i = 0; $i < $stars; $i++) {
                    echo '<div class="stars">&#9733;</div>';
                }

                while ($i++ < 5) {
                    echo '<div class="stars">&#9734;</div>';
                }

                echo '</div></div>';

                echo '<div class="flex-sb-c flex-col flex-fs">
                        <label for="Review">Your Review</label><br>
                        <textarea name="review" id="review" placeholder="Tell us about your stay experience!" readonly required>';

                echo $review . '</textarea></div></form>';

                // less that 7 days, can delete and review again
                if (strtotime('now') < $maxDate) {
                    echo '<a href="review.php?bookingID=' . $bookingID . '&delete=y" id="delete">Delete Review</a>';
                }  

                // deleting review
                if (isset($_GET['delete']) && $_GET['delete'] == 'y') {
                    $sql = "DELETE FROM reviews WHERE bookingID = $bookingID";
                    $mysqli -> query($sql);
                    if ($mysqli -> affected_rows != 1) {
                        echo "<script>alert('Error occured.');
                                window.location.href = 'review.php?bookingID='" . $bookingID . ";</script>";
                    }
                    else {
                        echo "<script>alert('Review deleted. If you wish to leave a review again, proceed to the respective booking details page (within 7 days of booking completion).');
                                window.location.href = 'myReviews.php';</script>";
                    }
                }
            }

            echo "<script>document.getElementById('pageTitle').innerHTML += ' | $stay';</script>";
        ?>

        
    </main>
    
    <?php
        // footer section 
        require_once 'masterFooter.php';
        $mysqli -> close();
    ?>
    <script src="script/master.js"></script>
    <script src="script/review.js"></script>
</body>
</html>