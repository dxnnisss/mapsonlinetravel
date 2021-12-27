<header>
    <div id="logoDiv" class="logoDiv">
        <a href="index.php">
            <img src="images/maps blue.png" alt="MAPS Logo" width="200px">
        </a>
    </div>

    <form id="searchDiv" action="search.php" method="GET">
        <div>
            <label for="#destination">Destination</label><br>
            <input type="text" name="destination" placeholder="Where to go?" autocomplete="off">
        </div>
        <div>
            <label for="#checkIn">Check-in</label><br>
            <input type="date" id="checkIn" name="checkIn">
            <!-- date validation in JS -->
        </div>
        <div>
            <label for="#checkOut">Check-out</label><br>
            <input type="date" id="checkOut" name="checkOut">
            <!-- date validation in JS -->
        </div>
        <div>
            <label for="#guest">Guests</label><br>
            <select name="guest">
                <option value=""></option>
                <?php
                    for ($i = 1; $i < 10; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                ?>
                <option value="10">10+</option>
            </select>
        </div>
        <!-- by default sort by highest rating -->
        <input type="hidden" name="sort" value="starDesc">
        <button type="submit">&#x1F50D;</button>
    </form>

    <div id="loginDiv" class="loginDiv">
        <?php
            // if no isset will run into error: undefined key 'role' in array 
            // if logged in, the icon function will change accordingly
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
                echo "<img id=\"loginIcon\" src=\"images/login icon.png\" onclick=\"userOverlay()\" alt=\"Login Icon\">";
            }
            else {
                echo "<img id=\"loginIcon\" src=\"images/login icon.png\" onclick=\"generalOverlay()\" alt=\"Login Icon\">";
            }
        ?>
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
        <input type="email" name="accID" placeholder="johndoe@mail.com" autocomplete="off" required>
    </div>
    <div>
        <label for="#name">Name</label><br>
        <input type="text" name="uName" placeholder="John Doe" autocomplete="off" required>
    </div>
    <div>
        <label for="#dob">Date of Birth</label><br>
        <input type="date" name="uDOB" required>
    </div>
    <div>
        <label for="#password">Password</label><br>
        <input type="text" name="password" placeholder="Tp012345@AaBb" autocomplete="off" required>
    </div>
    <div>
        <input type="submit" id="signupBtn" class="btnHover" name="signupBtn" value="SIGN UP">
    </div>
</form>


<form id="joinAsHost" class="flex-sa-c" action="joinAsHost.php" method="POST">
    <div class="overlayTitle">Join As Host</div>
    <div>
        <label for="#email">Email</label><br>
        <input type="email" name="accID" placeholder="johndoe@mail.com" autocomplete="off" required>
    </div>
    <div>
        <label for="#name">Name</label><br>
        <input type="text" name="hName" placeholder="John Doe" autocomplete="off" required>
    </div>
    <div>
        <label for="#dob">Date of Birth</label><br>
        <input type="date" name="hDOB" required>
    </div>
    <div>
        <label for="#password">Password</label><br>
        <input type="text" name="password" palceholder="Tp012345@AaBb" autocomplete="off" required>
    </div>
    <div>
        <input type="submit" id="joinBtn" class="btnHover" name="joinBtn" value="JOIN NOW">
    </div>
</form>


<!-- FOR userOverlay -- option to nav to dashboard or logout -->
<div id="userOverlay" class="flex-sa-c">
    <div class="overlayTitle">Welcome!</div>
    <a href="myInfo.php" class="overlayBtn flex-c-c">
        DASHBOARD
    </a>
    <a href="logout.php" class="overlayBtn flex-c-c">
        LOGOUT
    </a>
</div>


<!-- for background purpose -->
<div id="backgroundImage"></div>


<!-- the searchDiv is already rendered, so js will work here -->
<script>
    // adding the mix max to the date picker
    const startDate = document.getElementById('checkIn');
    const endDate = document.getElementById('checkOut');

    const today = new Date();
    var year = today.getFullYear();
    // month displayed in 0 - 11
    var month = today.getMonth() + 1;
    var day = today.getDate();
    if (String(month).length < 2) {
        // add leading zero
        month = '0' + month;
    }
    if (String(day).length < 2) {
        // add leading zero
        day = '0' + day;
    }

    const strToday = String(year) + '-' + month + '-' + day;
    startDate.min = strToday;
    endDate.min = strToday;

    startDate.addEventListener('input', function() {
        var startValue = this.value;
        endDate.min = startValue;
    })
</script>