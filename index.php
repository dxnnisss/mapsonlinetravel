<?php
    session_start();
    if (isset($_SESSION['role'])) {
        switch ($_SESSION['role']) {
            case 'admin':
                header('location: adminManageAccount.php');
                // change target
                break;
            
            case 'host':
                header('location: host.php');
                // change target
                break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPS | Your Destination</title>
    <link rel="stylesheet" href="style/index.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'masterHeader.php';
    ?>
    
    <main>
        <div id="mainDiv1" class="mainDivs">
            <div id="leftRecList" class="recList flex-col flex-sa-c">
                <?php
                    $destination = ['Batu Caves', 'George Town', 'Ipoh', 'Langkawi', 'Melaka', 'Semporna', 'Cameron Highlands', 'Sekinchan'];
                    for ($i = 0; $i < 4; $i++) {
                        $desID = str_replace(" ", "", strtolower($destination[$i]));
                        // urlencode can change spaces from %20 to + sign
                        $url = 'search.php?destination=' . urlencode($destination[$i]) . '&sort=starDesc';
                        echo "<a id=\"$desID\" class=\"recItem\" href=\"$url\">$destination[$i]</a>"; 
                    }
                ?>
            </div>
            <div id="motd" class="flex-col flex-sb-c">
                <h1 id='motdGreeting'></h1>
                <div id='motdCover'></div>
                <h3 id='motdMsg'></h3>
                </div>
            
            
            <div id="rightRecList" class="recList flex-col flex-sa-c">
                <?php
                    for ($i = 4; $i < 8; $i++) {
                        $desID = str_replace(" ", "", strtolower($destination[$i]));
                        // urlencode can change spaces from %20 to + sign
                        $url = 'search.php?destination=' . urlencode($destination[$i]) . '&sort=starDesc';
                        echo "<a id=\"$desID\" class=\"recItem\" href=\"$url\">$destination[$i]</a>";  
                        
                    }
                ?>
            </div>
        </div>

        <div id="mainDiv2" class="mainDivs flex-sb-c">
            <h3>Having pets? Driving along? Gym enthusiast? No worries!</h3>
            <ul>
                <?php
                    $title = [
                        'Parking Available', 
                        'Pets Allowed', 
                        'Swimming Pool', 
                        'Laundry Facilities', 
                        'Toiletries Provided', 
                        'Gymnasium', 
                        'Balcony', 
                        'Cooking Utensils',
                        'Landed',
                        'Shore View',
                        'Self Check-in',
                        'Netflix'];
                    $imgSrc = [
                        'car.jpg', 
                        'pet.png', 
                        'pool.jpg', 
                        'laundry.png', 
                        'toiletries.png', 
                        'gym.png', 
                        'balcony.png', 
                        'utensil.png', 
                        'house.png',
                        'sunset.jpg',
                        'key.png',
                        'netflix.png'];

                    for ($i = 0; $i < 12; $i++) {
                    $name = str_replace(' ', '',strtolower($title[$i]));
                    // urlencode can change spaces from %20 to + sign
                    $url = 'search.php?tag=' . urlencode($title[$i]) . '&sort=starDesc';
                    echo "<a id=\"$name\" href=\"$url\">";
                    echo "<li class=\"flex-c-c\"><img src=\"images/tag/$imgSrc[$i]\" alt=\"$title[$i]\"><span>$title[$i]</span></li></a>";
                    }
                ?>
            </ul>
        </div>
    </main>

    <?php
        // footer section
        require_once 'masterFooter.php';
    ?>
    
    <script src="script/master.js"></script>
    <script src="script/index.js"></script>
</body>
</html>