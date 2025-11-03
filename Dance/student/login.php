<?php
include "connection.php";
session_start();
include "navbar.php";

if (isset($_POST['submit'])) {
  $count = 0;
  $username = mysqli_real_escape_string($db, $_POST['Username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  $query = "SELECT * FROM `USERS` WHERE Username = '$username' AND password = '$password'";
  $res = mysqli_query($db, $query);

  $count = mysqli_num_rows($res);

  if ($count == 0) {
    echo '<script type="text/javascript">
    alert("The username and password do not match.");</script>';
  } else {
    $row = mysqli_fetch_assoc($res);
   
    $user_type=$row['user_type'];
    $_SESSION['user_type']= $user_type;
    $_SESSION['user_logged_in'] = true;

    $user_name=$row['Username'];
    $_SESSION['user_name']= $user_name;

    $user_id=$row['user_id'];
    $_SESSION['user_id']= $user_id;
    $dance_style=$row['dance_style'];
    $_SESSION['dance_style']= $dance_style;




    

   echo '<script type="text/javascript">
    window.location = "index.php";</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <section>
    <div class="login-background">
      <br><br>
      <div class="box1">
        <h1 class="reg-text"> InclusiDance Hub </h1>
        <br>
        <h1 class="reg-text">User Login Form </h1>
        <form name="login" method="post" action="">
          <br><br>
          <input type="text" name="Username" placeholder="Username" required="">
          <br><br>
          <input type="password" name="password" placeholder="Password" required="">
          <br><br>
          <button type="submit" name="submit">Login</button>
        </form>
        <p class="para">
          <br>
          <a style="color: black;">Forgot password?</a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
          New to this website? <a style="color: black;" href="registration.php">Sign Up</a>
        </p>
      </div>
    </div>
  </section>
</body>
</html>
