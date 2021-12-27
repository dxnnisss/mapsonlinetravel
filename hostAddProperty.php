<?php 
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'host') {
        header('location: index.php');
    }
    include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | Host</title>
        <link rel="stylesheet" href="style/host.css?">
        <link rel="tab icon" href = "images/maps icon.png">
    </head>

    <body>
        <?php require_once 'hostHeader.php'; ?>

        <main>
            <form action="hostAddPropertyInsert.php" ENCTYPE ="multipart/form-data" method="post">
                <div id="container">
                    <h3>Add Property</h3>
                    <br>
                    <div class="section">
                        <div class="label">
                            Property Name:
                        </div>
    
                        <div class="field">
                            <input type="text" name="propertyName" required="required" placeholder="Enter Property Name">
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Property Location:
                        </div>
    
                        <div class="field">
                            <input type="text" name="propertyLocation" required="required" placeholder="Enter Property Location">
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Property Description:
                        </div>
                        <div class="field" >
                            <textarea required="required" name="propertyDescription"></textarea>
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Rate Per Night (MYR):
                        </div>
    
                        <div class="field">
                            <input type="number" name="propertyRate" required="required" placeholder="Enter Property Rate/Night">
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Property Capacity: 
                        </div>
    
                        <div class="field">
                            <input type="number" name="propertyCapacity" required="required" placeholder="Enter Capacity">
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            &nbsp;
                        </div>
    
                        <div class="field">
                            <button type="submit" class="btn" name="addPropertyBtn">Add Property</button>
                            <button type="reset" class="btn">Reset</button>
                        </div>
                    </div>

                </div>
            </form>
            
        </main>
        
        <?php require_once 'hostFooter.php';?>
        <script src = "script/hostOverlay.js"></script>
</html>