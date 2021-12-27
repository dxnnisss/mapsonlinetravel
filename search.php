<?php
    session_start();
    if ((isset($_SESSION['role']) && $_SESSION['role'] != 'user') || count($_GET) == 0) {
        header('location: index.php');
    }

    // checkIn and checkOut must be bundle
    if (isset($_GET['checkIn']) || isset($_GET['checkOut'])) {
        if (($_GET['checkIn'] == null) xor ($_GET['checkOut'] == null)) {
            echo  "<script>alert('Check-in date must come together with Check-out date!');
                    window.location.href = 'index.php';</script>";
        }
    }
    
    require_once 'connect.php';

    // establish flags for $_GET superglobals
    // if isset tag, other should not be set
    if (isset($_GET['tag'])) {
        $gotTag = $_GET['tag'] != null;
        $gotDestination = false;
        $gotDates = false;
        $gotGuest = false;
    }
    else {
        $gotTag = false;

        // isset destination
        if (isset($_GET['destination'])) {
            $gotDestination = $_GET['destination'] != null;
        }
        else {
            $gotDestination = false;
        }

        // isset checkIn and checkOut
        if (isset($_GET['checkIn'])) {
            $gotDates = ($_GET['checkIn'] != null) && ($_GET['checkOut'] != null);
        }
        else {
            $gotDates = false;
        }

        // isset guest number
        if (isset($_GET['guest'])) {
            $gotGuest = $_GET['guest'] != null;
        }
        else {
            $gotGuest = false;
        }
    }

    // case of redirected from home page's tags
    if ($gotTag) {
        $tagArray = [];
        $keyword = $_GET['tag'];
        $sql = "SELECT DISTINCT lt.listingID 
                FROM listingtag lt 
                INNER JOIN tags t ON lt.tagID = t.tagID 
                INNER JOIN listings l ON l.listingID = lt.listingID
                WHERE t.tName LIKE '%$keyword%'
                AND l.listingStatus = 'activated'";

        $result = $mysqli -> query($sql);
        while ($row = $result -> fetch_assoc()) {
            $tagArray[] = $row['listingID'];
        }
    }

    // finding result for destination criteria
    if ($gotDestination) {
        $destArray = [];
        $keyword = $_GET['destination'];
        $sql = "SELECT listingID 
                FROM listings
                WHERE (title LIKE '%$keyword%' OR
                location LIKE '%$keyword%' OR
                description LIKE '%$keyword%')
                AND listingStatus = 'activated'";

        $result = $mysqli -> query($sql);
        if ($result -> num_rows > 0) {
            while ($row = $result -> fetch_assoc()) {
                $destArray[] = $row['listingID'];
            }
        }
    }

    if ($gotDates) {
        $dateArray = [];
        $keyword1 = $_GET['checkIn'];
        $keyword2 = $_GET['checkOut'];
        $sql = "SELECT listingID FROM listings
                WHERE listingID NOT IN (
                    SELECT listingID FROM bookings 
                    WHERE ((startDate BETWEEN ? AND ?) OR (endDate BETWEEN ? AND ?))
                    AND bookingStatus IN ('booked', 'confirmed'))
                AND listingStatus = 'activated' 
                ORDER BY listingID;";

        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param('ssss', $keyword1, $keyword2, $keyword1, $keyword2);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if ($result -> num_rows > 0) {
            while ($row = $result -> fetch_assoc()) {
                $dateArray[] = $row['listingID'];
            }
        }
    }

    // finding result for guest criteria
    if ($gotGuest) {
        $guestArray = [];
        $keyword = $_GET['guest'];
        $sql = "SELECT listingID 
                FROM listings
                WHERE guest >= $keyword
                AND listingStatus = 'activated'";
        
        $result = $mysqli -> query($sql);
        if ($result -> num_rows > 0) {
            while ($row = $result -> fetch_assoc()) {
                $guestArray[] = $row['listingID'];
            }
        }
    }

    // the final set of listingID that need to be displayed
    $toDisplay = [];

    // CASE 1: if got tag, others wont be exist in $_GET
    if ($gotTag) {
        $toDisplay = $tagArray;
    }

    // CASE 2: all threee criteria is set
    else if ($gotDestination && $gotDates && $gotGuest) {
        $toDisplay = array_intersect($destArray, $dateArray, $guestArray);
    }

    // CASE 3: destination and dates only
    else if ($gotDestination && $gotDates) {
        $toDisplay = array_intersect($destArray, $dateArray);
    }

    // CASE 4: destination and guest only
    else if ($gotDestination && $gotGuest) {
        $toDisplay = array_intersect($destArray, $guestArray);
    }

    // CASE 5: dates and guest only
    else if ($gotDates && $gotGuest) {
        $toDisplay = array_intersect($dateArray, $guestArray);
    }

    // CASE 6: destination only
    else if ($gotDestination) {
        $toDisplay = $destArray;
    }

    // CASE 7: dates only
    else if ($gotDates) {
        $toDisplay = $dateArray;
    }

    // CASE 8: guest only
    else if ($gotGuest) {
        $toDisplay = $guestArray;
    }

    // CASE 9: other than anticipated scenario
    else {
        echo "<script>alert('Come again with some info so that we can match one for you!');
                window.location.href = 'index.php';</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style/search.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'masterHeader.php';
    ?>
    <main>
        <h1>Search Results</h1>
        <hr>

        <?php
            // $_SERVER['HTTP_REFERER'] can do but not reliable (not all user agent will support)
            // $_SERVER[HTTP_HOST] return the host header (localhost)
            // $_SERVER[REQUEST_URI] return the URI that used to access this page
            // Unified Resource Identifier (URI), superset of URL
            $thisURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $clearSort = strpos($thisURL, '&sort=');
            if ($clearSort != false) {
                $thisURL = substr($thisURL, 0, $clearSort);
            }

            if (count($toDisplay) == 0) {
                ; // pass
            }
            else {
                echo '<div id="filter" class="flex-sb-c" method="POST">
                        <div>Sort by: </div>
                        <a id="starDesc" href="' . $thisURL . '&sort=starDesc">&#9660; Rating</a>
                        <a id="starAsc" href="' . $thisURL . '&sort=starAsc">&#9650; Rating</a>
                        <a id="priceDesc" href="' . $thisURL . '&sort=priceDesc">&#9660; Price</a>
                        <a id="priceAsc" href="' . $thisURL . '&sort=priceAsc">&#9650; Price</a>
                        <a href="' . $thisURL . '">&#10060; Clear</a>
                    </div>';
            }

            // for sorting purpose
            if (isset($_GET['sort'])) {
                echo "<script>
                            const element = document.getElementById('$_GET[sort]').style;
                            element.color = 'white';
                            element.backgroundColor = 'rgb(146, 146, 146)';
                      </script>";

                // sql command to sort all listing by highest rating
                $sortStarSQL = "SELECT l.listingID 
                                FROM listings l INNER JOIN bookings b 
                                ON l.listingID = b.listingID 
                                INNER JOIN reviews r 
                                ON r.bookingID = b.bookingID 
                                GROUP BY l.listingID 
                                ORDER BY AVG(r.stars) DESC;";

                // sql command to sort all listing by highest price
                $sortPriceSQL = "SELECT listingID FROM listings ORDER BY rate DESC;";

                // decide which sql command to use
                // default is desc, if asc order, $reverse will be flagged to true
                // method is to distinguish sort by rating or price, as both using dif method
                switch ($_GET['sort']) {
                    case 'starDesc':
                        $sortSQL = $sortStarSQL;
                        $reverse = false;
                        $method = 'intersectAndDiff';
                        break;

                    case 'starAsc':
                        $sortSQL = $sortStarSQL;
                        $reverse = true;
                        $method = 'intersectAndDiff';
                        break;

                    case 'priceDesc':
                        $sortSQL = $sortPriceSQL;
                        $reverse = false;
                        $method = 'intersect';
                        break;

                    case 'priceAsc':
                        $sortSQL = $sortPriceSQL;
                        $reverse = true;
                        $method = 'intersect';
                        break;

                    default:
                        break; // pass
                }

                $sortResult = $mysqli -> query($sortSQL);

                // generating a order array as benchmark
                $sortArray = [];
                while ($row = $sortResult -> fetch_assoc()) {
                    array_push($sortArray, $row['listingID']);
                }

                switch ($method) {
                    case 'intersect':
                        // sortArray defines order, toDisplay defines what to show
                        // putting sortArray at first will take intersect according to its order
                        $toDisplay = array_intersect($sortArray, $toDisplay);
                        // asc or desc, defined by flag
                        if ($reverse) {
                            $toDisplay = array_reverse($toDisplay);
                        }
                        break;

                    case 'intersectAndDiff':
                        // taking the priority set in result set (toDisplay)
                        $priority = array_intersect($sortArray, $toDisplay);
                        // find the remainder (maybe those who dont have reviews)
                        $remainder = array_diff($toDisplay, $priority);
                        // check whether have any remainder;
                        if (count($remainder) != 0) {
                            $toDisplay = array_merge($priority, $remainder);
                        }
                        // asc or desc, defined by flag
                        if ($reverse) {
                            $toDisplay = array_reverse($toDisplay);
                        } 
                        break;
                }
            }
        ?>

        <?php
            if (count($toDisplay) == 0) {
                echo '<div id="noResult">No result matches your search!</div>';
            }
            foreach ($toDisplay as $listingID) {
                $sql = "SELECT listingID, title, location, guest, rate, avgStars, recordCount
                        FROM (
                        SELECT l.listingID, l.title, l.location, l.guest, l.rate, AVG(r.stars) avgStars, COUNT(r.stars) recordCount 
                        FROM listings l INNER JOIN bookings b 
                        ON l.listingID = b.listingID 
                        INNER JOIN reviews r 
                        ON r.bookingID = b.bookingID 
                        WHERE l.listingID = '$listingID'
                        GROUP BY l.listingID, l.title, l.location, l.guest, l.rate) averageStars";

                $result = $mysqli -> query($sql);

                // case of no review at all, requery with different sql
                if ($result -> num_rows != 1) {
                    $sql = "SELECT listingID, title, location, guest, rate 
                            FROM listings WHERE listingID = '$listingID'";
                    $result = $mysqli -> query($sql);
                }

                $row = $result -> fetch_assoc();
                
                // start to assign value from result obj to var
                $title = $row['title'];
                $location = $row['location'];
                $guest = $row['guest'];
                $rate = number_format($row['rate'], 2);

                $avgStars = number_format(0, 1);
                if (isset($row['avgStars'])) {
                    $avgStars = number_format($row['avgStars'], 1);
                }
                $starsToDisplay = round($avgStars);

                $recordCount = 0;
                if (isset($row['recordCount'])) {
                    $recordCount = $row['recordCount'];
                }

                // retrieve tags
                $sql = "SELECT lt.listingID, t.tName tag 
                        FROM tags t 
                        INNER JOIN listingtag lt 
                        ON lt.tagID = t.tagID 
                        WHERE lt.listingID = '$listingID'";
                
                $result = $mysqli -> query($sql);
                if ($result -> num_rows == 0) {
                    $tags = 'No tags associated.';
                }
                else {
                    $tags = [];
                    while ($row = $result -> fetch_assoc()) {
                        array_push($tags, $row['tag']);
                    }
                    $tags = join(', ', $tags);
                }

                // retriving a photo
                $sql = "SELECT photo FROM addphotos WHERE listingID = '$listingID' LIMIT 1";
                $result = $mysqli -> query($sql);
                $row = $result -> fetch_assoc();

                $imageDataURL = 'images/maps blue.png';
                if (isset($row['photo'])) {
                    $imageBLOB = $row['photo'];
                    $imageDataURL = 'data:image/jpg;base64,' . base64_encode($imageBLOB);;
                }

                echo '<a href="listing.php?listingID=' . $listingID . '" class="listingBar flex-sa-c">';

                echo '<img class="photoCol" src="' . $imageDataURL . '"/>
                        <div class="detailsCol flex-col flex-fs flex-sb-c">';

                echo '<div class="title">' . $title . '</div>';

                echo '<div class="location">' . $location . '</div>';

                echo '<div class="starsAndGuest"><div class="stars"><span>';

                for ($i = 0; $i < $starsToDisplay; $i++) {
                    echo '&#9733; ';
                }

                while ($i++ < 5) {
                    echo '&#9734; ';
                }

                echo "</span>&nbsp; &nbsp;($avgStars)<br>$recordCount reviews</div>";

                echo '<div class="guest"><span>Capacity:</span><br>&nbsp; &nbsp;' . $guest . ' guests</div></div>';

                echo '<div class="tags">' . $tags . '</div></div>';

                echo '<div class="priceCol flex-col flex-sa-c"><div>';

                echo 'RM ' . $rate . ' / day</div></div></a>';
            }
        ?>
    </main>
    
    <?php
        // footer section 
        require_once 'masterFooter.php';
    ?>

    <script src="script/master.js"></script>
    <script>
        // to smaller the font for long string
        const titles = document.getElementsByClassName('title');
        for (let i = 0; i < titles.length; i++) {
            if (titles[i].innerHTML.length >= 40) {
                titles[i].style.fontSize = '1.4vw';
            }
        }

        const tags = document.getElementsByClassName('tags');
        for (i = 0; i < tags.length; i++) {
            if (tags[i].innerHTML.length >= 60) {
                tags[i].style.fontSize = '1.08rem';
            }
        }
    </script>
</body>
</html>