<?php 
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'host') {
        header('location: index.php');
    }
    include ('connect.php');
    $accID = $_SESSION['accID'];
    $hostID = $_SESSION['hostID'];
    $result = $mysqli->query("SELECT listings.listingID, listings.title, bookings.bookingDT, reviews.stars, reviews.review FROM reviews, listings, bookings WHERE reviews.bookingID = bookings.bookingID and bookings.listingID = listings.listingID and hostID = $hostID");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | Customer Reviews</title>
        <link rel="stylesheet" href="style/hostTrxn.css?">
        <link rel="tab icon" href = "images/maps icon.png">
    </head>

    <body>
        <?php require_once 'hostHeader.php'; ?>

        <main>
        <div class = 'host_property'>
            <section id="greetings">Customer Reviews</section>
        </div>
        
        <div class="center">
            <div>
			<br>
                <table id = 'cusReview' width='1300px' border='1' cellspacing='1' cellpadding='3'>
                    <tr>
                        <td>Property Name</td>
                        <td>Booking Date/Time</td>
                        <td>Ratings</td>
                        <td>Review</td>
                    </tr>
            
                    <?php 
                    $num = $result->num_rows;
                    if ($num != 0) {
                        while ($row = $result->fetch_assoc()){
                            $title = $row['title'];
                            $bookingDT = $row['bookingDT'];
                            $reviewStar = $row['stars'];
                            $reviews = $row['review'];

                            echo "<tr>";

                            echo "<td>";
                            echo $title;
                            echo "</td>";

                            echo "<td>";
                            echo $bookingDT;
                            echo "</td>";

                            echo "<td>";
                            echo $reviewStar;
                            echo "</td>";

                            echo "<td>";
                            echo $reviews;
                            echo "</td>";

                            echo "</tr>";
                        }
                    }
                    else {
                        echo "<br>There are no reviews just yet. Wait for users to give a review!";
                    }
                    
                    ?>

                </table>
            </div>
        </div>
       </main>

        <?php require_once 'hostFooter.php';?>
        <script src = "script/hostOverlay.js"></script>
</html>