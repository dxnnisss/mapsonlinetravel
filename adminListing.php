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
    <link rel="stylesheet" href="style/adminListingPage.css">
    <link rel="stylesheet" href="style/adminOverlay.css">

</head>
<body>
    <!-- header section -->
    <?php
    include('adminHeader.php');
    ?>
    <main>
        <!-- navigational section -->
        <?php include 'topnav.php'?>

        
        <div id="search_bar">
        <form method="post" >
        <label style="margin-left:10px;">
            Search:
        </label>
        <input type="text" name="listingSearch_key" class="search_input" placeholder="Listing title....">
        <button type="submit" name="listingsearchbtn" class="button"><i class="uli uil-search"></i></button>
        </form>
        </div>
        
        <div class="parentbox">
            <?php 

            include('connect.php');
            $search_key = "";
            if(isset($_POST['listingsearchbtn'])){
                $search_key = $_POST['listingSearch_key'];
            }

            $sql = "SELECT h.hostID,h.accID,h.hName as 'Name' ,h.hContact as 'Contact',h.hGender,h.hDOB,h.hPicture,h.bankName,h.bankAccNo,h.bankAccName,h.walletBalance,l.listingID,l.title,l.location as 'Location',l.description,l.rate,l.guest FROM HOSTS h INNER JOIN listings l ON h.hostID = l.hostID where l.title like '%$search_key%' or l.listingID like '%$search_key%'";
            $result = $mysqli -> query($sql);
            $row_cnt = $result -> num_rows;
            
            if($row_cnt > 0){
                while ( $row = $result -> fetch_assoc()) {
                    echo    '<a href="adminListingDetails.php?listingID='.$row['listingID'].'" class="childbox">';
                    echo    '<div class="image">';
                    
                    $sql2 = ' SELECT ap.photo FROM addphotos ap INNER JOIN listings l ON ap.listingID = l.listingID where ap.listingID = '.$row['listingID'].'';
                    $result2 = $mysqli -> query($sql2);
                    $row_cnt2 = $result2 -> num_rows;

                    if ($row_cnt2 == 0 ) {
                        echo '<img  src="images/facebook.png" id="AL_image" class="radius_box">';
                        }
                    elseif($row_cnt2 > 0){
                        while ( $row2 = $result2 -> fetch_assoc()) {
                            $pic = 'data:image/jpg;base64,'.base64_encode($row2['photo']);
                            echo '<img  src="'.$pic.'" id="AL_image" class="radius_box">';
                            break;
                            }
                        }
                   
                    echo    '</div>';
                    echo    '<div class="AL_columnmid">
                                <div class="AL_topmid radius_box">
                                    <div class="AL_topbox">
                                        <div class="AL_topTittle">
                                            Title :&nbsp;
                                        </div>
                                        <div class="AL_tittleContent">
                                        '.$row['title'].'
                                        </div>
                                    </div>
                                    
                                    <div class="AL_topbox">
                                        <div class="">
                                            Hosted by
                                        </div>

                                        <div>
                                        &nbsp;'.$row['Name'].'
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="AL_btmmid radius_box">
                                    <div style="min-width: 70px;">
                                        Location&nbsp;: 
                                    </div>

                                    <div style="min-height:20px">
                                    &nbsp;'.$row['Location'].'
                                    </div>
                                </div>
                            </div>
                    
                            <div class="columnright">
                                <div id="AL_dp">
                                    <div>
                                        DAILY PRICE:
                                    </div>
                                    <div>
                                        RM'.$row['rate'].'
                                    </div>
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
        