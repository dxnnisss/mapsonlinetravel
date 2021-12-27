<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Info</title>
    <link rel="stylesheet" href="style/myInfo.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'userHeader.php';
    ?>
    <main>
        <h1>My Profile</h1>
        <hr>

        <!-- to change action -->
        <form action="userSaveProfile.php" id="profile" class="flex-sa-c flex-fs" method="post" enctype="multipart/form-data">
            <div id="picSection" class="flex-col flex-sa-c flex-fs">
                <img id="uPicDisplay" src="images/profile picture.png" alt="Profile Photo">
                <input type="file" name="uPicture" id="uPicture" accept="image/jpeg, image/png" disabled>
            </div>

            <div id="textSection" class="flex-col flex-sa-c">
                <div>
                    <label for="accID">Email / Username:</label><br>
                    <input type="email" name="accID" id="accID" readonly>
                </div>
                <div>
                    <label for="uName">Name:</label><br>
                    <input type="text" name="uName" id="uName" required readonly>
                </div>
                <div>
                    <label for="uDOB">DOB:</label><br>
                    <input type="date" name="uDOB" id="uDOB" required readonly>
                </div>
                <div>
                    <label for="uGender">Gender:</label><br>
                    <div id="radioForGender" class="flex-sa-c">
                        <div >
                            <input type="radio" name="uGender" id="male" value="male" disabled>
                            <label for="male">Male</label>
                        </div>
                        <div>
                            <input type="radio" name="uGender" id="female" value="female" disabled>
                            <label for="female">Female</label> 
                        </div>
                    </div>
                </div>
                <div>
                    <label for="uContact">Contact:</label><br>
                    <input type="tel" name="uContact" id="uContact" placeholder="0123456789" readonly>
                </div>
                <div>
                    <label for="about">About Me:</label><br>
                    <textarea name="about" rows="5" id="about" placeholder="Tell us about your fun story!" readonly></textarea>
                </div>
                <div>
                    <div id="userEditProfile" onclick="enableEdit()">EDIT</div>
                    <button type="submit" id="userSaveProfile">SAVE</button>
                </div>
            </div>
        </form>
    </main>
    
    <?php
        // footer section 
        require_once 'masterFooter.php';
        require_once 'connect.php';

        $accID = $_SESSION['accID'];
        $sql = "SELECT * FROM users WHERE accID='$accID'";
        $result = $mysqli -> query($sql);

        // pull up user data from database
        if ($result -> num_rows != 1) {
            echo "<script>alert('Error occured!'); window.location.href='myInfo.php';</script>";
        }
        else {
            $row = $result -> fetch_assoc();
            echo "<script>";
            foreach ($row as $key => $value) {
                if ($key == 'userID') {
                    continue;
                }
                else if ($key == 'uGender') {
                    if ($value == 'male') {
                        echo "document.getElementById('male').checked = true;";
                    }
                    else if ($value == 'female') {
                        echo "document.getElementById('female').checked = true;";
                    }
                }
                else if ($key == 'about') {
                    echo "document.getElementById('about').innerHTML = '$value';";
                }
                else if ($key == 'uPicture') {
                    if ($value != '') {
                        $src = "data:image/jpg;base64," . base64_encode($value);
                        echo "document.getElementById('uPicDisplay').src = '$src';";
                    }
                }
                else {
                    echo "document.getElementById('$key').setAttribute('value', '$value');";
                }
            }
            echo "</script>";
        }
        $mysqli -> close();
    ?>
    <script src="script/master.js"></script>
    <script src="script/myInfo.js"></script>
</body>
</html>