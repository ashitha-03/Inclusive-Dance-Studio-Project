<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InclusiDance Hub</title>
</head>
<body>
<header>
    <div class="logo">
      <img src="images/yes.jpg" alt="Logo Image">
      <h1 style="color: aliceblue" class="subHeading">InclusiDance Hub</h1>
    </div>
      
    <nav>
      <ul>
        <li><a href="index.php">HOME</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <li><a href="styles.php">STYLES</a></li>

        <?php
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
          if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
            echo '<li><a href="applications.php">APPLICATIONS</a></li>';
            echo '<li><a href="admin_schedule.php">SCHEDULE</a></li>';
            

          }
          

          if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2) {
            echo '<li><a href="students.php">STUDENTS</a></li>';
            echo '<li><a href="schedule.php">SCHEDULE</a></li>';
          }

          if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 0) {
            echo '<li><a href="student_schedule.php">SCHEDULE </a></li>';
            
          }

          echo '<li><a href="logout.php">LOGOUT</a></li>';
        } else {
          echo '<li><a href="login.php">LOGIN</a></li>';
        }
        ?>

        
      </ul>
    </nav>
  </header>
</body>
</html>

          