<?php 
    session_start();
    if (!isset($_SESSION['role']) || !isset($_GET['id']) || $_SESSION['role'] != 'host') {
        header('location: hostManageProperty.php');
    }
    include("connect.php");

    $hostID = $_SESSION['hostID'];
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM listings WHERE listingID = $id ";
    $result = $mysqli->query($sql);
    $correct_host = false;

    $sqlCheck = "SELECT DISTINCT listingID FROM listings WHERE hostID = $hostID";
    $sqlCheckResult = $mysqli->query($sqlCheck);
    while ($check = $sqlCheckResult ->fetch_assoc()) {
        if ($check['listingID'] == $_GET['id']) {
            $correct_host = true;
        }
    }

    if (!$correct_host) {
        echo "<script>alert('This listing doesn\'t belongs to you!');
            window.location.href = 'hostManageProperty.php';</script>";
    }

    while($row = $result->fetch_array())
    {
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
        <?php require_once 'hostHeader.php';?>

        <main>
            <form action="hostPropertyUpdate.php" ENCTYPE ="multipart/form-data" method="post">
            
                <input type="hidden" name="id" value="<?php echo $row['listingID'] ?>">    
                <div id="container">
                    <h3>Edit Property</h3>
                    <br>
                    <div class="section">
                        <div class="label">
                            Property Name:
                        </div>
    
                        <div class="field">
                            <input type="text" name="propertyName" required="required" value="<?php echo $row['title'] ?>" placeholder="Enter Property Name">
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Property Location:
                        </div>
    
                        <div class="field">
                            <input type="text" name="propertyLocation" required="required" value="<?php echo $row['location'] ?>" placeholder="Enter Property Location">
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Property Description:
                        </div>
                        <div class="field" >
                            <textarea required="required" name="propertyDescription" rows = "6"><?php echo $row['description'] ?></textarea>
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Rate Per Night (MYR):
                        </div>
    
                        <div class="field">
                            <input type="number" name="propertyRate" required="required" value="<?php echo $row['rate'] ?>" placeholder="Enter Property Rate/Night">
                        </div>
                    </div>

                    <div class="section">
                        <div class="label">
                            Property Capacity: 
                        </div>
    
                        <div class="field">
                            <input type="number" name="propertyCapacity" required="required" value="<?php echo $row['guest'] ?>" placeholder="Enter Capacity">
                        </div>
                    </div>
                
                    <div class="section">
                        <div class="label">
                            Photos: 
                        </div>
    
                        <div class="propertyIMG">
                            <div class= "propertyIMGlabel">
                                <?php 
                                    
                                    $sql_photo = "SELECT * FROM addphotos a INNER JOIN listings l on a.listingID = l.listingID WHERE l.listingID = $id";

                                    $result_photo = $mysqli -> query($sql_photo);
                        
                                    $row_cnt_photo = $result_photo -> num_rows;
                        
                                    if($row_cnt_photo >0){
                                        while($row_photo = $result_photo -> fetch_assoc()){
                                            $photos = 'data:image/jpg;base64,'.base64_encode($row_photo['photo']);
                                            echo    '<div class="myImages fade">
                        
                                                    <img src="'.$photos.'" id="B_image" style="vertical-align: middle;min-width: 70vw;height: 500px;" class="center">
                            
                                                    </div>';
                                        }
                                    }
                                    else{
                                        echo    'There are no photos available just yet!';
                                    }

                                    echo   '<a class="prev" onclick="nextImage(-1)">&#10094;</a>
                                            <a class="next" onclick="nextImage(1)">&#10095;</a>
                                            </div>
                                            <br>';
                                    
                                    echo   '<div style="text-align:center">';
                                ?>
                            </div>
                            
                            <br>
                            <div class = "propertyIMGfield">
                                <label>Add New Photos:</label>
                                <input type = file id = "newPropertyImg" name = "newPropertyImg[]" multiple>
                                <br><br>
                                
                                <label>Remove All Existing Photos:</label>
                                <input type = "radio" name = "removePhoto" value = "Yes" required="required">Yes
                                <input type = "radio" name = "removePhoto" value = "No" required="required">No
                            </div>
                        </div>
                    </div>
                    

                

                    <div class="section">
                        <div class="label"> <br>
                            Define New Property Tags: 
                        </div>
    
                        <div class="field">
                        <br>
                            <input type="checkbox" name= "propertyTag[]" value="1">Parking Available<br>
                            <input type="checkbox" name= "propertyTag[]" value="2">Pets Allowed<br>
                            <input type="checkbox" name= "propertyTag[]" value="3">Swimming Pool<br>
                            <input type="checkbox" name= "propertyTag[]" value="4">Laundry Facilities<br>
                            <input type="checkbox" name= "propertyTag[]" value="5">Toiletries Provided<br>
                            <input type="checkbox" name= "propertyTag[]" value="6">Gymnasium<br>
                            <input type="checkbox" name= "propertyTag[]" value="7">Balcony<br>
                            <input type="checkbox" name= "propertyTag[]" value="8">Cooking Utensils<br>
                            <input type="checkbox" name= "propertyTag[]" value="9">Landed<br>
                            <input type="checkbox" name= "propertyTag[]" value="10">Shore View<br>
                            <input type="checkbox" name= "propertyTag[]" value="11">Self Check-In<br>
                            <input type="checkbox" name= "propertyTag[]" value="12">Netflix<br>
                        </div>
                    </div>


                    <div class="section">
                        <div class="label">
                            &nbsp;
                        </div>
    
                        <div class="field">
                            <button type="submit" class="btn" name="editPropertyBtn">Edit Property</button>
                            <button type="reset" class="btn">Reset</button>
                        </div>
                    </div>

                <?php 
                    }
                ?>
                </div>
            </form>
            
        </main>

        <?php require_once 'hostFooter.php';?>
        <script src = "script/hostOverlay.js"></script>
</html>