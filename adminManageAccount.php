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
    <link rel="stylesheet" href="style/adminManageAccount.css">
    <link rel="stylesheet" href="style/adminOverlay.css">

</head>
<body>
    <!-- header section -->
    <?php include('adminHeader.php');?>
    <main>
        <!-- navigational bar -->
    <?php include 'topnav.php'?>
    
    <div class="search_bar">
        <form method="post" enctype="multipart/form-data">
            <label style="margin-left:10px;">
            Search : 
            </label>
            <input type="text" placeholder="Name...." name="search_key" class="search_input">
            <select class="filterBox" name="filter_key" id="selector_filter">
                <option <?php if(isset($_POST['filter_key']) && $_POST['filter_key'] == 'all') echo "selected = 'selected'";?> value="all">All</option>
                <option <?php if(isset($_POST['filter_key']) && $_POST['filter_key'] == 'user') echo "selected = 'selected'";?> value="user">User</option>
                <option <?php if(isset($_POST['filter_key']) && $_POST['filter_key'] == 'host') echo "selected = 'selected'";?> value="host">Host</option>
            </select>
            
            <button type="submit" name="searchbtn" class="button"><i class="uil uil-search"></i></button>
        </form>
        
    </div>
    
    <div class="parentbox">
        <?php 
        include("connect.php");
        //having connect to the database
        
        //search key and filter defined as empty
        $search_key = "";
        $filter_key= "";

        //checcking the search btn if the button is set any variable to it
        if(isset($_POST['searchbtn'])){
            $search_key = $_POST['search_key'];
            $filter_key = $_POST['filter_key'];
        }
        //if there is no variable tehn filter key will be all
        else{
            $filter_key = "all";
        }
        
        //based on filter key to declare which sql
        if($filter_key == "all"){
            $sql = "SELECT u.uName,u.uPicture,a.accID AS accID,a.role,a.accStatus,u.uGender as gender FROM users AS u INNER JOIN accounts AS a ON u.accID = a.accID WHERE uName LIKE '%$search_key%' UNION SELECT h.hName,h.hPicture,ac.accID,ac.role,ac.accStatus,h.hGender from hosts AS h INNER JOIN accounts AS ac ON h.accID = ac.accID  WHERE hName LIKE '%$search_key%'";
        }
        elseif($filter_key == "user"){
            $sql = "SELECT u.uName,u.uPicture,a.accID AS accID,a.role,a.accStatus,u.uGender as gender FROM users AS u INNER JOIN accounts AS a ON u.accID = a.accID WHERE uName LIKE '%$search_key%'  ";
            
        }
        elseif($filter_key == "host"){
            $sql = "SELECT h.hName as uName ,h.hPicture as uPicture ,ac.accID AS accID,ac.role,ac.accStatus,h.hGender as gender from hosts AS h INNER JOIN accounts AS ac ON h.accID = ac.accID  WHERE hName LIKE '%$search_key%' ";
        }
        
        

        //getting the result of the sql from database
        $result = $mysqli -> query($sql);
        //checking the rows that was affected
        $row_cnt = $result -> num_rows;
        //if the row count was more than 1
        if($row_cnt > 0){
            // while loop the result and turn the data into a array as row
            while ( $row = $result -> fetch_assoc()) {
                //checking if the image is empty
                if( empty($row['uPicture'])){
                    $uimage = "images/login icon.png";
                }
                // encoding the picture from numbers to picture
                else{
                    $uimage = 'data:image/jpg;base64,'.base64_encode($row['uPicture']);
                }
                
                
                // the box that each user and host account
                $data = '
                
                <a href="adminUserAccount.php?accID='.$row['accID'].'&type_role='.$row['role'].'" id="AMA_childbox" class="childbox ">
                   
                    <div class="image">
                    <img src="'.$uimage.'" id="AMA_images">
                    </div>

                    <div class="columnmid">
                    <div class="topmid">
                        <div class="AMA_textrow">
                        <div class="tname">
                           Name : 
                        </div>
                        <div class="content">
                            '.$row['uName'].'
                        </div>
                        </div>';
                        

                    $data .= '
                    </div>
                    <div class="btmmid">
                       Email: '.$row['accID'].'
                       
                    </div>
                    </div>
                    <div class="columnright">
                        <div class="AMA_textrowright">
                            <div class="smallbox">
                                User Type :
                            </div>
                            <div class="r_content">
                            &nbsp;'.$row['role'].'
                            </div>
                        </div>
                        <div class="AMA_textrowright">
                            <div class="smallbox">
                                Status :
                            </div>
                            <div class="r_content">
                            &nbsp;'.$row['accStatus'].'
                            </div>
                        </div>
                    </div>
                </a>
            ';
            // echo the html code from the variable of data
            echo $data;
            }

        }

       ?>

    </div>
    

    </main>
    <!-- linking the overlay script -->
    <script src="script/adminOverlay.js"></script>
</body>
</html>

