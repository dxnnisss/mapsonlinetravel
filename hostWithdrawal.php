<?php 
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'host') {
        header('location: index.php');
    }
    include("connect.php");
    $accID = $_SESSION['accID'];
    $hostID = $_SESSION['hostID'];
    $result = $mysqli->query("SELECT * FROM hosts where accID LIKE '%$accID%'");
    $row = $result->fetch_assoc();
    $walletBal = $row['walletBalance'];
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MAPS | WALLET WITHDRAWAL</title>
        <link rel="stylesheet" href="style/host.css?">
        <link rel="tab icon" href = "images/maps icon.png">
        
        <script>
            function changeForm(formType) {
            let selectedValue = formType.options[formType.selectedIndex].value;
            let subForm = document.getElementsByClassName('bankOption')
            for (let i = 0; i < subForm.length; i += 1) {
                if (selectedValue === subForm[i].name) {
                subForm[i].setAttribute('style', 'display:block')
                } else {
                subForm[i].setAttribute('style', 'display:none') 
                }
            }
        }
        </script> 
    </head>

    <body>
        <?php require_once 'hostHeader.php';?>

        <main>
        <div class = 'host_property'>
                <section id="greetings">Wallet Withdrawal</section>
                
        </div>
            <div class="wallet_form">
                <br>
                Please select an option: &nbsp; 
                <select onchange="changeForm(this)">
                    <option value="" selected="selected">&nbsp;&nbsp;&nbsp; Select One:</option>
                    <option value="form_1">Registered Bank</option>
                    <option value="form_2">Others</option>
                </select>
                
                <form class="bankOption" name="form_1" id="form_1" style="display:none" method="post">

                    Name on Bank Account: <br>
                    <input type=text name="bankAccName" required="required" value = "<?php echo $row['bankAccName']?>"><br>
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
                    
                        
                    Bank Account Number: <br>
                    <input type=number name="bankAccNum" required="required" value = "<?php echo $row['bankAccNo']?>"> <br>
                    Amount to Withdraw<br>
                    <input type=number name="withdrawAmount" required="required" value = "<?php echo $walletBal?>" min = "0" max = "<?php echo $walletBal?>"> 
                    <br>
                    
                    <button type="submit" name ="registeredSubmit">Submit</button>
                    <button type="reset">Reset</button>
                    
                </form>
                
                <form class="bankOption" name="form_2" id="form_2" style="display:none" method="post">
                <br>Please select a Bank: &nbsp; 
                    <select>
                        <option value="" selected="selected">&nbsp; &nbsp; Select Bank: </option>
                        <option value="Maybank">Maybank</option>
                        <option value="Hong Leong Bank">Hong Leong Bank</option>
                        <option value="Public Bank">Public Bank</option>
                    </select>
                    <br>
                    <br>
                    Name on Bank Account: <br>
                    <input type=text name="bankAccName" required="required"><br>
                    Bank Account Number: <br>
                    <input type=number name="bankName" required="required"><br>
                    Amount to Withdraw: <br>
                    <input type=number name="withdrawAmountO" required="required" value = "<?php echo $row['walletBalance']?>"><br>

                    <br><button type="submit" name = "otherSubmit">Submit</button>
                    <button type="reset">Reset</button>
                    
                   
                </form>
                
            </div>
            <?php
                if (isset($_POST['registeredSubmit'])) {
                    $withdrawAmount = $_POST['withdrawAmount'];
                    
                    $sqlOut = "UPDATE hosts SET walletBalance = (walletBalance - $withdrawAmount) WHERE hostID = $hostID";
                    $outStmt = $mysqli->prepare($sqlOut);
                    $outStmt ->execute();
                    echo "<script>alert('Withdraw Successful');window.location.href='host.php';</script>";
                }
                else if (isset($_POST['otherSubmit'])) {
                    $withdrawAmountO = $_POST['withdrawAmountO'];

                    $sqlOut1 = "UPDATE hosts SET walletBalance = (walletBalance - $withdrawAmountO) WHERE hostID = $hostID";
                    $outStmt1 = $mysqli->prepare($sqlOut1);
                    $outStmt1 ->execute();
                    echo "<script>alert('Withdraw Successful');window.location.href='host.php';</script>";
                }
                
            ?>
        </main>
        
        <?php 
            require_once 'hostFooter.php';
        ?>
        <script src = "script/hostOverlay.js"></script>
    </body>
</html>