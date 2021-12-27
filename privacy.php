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
    <title>MAPS | Privacy Policy</title>
    <link rel="stylesheet" href="style/privacy.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'masterHeader.php';
    ?>

    <main>
        <h1>Privacy Policy at MAPS</h1>
        <hr>
        <div id="mainDiv1" class="flex-sb-c">
            <h3>Privacy Policy</h3>
            <p>
                <script>
                    const today = new Date();
                    document.write('Updated on ' + today.toString().slice(0, 15));
                </script>
            </p>
        </div>
        
        <?php
            for ($i = 0; $i < 3; $i++) {
                echo "<p class=\"divP\">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Amet risus nullam eget felis eget nunc lobortis mattis aliquam. 
                Volutpat consequat mauris nunc congue nisi vitae suscipit. 
                Habitasse platea dictumst vestibulum rhoncus est. 
                Odio eu feugiat pretium nibh ipsum consequat nisl vel. 
                Amet venenatis urna cursus eget nunc scelerisque viverra mauris in. 
                Scelerisque varius morbi enim nunc faucibus. 
                Aliquam malesuada bibendum arcu vitae elementum curabitur vitae. 
                Vel turpis nunc eget lorem. 
                Laoreet non curabitur gravida arcu ac tortor dignissim convallis. 
                Scelerisque mauris pellentesque pulvinar pellentesque habitant morbi tristique. 
                Amet venenatis urna cursus eget. 
                Velit aliquet sagittis id consectetur purus. 
                Fermentum et sollicitudin ac orci.
            </p>";
            }
        ?>
        <br><br>
        <div id="mainDiv2" class="flex-sb-c">
            <h3>Terms of Service</h3>
            <p>
                <script>
                    document.write('Updated on ' + today.toString().slice(0, 15));
                </script>
            </p>
        </div>

        <?php
            for ($i = 0; $i < 3; $i++) {
                echo "<p class=\"divP\">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Amet risus nullam eget felis eget nunc lobortis mattis aliquam. 
                Volutpat consequat mauris nunc congue nisi vitae suscipit. 
                Habitasse platea dictumst vestibulum rhoncus est. 
                Odio eu feugiat pretium nibh ipsum consequat nisl vel. 
                Amet venenatis urna cursus eget nunc scelerisque viverra mauris in. 
                Scelerisque varius morbi enim nunc faucibus. 
                Aliquam malesuada bibendum arcu vitae elementum curabitur vitae. 
                Vel turpis nunc eget lorem. 
                Laoreet non curabitur gravida arcu ac tortor dignissim convallis. 
                Scelerisque mauris pellentesque pulvinar pellentesque habitant morbi tristique. 
                Amet venenatis urna cursus eget. 
                Velit aliquet sagittis id consectetur purus. 
                Fermentum et sollicitudin ac orci.
            </p>";
            }
        ?>
    </main>
    
    <?php
        // footer section
        require_once 'masterFooter.php';
    ?>

    <script src="script/master.js"></script>
</html>