<header>
    <div id="logoDiv" class="logoDiv">
        <a href="index.php">
            <img src="images/maps blue.png" alt="MAPS Logo" width="200px">
        </a>
    </div>

    <div id="userNav" class="flex-sa-c">
        <a href="myInfo.php" id="myInfo" class="flex-sa-c btnHover">MY INFO</a>
        <a href="myBookings.php" id="myBookings" class="flex-sa-c btnHover">MY BOOKINGS</a>
        <a href="myReviews.php" id="myReviews" class="flex-sa-c btnHover">MY REVIEWS</a>
    </div>

    <div id="loginDiv" class="loginDiv">
        <img id="loginIcon" src="images/login icon.png" onclick="userOverlay()" alt="Login Icon">
    </div>
</header>

<div id="vpGreyOut" onclick="backToNormal()"></div>


<div id="generalOverlay" class="flex-sa-c">
    <div class="overlayTitle">Welcome!</div>
    <div onclick="login()" class="overlayBtn flex-c-c">
        LOGIN
    </div>
    <div onclick="signup()" class="overlayBtn flex-c-c">
        SIGN UP
    </div>
    <div onclick="joinAsHost()" class="overlayBtn flex-c-c">
        JOIN AS HOST
    </div>
</div>


<form id="login" class="flex-sa-c" action="login.php" method="POST">
    <div class="overlayTitle">User Login</div>
    <div>
        <label for="#username">Username</label><br>
        <input type="email" name="accID" placeholder="johndoe@mail.com" required>
    </div>
    <div>
        <label for="#password">Password</label><br>
        <input type="password" name="password" required>
    </div>
    <div>
        <input type="submit" id="loginBtn" class="btnHover" name="loginBtn" value="LOGIN">
    </div>
    <div class="forgetPW">Forget Password?</div>
</form>


<form id="signup" class="flex-sa-c" action="signup.php" method="POST">
    <div class="overlayTitle">Sign Up</div>
    <div>
        <label for="#email">Email</label><br>
        <input type="email" name="accID" placeholder="johndoe@mail.com" required>
    </div>
    <div>
        <label for="#name">Name</label><br>
        <input type="text" name="uName" placeholder="John Doe" required>
    </div>
    <div>
        <label for="#dob">Date of Birth</label><br>
        <input type="date" name="uDOB" required>
    </div>
    <div>
        <label for="#password">Password</label><br>
        <input type="text" name="password" placeholder="Tp012345@AaBb" required>
    </div>
    <div>
        <input type="submit" id="signupBtn" class="btnHover" name="signupBtn" value="SIGN UP">
    </div>
</form>


<form id="joinAsHost" class="flex-sa-c" action="joinAsHost.php" method="POST">
    <div class="overlayTitle">Join As Host</div>
    <div>
        <label for="#email">Email</label><br>
        <input type="email" name="accID" placeholder="johndoe@mail.com" required>
    </div>
    <div>
        <label for="#name">Name</label><br>
        <input type="text" name="hName" placeholder="John Doe" required>
    </div>
    <div>
        <label for="#dob">Date of Birth</label><br>
        <input type="date" name="hDOB" required>
    </div>
    <div>
        <label for="#password">Password</label><br>
        <input type="text" name="password" palceholder="Tp012345@AaBb" required>
    </div>
    <div>
        <input type="submit" id="joinBtn" class="btnHover" name="joinBtn" value="JOIN NOW">
    </div>
</form>


<!-- FOR userOverlay -- optionn to nav to dashboard or logout -->
<div id="userOverlay" class="flex-sa-c">
    <div class="overlayTitle">Welcome!</div>
    <a href="index.php" class="overlayBtn flex-c-c">
        HOME
    </a>
    <a href="logout.php" class="overlayBtn flex-c-c">
        LOGOUT
    </a>
</div>


<!-- for background purpose -->
<div id="backgroundImage"></div>