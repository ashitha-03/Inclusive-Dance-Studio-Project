<?php
include "connection.php";
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dance Styles</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        
    </style>
</head>
<body>
<section class="styles">
    <div class="box2">
        <h1 class="reg-text"> Dance Styles </h1>

        <?php
        $danceStyles = array(
            "Salsa" => array(
                "description" => "Salsa is a lively and social dance style that originated in the Caribbean. It is known for its fast footwork and vibrant music. Salsa is an inclusive dance style that can be enjoyed by people of all backgrounds and abilities. Salsa is not only about dancing but also about building a community. Here, the emphasis is on creating a diverse and supportive Salsa community where everyone feels welcome.",
                "video" => "https://www.youtube.com/embed/PVlKqqpVUy0"
            ),
            "Chair Tap" => array(
                "description" => "Chair Tap is a unique dance style that combines tap dance with movements involving a chair. It's a creative and fun form of dance. Instructors may provide individualized instruction to adapt chair-based movements to each dancer's abilities and needs. We celebrate the diversity of its dancers and encourage creative expression through Chair Tap, ensuring that everyone's unique abilities are recognized and valued.",
                "video" => "https://www.youtube.com/embed/A9WUp7JAOtA"
            ),
            "Contemporary Ballet" => array(
                "description" => "Contemporary Ballet is a fusion of classical ballet and contemporary dance. It combines the grace of ballet with modern movements. The studio promotes body positivity and encourages dancers to embrace their unique qualities, which is an important aspect of contemporary dance. Contemporary Ballet classes promote diversity and acceptance. Dancers of different backgrounds and experiences are encouraged to express themselves through the fusion of classical and modern dance.",
                "video" => "https://www.youtube.com/embed/YDJTtw6HpEY"
            ),
            "Bollywood" => array(
                "description" => "Bollywood dance is a popular style in Indian cinema. It's characterized by energetic and expressive movements set to Bollywood music. Instructors create accessible routines that cater to dancers of different abilities, ensuring that everyone can participate in the fun and energetic world of Bollywood dance. Bollywood music has a universal appeal, and inclusive studios use it to connect people from various backgrounds and foster a sense of unity and inclusion.",
                "video" => "https://www.youtube.com/embed/u7kawXUyrB8"
            )
        );

        foreach ($danceStyles as $style => $info) {
            echo "<div class='dance-style'>";
            echo "<h2>$style</h2>";
            echo "<iframe width='560' height='315' src='{$info["video"]}' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
            echo "<p>{$info["description"]}</p>";
            echo "</div>";
        }
        ?>
    </div>
</section>
</body>
</html>
