<header>
    <div id="logoDiv" class="logoDiv">
        <a href="adminManageAccount.php">
            <img src="images/maps blue.png" alt="MAPS Logo" width="200px">
        </a>
    </div>

    <div id="userNav" class="flex-sa-c">
        <div>
            Admin Session
        </div>
    </div>

    <div id="loginDiv" class="loginDiv">
        <img id="loginIcon" src="images/login icon.png" onclick="adminOverlay()" alt="Login Icon">
    </div>
</header>

<div id="vpGreyOut" onclick="backToNormal()"></div>

<!-- FOR userOverlay -- optionn to nav to dashboard or logout -->
<div id="adminOverlay" class="flex-sa-c">
    <div class="overlayTitle">Welcome!</div>
    <a href="adminManageAccount.php" class="overlayBtn flex-c-c">
        HOME
    </a>
    <a href="logout.php" class="overlayBtn flex-c-c">
        LOGOUT
    </a>
</div>

<div id="backgroundImage"></div>