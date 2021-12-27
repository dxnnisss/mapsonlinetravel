<?php 
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPS | Your Destination</title>
    <link rel="stylesheet" href="style/master.css">
    <link rel="tab icon" href="images/maps icon.png">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="style/adminUserAccount.css">
    <link rel="stylesheet" href="style/adminOverlay.css">
    

</head>
<body>
    <!-- grey out including the header -->
    <div id="vpGreyOut" onclick="backToNormal()"></div>
    
    <!-- header section -->
    <?php include('adminHeader.php'); ?>
    <main>
    
    <?php include 'topnav.php'?>
    
    <div class="parentbox">
    <?php
    
    include ("connect.php");

    // getting the data from manage account page
    $accID = $_GET['accID'];

    
    $type_role = $_GET['type_role'];

    // checking the type role and declaring which sql
    if($type_role == 'user'){

        $sql = "SELECT u.uName AS 'Name', u.userID AS 'uID', a.role AS 'Role', u.accID AS 'AccID', u.uContact AS 'Contact', 
                u.uGender 'Gender',u.uDOB AS 'DOB', u.uPicture AS 'Picture',u.about AS 'About',a.accStatus AS'Status' 

                FROM users AS u INNER JOIN accounts AS a ON u.accID = a.accID 

                where u.accID ='$accID' ";
    }
    elseif($type_role == 'host'){

        $sql = "SELECT h.hName AS 'Name', h.hostID AS 'hID', a.role AS 'Role', h.accID AS 'Account ID(Email)', h.hContact AS 'Contact', 
                h.hGender 'Gender',h.hDOB AS 'DOB', h.hPicture AS 'Picture',a.accStatus AS'Status',h.bankName AS 'Bank', 
                h.bankAccNo AS 'Bank Acc No',h.bankAccName AS 'Bank Acc Name',h.walletBalance AS 'Balance'

                FROM hosts AS h INNER JOIN accounts AS a ON h.accID = a.accID 

                where h.accID ='$accID'";
    }

    $result = $mysqli -> query($sql);
    
    $row_cnt = $result -> num_rows;
    // only one row will be affected as it is getting the account detail of one person only
    if($row_cnt == 1){

        while($row = $result -> fetch_assoc()){
            $status = $row['Status'];
        //    if the person is a user
            if($row['Role'] == "user"){
                $id = $row['uID'] ;
                // left column on the web page

                echo '<div class="left_column">';

                // if the picture is empty it will put the default profile picture
                if(empty($row['Picture'])){

                    echo '<img src="images/facebook.png" class="profile_image">';
                }
                else{

                    $pic = 'data:image/jpg;base64,'.base64_encode($row['Picture']);

                    echo '<img src="'.$pic.'" class="profile_image">';
                }

                // looping each data and check the value if it is empty
                foreach($row as $key => $value){
                    if($value != ''){
                        $content_detail[$key] =$value;
                        continue;
                    }
                    else{
                        $content_detail[$key]='N/A';
                    }
                    
                }

                
                echo '</div>';
                
                // middle column of the page

                echo '<div class="middle_column font_20px">';
                    
                // looping each contentdetail except uid, picture and status
                foreach($content_detail as $key => $value){
                    if($key == 'uID' || $key == 'Picture'||$key=='status'){
                        continue;
                    }
                    else{
                        echo    '<div class="middlerow">';

                        echo    '<div class="item-title">';
                        echo    "$key ";
                        echo    '</div>
                                 <div>';
                        
                        echo    "$value";
                        echo    '</div>
                                 </div>';
                    }
                }
                    
                echo '</div>';
                    
                echo '<div class="rcolumn">';


                // right column status box
                echo   "<div class=\"rupbox\" >";
                echo   $row['Status'];
                echo   "</div>";
                ?>


                <!-- button at the right from ban or disabling button -->
                <button class="rdobox" onclick="generalOverlay()">
                    Action
                </button>
                <?php
                
                $statusList = ['active'=>'Activate','banned'=>'Ban',];
                ?>


                <div id="vpGreyOut" onclick="backToNormal()"></div>


                <div id="generalOverlay" class="flex-bt-c">
                    <div class="overlayTitle" >Action can be taken.</div>
                        <?php 
                        // looping the array 
                        foreach($statusList as $key => $value){

                            // validate teh account status and remove the 
                            if($status == $key){
                                continue;
                            }
                            else {
                                // array that is does not skipped will be echoed here
                                echo    '<button onclick="'.strtolower($value).'()" class="overlayBtn flex-c-c">
                                        '.$value.'
                                        </button>';
                            }
                        }
                        ?>
                </div>
                <?php
                $confirm_action = ['actConfirm','banConfirm'];
                $statusList2 = ['active','banned'];
                $statusTitle = ['Activate','Ban'];

                // to check which type of the status of the account and displaying to the admin on what action can be done
                for($i=0; $i<2;$i++){
                    echo '
                    <div id="'.$confirm_action[$i].'" class="flex-sa-c">
                    <div id="overlayTitle">'.$statusTitle[$i].' Confirmation</div>
                        <div class="flex_row">
                            <button onclick="backToNormal()" class="ybox">
                                No
                            </button>
                            
                            <button onclick="redAction(\''.$accID.'\',\''.$statusList2[$i].'\',\''.$type_role.'\',\''.$row['uID'].'\')" class="ybox">

                                Yes
                            </button>
                        </div>
                </div>';
                }
                // bringing the value to the user changes php for banning or activing while also able to lacte back to this user
                ?>
                </div>
            <?php
            }

           

            // while the role is host
            elseif($type_role=="host"){
                $id = $row['hID'];
                echo '<div class="left_column">';

                if(empty($row['Picture'])){

                    echo '<img src="images/facebook.png" class="profile_image">';
                }
                else{

                    $pic = 'data:image/jpg;base64,'.base64_encode($row['Picture']);

                    echo '<img src="'.$pic.'" class="profile_image">';
                }

                foreach($row as $key => $value){
                    if($value != ''){
                        $content_detail[$key] =$value;
                        continue;
                    }
                    else{
                        $content_detail[$key]='N/A';
                    }
                    
                }
               

                echo '</div>';
                        
                echo '<div class="middle_column">';
                    
                

                
                foreach($content_detail as $key => $value){
                    if($key == 'hID' || $key == 'Picture'||$key=='status'){
                        continue;
                    }
                    else{
                        echo    '<div class="middlerow">';

                        echo    '<div class="item-title">';
                        echo    "$key ";
                        echo    '</div>
                                 <div>';
                        
                        echo    "$value";
                        echo    '</div>
                                 </div>';
                    }
                }
                
                    
                echo '</div>';
                    
                echo '<div class="rcolumn">';
            
                echo   "<div class=\"rupbox\">";
                echo   $row['Status'];
                echo   "</div>";
                ?>
                
                <button class="rdobox" onclick="generalOverlay()">
                    action
                </button>
                <?php
                
                $statusList = ['active'=>'Activate','banned'=>'Ban'];
                ?>
                <div id="vpGreyOut" onclick="backToNormal()"></div>
                    
                    
                <div id="generalOverlay" class="flex-sa-c">
                    <div class="overlayTitle">Action can be taken.</div>
                        <?php 
                        foreach($statusList as $key => $value){
                            if($status == $key){
                                continue;
                            }
                            else {
                                echo    '<button onclick="'.strtolower($value).'()" class="overlayBtn flex-c-c">
                                        '.$value.'
                                        </button>';
                            }
                        }
                        ?>
                </div>
                <?php
                $confirm_action = ['actConfirm','banConfirm'];
                $statusList2 = ['active','banned'];
                $statusTitle = ['Activate','Ban'];
                for($i=0; $i<2;$i++){
                    echo '
                    <div id="'.$confirm_action[$i].'" class="flex-bt-c">
                    <div id="overlayTitle">'.$statusTitle[$i].' Confirmation</div>
                        <div class="flex_row">
                            <button onclick="backToNormal()" class="ybox">
                                No
                            </button>
                            
                            <button onclick="redAction(\''.$accID.'\',\''.$statusList2[$i].'\',\''.$type_role.'\',\''.$row['hID'].'\')" class="ybox">
                            
                                Yes
                            </button>
                        </div>
                </div>';
                }
                ?>
                </div>
    <?php     
            }
            
        }
    }
    // closing the connection
    $mysqli -> close();
    ?>

                
</div>
</main>
<script src="script/adminOverlay.js"></script>
</body>