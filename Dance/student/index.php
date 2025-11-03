
<?php
include "navbar.php";
if (session_status() == PHP_SESSION_NONE){
  session_start();
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>
    Inclusive Dance Studio

  </title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

</head>
<style type="text/css">

</style>
<body>
  <div class="wrapper">
      
      <section>
        <div class="sec_img">
        <br><br>
        <div class="box">
          <?php
          if(isset($_SESSION['user_name']))
          {
            
            echo "<h1>Hello ".$_SESSION['user_name']."!</h1>";
          }
          ?>


          <h1  style="font-style:italic ;" >"Step In, Dance Out-For All"</h1>
          <h1  style="font-style:oblique ; font-size:40px" > InclusiDance Hub </h1>
        </div>
      </div>

      </section>
      
  </div>
  <?php 
  include "footer.php";
  ?>
</body>
</html>