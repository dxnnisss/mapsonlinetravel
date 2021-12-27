<!DOCTYPE html>
<html lang="en">
    <head>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | Host Personal Details</title>
        <link rel="stylesheet" href="style/hostPersonalDetails.css?v=1">
        <link rel="tab icon" href = "images/maps icon.png">

        <script>
            function tab(t) {
                if (t==1) {
                    document.getElementById("personalDetailsContent").style.display = "block";
                    document.getElementById("bankingDetailsContent").style.display = "none";
                }

                if (t==2) {
                    document.getElementById("personalDetailsContent").style.display = "none";
                    document.getElementById("bankingDetailsContent").style.display = "block";
                }
            }
        </script> 

    </head>

    <body>
        <?php
            session_start();
            if (!isset($_SESSION['role']) || $_SESSION['role'] != 'host') {
                header('location: index.php');
            }
        ?>
        <?php
                include("connect.php");
                $accID = $_SESSION['accID'];
                $id = intval($_GET['id']); //intval — Get the integer value of a variable
                $result = $mysqli -> query("SELECT * FROM hosts WHERE hostID=$id");
                $row = $result-> fetch_array()
                
        ?>
        
        
        <?php include_once 'hostHeader.php'; ?>

        

        <main>

            <section id= "greetings">
                Manage Your Personal Details
            </section>

            <div class = 'flex_container'>
                <div class = "tab" id ="personalDetails" onclick="tab(1)">Personal Details</div>
                <div class = "tab" id ="bankingDetails" onclick="tab(2)">Banking Details</div>
            </div>

            <div class = 'flex_container'>
                <div class = "content" id ="personalDetailsContent">
                    
                    <form action="hostEditDetails.php" class= "hostUpdate" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="hostID" value="<?php echo $row['hostID'] ?>">
                        
                        
                        <div class="picfield">
                            <?php 
                                if ($row['hPicture'] == NULL) {
                                    echo '<img id="hPicDisplay" src="images/profile picture.png" alt="Profile Photo">';
                                }

                                else {
                                    echo "<img id='hPicDisplay' src=\"data:image/jpg;base64, " . base64_encode($row['hPicture']) . "\" width = '100px' height='100px' >"; 
                                }
                            ?>
                            <br><br>
                            <input type="file" 
                            onchange ="document.getElementById('hPicDisplay').src = window.URL.createObjectURL(this.files[0])" id = "hostpic" name="hostpic" accept="image/jpeg, image/jpg">
                            
                        </div>
                        <div class = personalDet>
                            <div class="namelabel">
                                Name: 
                            </div>

                            <div class="namefield">
                                <input type="text" name="hostName" required="required" value="<?php echo $row['hName']?>">
                            </div>

                            <div class="contactlabel">
                                Contact: 
                            </div>

                            <div class="contactfield">
                                <input type="tel" name="hostContact" required="required" value="<?php echo $row['hContact']?>">
                            </div>

                            <div class="label">
                                Gender: 
                            </div>
                            
                            <div class="field">
                                <input type="radio" name="hostGender" <?php if ($row['hGender'] == "male") { ?> checked="checked" <?php } ?> value="Male" required="required"> &nbsp;&nbsp;Male &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="hostGender" <?php if ($row['hGender'] == "female") { ?> checked="checked" <?php } ?> value="Female" required="required"> &nbsp;&nbsp;Female 
                            </div>
                            <br>
                            <div class="label">
                                Date of Birth: 
                            </div>

                            <div class="field">
                                <input type="date" name="hostDOB" required="required" value="<?php echo $row['hDOB']?>">
                            </div>

                            <div class="section">
                                <div class="label">
                                    &nbsp;
                                </div>
                                <div class="field">
                                    <button type="submit" class="btn" onclick="return confirm('Confirm Save Details?')">Edit</button>
                                </div>
                            </div>
                        
                        </div>
                    </form>

                </div>

                <div class = "content" id ="bankingDetailsContent">
                    <form action="hostBankUpdate.php" method="post">
                    <input type="hidden" name="hostID" value="<?php echo $row['hostID'] ?>">
                    <div class="section">
                        <div class="label">
                            Bank Name:
                        </div>
    
                        <div class="field">
                            <select name="bankName" required="required">
                                <option value = "" <?php if ($row['bankName'] == "NULL") { ?> selected = "selected" <?php } ?>>Please Select</option>
                                <option value="Maybank" <?php if ($row['bankName'] == "Maybank") { ?> selected="selected" <?php } ?>>Maybank</option>
                                <option value="Hong Leong Bank" <?php if ($row['bankName'] == "Hong Leong") { ?> selected="selected" <?php } ?> >Hong Leong Bank</option>
                                <option value="Public Bank" <?php if ($row['bankName'] == "Public Bank") { ?> selected="selected" <?php } ?>>Public Bank</option>
                            </select>
                        </div>
                        <br>
                        <div class="section">
                            <div class="label">
                                Bank Account Holder Name:
                            </div>
        
                            <div class="field">
                                <input type="text" name="bankAccName" required="required" value="<?php echo $row['bankAccName']?>" placeholder="Enter Name">
                            </div>
                        </div>

                        <div class="section">
                            <div class="label">
                                Bank Account Number:
                            </div>
        
                            <div class="field">
                                <input type="text" name="bankAccNum" required="required" value="<?php echo $row['bankAccNo']?>" placeholder="Enter Bank Account Number">
                            </div>
                        </div>

                        <div class="section">
                            <div class="label">
                                &nbsp;
                            </div>
                            <div class="field">
                                <button type="submit" class="btn" onclick="return confirm('Confirm Save Details?')">Edit</button>
                            </div>
                        </div>

                    </div>
                    </form>
                </div>
            </div>

        </main>

        <?php require_once 'hostFooter.php';?>
        <script src = "script/hostOverlay.js"></script>
    </body>
</html>