<?php
if (session_status() == PHP_SESSION_NONE)
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> </title>
</head>
<body>
<header>
    <div class="logo">
        
      <img src="images/yes.jpg">
      <h1 style="color:aliceblue" class="subHeading">InclusiDance Hub</h1>
    </div>
      
      <nav>
        <ul>
          <li><a href="index.php">HOME</a></li>
          <li><a href="about.php">ABOUT</a></li>
          <li><a href=""> STYLES</a></li>
          <?php 
          if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) 
          { ?>
          <li><a href="schedule.php">SCHEDULE</a></li>
          <li><a href="scholarship.php">SCHOLARSHIP</a></li>
          <li><a href="logout.php">LOGOUT</a></li>
         <?php 
         } 
         ?>
          <li><a href="">CONTACT</a></li>
          <?php 
          if (!isset($_SESSION['user_logged_in']))
           { 
          ?>
          <li><a href="admin_login.php">LOGIN</a></li>
        <?php 
         } 
       ?>
       </ul>
      </nav>
     </header>
  
</body>
</html>