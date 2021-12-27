<?php 
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | Your Destination</title>
        <link rel="stylesheet" href="style/master.css">
        <link rel="tab icon" href="images/maps icon.png">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <link rel="stylesheet" href="style/adminListingReview.css">
        <link rel="stylesheet" href="style/adminOverlay.css">
    </head>
    <body>
        <!-- header section -->
        <?php include('adminHeader.php'); ?>
        <main>
            <!-- navigational section -->
            <?php include 'topnav.php'?>
            <!-- search engine -->
            <div class="search_bar" style='margin-left:80px; '>
            <form method="post">
            <label style='margin-left: 10px;'> Search : </label> 
            <input type="text" name="review_search_key" class="search_input"> 
            <button type="submit" name="review_btn" class="button"><i class="uil uil-search"></i></button>
            </form>
            </div> 
            <!-- table -->
            <div class="divTable" style="width: 90%;border: 2px solid #000;" >
            <div class="divTableHeading">
                <div class="divTableRow">
                    <div class="divTableCell">Booking ID</div>
                    <div class="divTableCell">Booking Date/Time</div>
                    <div class="divTableCell">Ratings</div>
                    <div class="divTableCell" id="biggertableCell">Review</div>
                </div>
            </div>
            <div class="divTableBody">
                <?php 
                include('connect.php');
                $listingID = $_GET['listingID'];

                $search_key = '';

                if(isset($_POST['review_btn'])){
                    $search_key = $_POST['review_search_key'];
                }


                // getting the listing review data from review table based on the listing id
                $sql    =   "SELECT listings.listingID, listings.title, bookings.bookingDT, reviews.stars, reviews.review,bookings.bookingID 
                            FROM reviews INNER JOIN bookings ON reviews.bookingID = bookings.bookingID INNER JOIN listings ON listings.listingID = bookings.listingID
                            WHERE listings.listingID = $listingID and bookings.bookingID like '%$search_key%' ";
                $result = $mysqli->query($sql);
                
                $num_cnt = $result->num_rows;
                // if the listing does not have any review
                if($num_cnt == 0 ){
                    echo    '<div class="divTableRow">
                                <div class="divTableCell">- </div>
                                <div class="divTableCell">-</div>
                                <div class="divTableCell">-</div>
                                <div class="divTableCell">-</div>
                            </div>';
                }
                // fetching the data if have
                elseif($num_cnt != 0){
                    while($row = $result->fetch_assoc()){
                    echo    '<div class="divTableRow">
                                <div class="divTableCell">'.$row['bookingID'].'</div>
                                <div class="divTableCell"> '.$row['bookingDT'].'</div>
                                <div class="divTableCell">'.$row['stars'].'</div>
                                <div class="divTableCell id="biggertableCell"">'.$row['review'].'</div>
                            </div>';
                }
                
                // state for admin that the review is ald disaplyed all
                echo "<br><div style='min-width:100px;'>End of review.</div>";
                
                }
                ?>
            </div>
            </div>
        </main>
        <script src="script/adminOverlay.js"></script>
    </body>
    
</html>