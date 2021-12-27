<?php
    session_start();
    if (isset($_SESSION['role']) && $_SESSION['role'] != 'user') {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPS | Contact Us</title>
    <link rel="stylesheet" href="style/contact.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'masterHeader.php';
    ?>

    <main>
        <h1>Contact Us</h1>
        <hr>
        <p>Need help with your bookings? Looking for career opportunities? Drop us a line or visit us!</p>
        <div class="flex-sa-c">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127494.84232014729!2d101.69258923996122!3d3.0372481348799685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1633081121921!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <div id="hqInfo" class="flex-sb-c">
                <h3>Where Are We</h3>
                <div class="flex-sa-c">
                    <div id="telAndEmail" class="flex-sb-c">
                        <div class="flex-sa-c">
                            <img src="images/mail.png" alt="Email" width='25px' height="25px">
                            <a href="mailto:info@maps.com.my">info@maps.com.my</a>
                        </div>
                        <div class="flex-sa-c">
                            <img src="images/telephone.png" alt="Tel" width='25px' height="25px">
                            <a href="tel:+60323008000">+603 2300 8000</a> 
                        </div>
                    </div>
                    <br>
                    <p>Customer Service: 8.00am - 8.00pm, Monday - Saturday</p>
                </div>
                <div>
                    <p id="address">
                        <b>MAPS Inc.</b> <br>
                        Jalan Teknologi 5, Taman Teknologi Malaysia, <br>
                        57000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur
                    </p>
                </div>
            </div>
        </div>

        <form id="contactUs" class="flex-sa-c" action="#" method="POST">
            <h3>Enquiries? Complaints? Here is the place.</h3>

            <div class="flex-sb-c">
                <div class="flex-sb-c">
                    <div>
                        <label for="#name">Your Name</label><br>
                        <input type="text" name="name" placeholder="John Doe" required>
                    </div>
                    <div>
                        <label for="#tel">Contact Number</label><br>
                        <input type="tel" name="contact" placeholder="012 345 6789" required>
                    </div>
                    <div>
                        <label for="#email">Email Address</label><br>
                        <input type="email" name="email" placeholder="johndoe@mail.com" required>
                    </div>
                    <div id="radioForType" class="">
                        <label for="#type">Type of Feedback</label><br>
                        <div class="flex-sb-c">
                            <div >
                                <input type="radio" name="type" id="Assist" value="Assist" required>
                                <label for="Assist">Assist</label>
                            </div>
                            <div>
                                <input type="radio" name="type" id="Complaint" value="Complaint" required>
                                <label for="Complaint">Complaint</label> 
                            </div>
                            <div>
                                <input type="radio" name="type" id="Enquiry" value="Enquiry" required>
                                <label for="Enquiry">Enquiry</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-sb-c">
                    <div>
                        <label for="#subject">Subject</label><br>
                        <input type="text" name="subject" placeholder="My Coffee is Cold" required>
                    </div>
                    <div>
                        <label for="message">Your Message</label><br>
                        <textarea name="message" rows="10" required></textarea>
                    </div>
                    <div id="btnDiv">
                        <input type="submit" class="button btn" name="submit" value="SUBMIT">
                        <input type="reset" class="button btn" name="reset" value="RESET">
                    </div>
                </div>
            </div>
        </form>
    </main>

    <?php
        // footer section
        require_once 'masterFooter.php';

        // mysqli code
        if (isset($_POST['submit'])) {
            require_once 'connect.php';
            $sql = "INSERT INTO contactus (name, contact, email, type, subject, message) 
            VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli -> prepare($sql);
            $name = escaped($_POST['name']);
            // escape spaces and dashes
            $contact = str_replace(' ', '',escaped($_POST['contact']));
            $contact = str_replace('-', '',$contact);
            $email = escaped($_POST['email']);
            $type = escaped($_POST['type']);
            $subject = escaped($_POST['subject']);
            $message = escaped($_POST['message']);
            $stmt -> bind_param('ssssss', $name, $contact, $email, $type, $subject, $message);
            $stmt -> execute();

            if ($mysqli -> affected_rows == 1) {
                $mysqli -> close();
                echo "<script>alert('We have received your feedback. Sit tight and chill!');";
                echo "window.location.href='index.php';</script>";
            }
        }
        
    ?>
    
    <script src="script/master.js"></script>
</body>
</html>