<link rel="stylesheet" href="style/host.css?">

<!-- <?php
$accID = $_SESSION['accID'];
$user_img = $mysqli->query("SELECT hPicture FROM hosts where accID LIKE '%$accID%'");
?> -->

<header>
    <div id="logoDiv" class="logoDiv">
        <a href="host.php">
            <img src="images/maps blue.png" alt="MAPS Logo" width="200px">
        </a>
    </div>

    <div id="userNav" class="flex-sa-c">
        <div>
            Host View
        </div>
    </div>

    <div id="loginDiv" class="loginDiv">
        <?php 
            $img = $user_img ->fetch_assoc();

            if ($img['hPicture'] != NULL) {
                echo "<img id='loginIcon' src=\"data:image/jpg;base64, " . base64_encode($img['hPicture']) . "\" onclick='hostOverlay()'>";
            }
            else {
                echo '<img id="loginIcon" src="images/login icon.png" alt="Login Icon" onclick="hostOverlay()">';
            }
        ?>
        
        
        
    </div>
</header>

<div id="vpGreyOut" onclick="backToNormal()"></div>

<!-- FOR userOverlay -- optionn to nav to dashboard or logout -->
<div id="hostOverlay" class="flex-sa-c">
    <div class="overlayTitle">Welcome!</div>
    <a href="host.php" class="overlayBtn flex-c-c">
        HOME
    </a>
    <a href="logout.php" class="overlayBtn flex-c-c">
        LOGOUT
    </a>
</div>

<!-- Background -->
<div id="backgroundImage"></div>