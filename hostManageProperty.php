<?php 

    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'host') {
        header('location: index.php');
    }

    include("connect.php");

    $hostID = $_SESSION['hostID'];
    $result = $mysqli ->query("SELECT * FROM listings WHERE hostID LIKE '%$hostID%' and listingStatus = 'activated' ORDER BY title");
   ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | Host</title>
        <link rel="stylesheet" href="style/hostManageProperty.css?">
        <link rel="tab icon" href = "images/maps icon.png">
    </head>

    <body>
        <?php require_once 'hostHeader.php'; ?>

        <main>
        <div class = 'host_property'>
                <section id="greetings">Your Properties
                    
                </section>
        </div>

        <div class="addPropertyBtn">
        <button class="addProperty" onclick="window.location.href='hostAddProperty.php'">Add Property</button>
        </div>
        
        <div class= "parentbox">
            
            <?php
           
                while($row = $result->fetch_array()) {

                    $data = '<div class="childbox">
                    <h3>'.$row['title'].'</h3> <br>
                    Location: '.$row['location'].' <br>
                    
                    Rate: RM  '.$row['rate'].' <br>
                    Capacity: '.$row['guest'].'<br><br><br>
                    <a class="edit" href="hostEditProperty.php?id='.$row['listingID'].'">Edit</a> <a class="delete" onclick="return confirm(\'Delete '.$row['title'].' record?\');" href="hostDeleteProperty.php?id='.$row['listingID'].'">Delete</a>
                    </div>';
                    
                    echo $data;
                
                }
            ?>
        </div>
        </main>

        <?php require_once 'hostFooter.php';?>
        <script src = "script/hostOverlay.js"></script>
</html>