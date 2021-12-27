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
    <title>MAPS | F.A.Q.</title>
    <link rel="stylesheet" href="style/faq.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'masterHeader.php';
    ?>

    <main>
        <h1>MAPS: Frequently Asked Questions</h1>
        <hr>
        <p>Here are some frequently asked one. None of them attend to yours? Click <a href="contact.php" target="_blank">HERE</a> to reach MAPS, coffee on us!</p>
        <div id="faq" class="flex-sa-c flex-col">
            <?php
                $questionList = [
                    'What is MAPS?',
                    'How MAPS works?',
                    'What is a premium host?',
                    'What should I pay attention to?',
                    'How can I make a booking?',
                    'How to cancel my booking?',
                    'When you\'ll pay for your booking.',
                    'Do MAPS charges any fees or deposits?',
                    'Is there an option to contact my host?',
                    'I want to be a host.'];

                for ($i = 0; $i < 10; $i++) {
                    echo "<div><button type=\"button\" class=\"question\" onclick=\"active($i)\">";
                    echo $questionList[$i] . "</button><div class=\"answer\"><p>";
                    echo 'Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                            Repellat illum quas nemo, fugiat neque perspiciatis saepe aut pariatur 
                            aliquid officiis officia debitis voluptatibus qui quidem doloremque 
                            ad itaque atque adipisci. Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                            Nihil dicta blanditiis, amet ipsam consequuntur vitae tempore architecto. 
                            Earum eius iure atque esse obcaecati in.';
                    echo '</p></div></div>';
                }
            ?>
        </div>
        
    </main>

    <?php
        // footer section
        require_once 'masterFooter.php';
    ?>
    
    <script src="script/master.js"></script>
    <script src="script/faq.js"></script>
</body>
</html>