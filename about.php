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
    <title>MAPS | About Us</title>
    <link rel="stylesheet" href="style/about.css">
    <link rel="tab icon" href="images/maps icon.png">
</head>
<body>
    <?php
        // header section and overlays
        require_once 'masterHeader.php';
    ?>

    <main>
        <h1>MAPS: About Us</h1>
        <hr>
        <div id="mainDiv1" class="flex-sb-c">
            <div id="mainDiv1-left" class="flex-sa-c flex-col">
                <h3>Who are We?</h3>
                <p id="loremP">
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
                </p>
            </div>
            <div>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/3lHwUOXMqBY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>            </div>
            </div>
        </div>

        <h3>What we Value</h3>
        <p id="mainDiv2">
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
            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Ut accusantium, temporibus rem odit voluptate cumque aperiam. 
            Voluptatem deserunt porro, cupiditate libero autem numquam minima, 
            ipsum consequatur inventore accusantium praesentium cum! 
            Lorem ipsum dolor sit amet consectetur, 
            adipisicing elit. Deserunt, 
            amet repellat aliquam et fuga eos labore dolores soluta aspernatur, 
            recusandae non minima voluptates id eius. 
            Illo porro dignissimos molestias repudiandae.
        </p>

        <div id="mainDiv3" class="flex-sa-c">
            <div id="mission" class="flex-sa-c" onclick="missionStat()" onmouseleave="ourMission()"><h3>Our Mission</h3></div>
            <div id="vision" class="flex-sa-c" onclick="visionStat()" onmouseleave="ourVision()"><h3>Our Vision</h3></div>
        </div>
    </main>

    <?php
        // footer section
        include 'masterFooter.php';
    ?>
    
    <script src="script/master.js"></script>
    <script src="script/about.js"></script>
</body>
</html>