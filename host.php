<?php
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'host') {
        header('location: index.php');
    }
?>
<?php include("connect.php");
    $accID = $_SESSION['accID'];
    $hostID =$_SESSION['hostID'];
    $results = $mysqli -> query("SELECT * FROM hosts WHERE accID LIKE '%$accID%'");
    $user_img = $mysqli->query("SELECT hPicture FROM hosts where accID LIKE '%$accID%'");
    ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | Host</title>
        <link rel="stylesheet" href="style/host.css">
        
        <link rel="tab icon" href = "images/maps icon.png">
    </head>

    <body>
        
        
        <?php 
        include ('hostHeader.php');
        ?>
        <main>
        
        

            <div class="host_main">
                <section id="greetings">
                    <script>
                        var currentDate = new Date();
                        var currentHour = currentDate.getHours();
                        var displayedGreetings;

                        if (currentHour <12) {
                            displayedGreetings ="Good Morning!<br>Welcome to Host Mode!";
                        }
                        else if (currentHour <17) {
                            displayedGreetings = "Good Afternoon!<br>Welcome to Host Mode!";
                        }
                        else if (currentHour <=23) {
                            displayedGreetings = "Good Evening!<br>Welcome to Host Mode!";
                        }

                        document.getElementById('greetings').innerHTML = displayedGreetings;
                    </script>
                </section>

                <br><br>

                <div class="functionDropdown">
                    <button class='dropBtn'>What's on your mind today?</button>
                    <div class = "dropContent">
                        <?php 
                        while($row=mysqli_fetch_array($results)) {
                             $data = '<a href="hostPersonalDetails.php?id='.$row['hostID'].'">Manage Personal Details</a>';
                             echo $data;
                        }
                        
                        ?>
                        <a href="hostManageProperty.php">Manage Properties</a>
                        <a href="hostReviews.php">Customer Reviews</a>
                    </div>
                </div>
                
                <div class="walletDropdown">
                    <button class='dropBtn'>Manage Your Wallet</button>
                    <div class="walletDropContent">
                        <a href="hostTransaction.php">Manage Transactions</a>
                        <a href="hostWithdrawal.php">Wallet Withdrawal</a>
                    </div>
                </div>

                
        </main>

        <?php require_once 'hostFooter.php';?>

        <script src = "script/hostOverlay.js"></script>
</html>