<?php
include "connection.php";
include "navbar.php";

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
  
  
     
  <section>
   
      
      <div class="box2">
      
      
     <h1 class="reg-text" > InclusiDance  </h1>
        <br>
      <h1 class="reg-text" >User Registration Form </h1>
      
      <form name="Registration" method="post" action="">
    <br><br>
    <div class="login">
        <input type="text" name="first" placeholder="First Name" required="">
        <br><br>
        <input type="text" name="last" placeholder="Last Name" required="">
        <br><br>
        <input type="text" name="Username" placeholder="Username" required="">
        <br><br>
        <input type="password" name="password" placeholder="Password" required="">
        <br><br>
        <input type="text" name="email" placeholder="Email" required="">
        <br><br>
        Gender:
        <br>
        <input type="radio" name="gender" value="male" id="male" required>
        <label for="male">Male</label>
        <input type="radio" name="gender" value="female" id="female" required>
        <label for="female">Female</label>
        <br><br>
        Address:
        <br>
        <input type="text" name="address" placeholder="Address" required>
        <br><br>
        Class Preference:
        <br>
        <input type="radio" name="class_preference" value="online" id="online" required>
        <label for="online">Online</label>
        <input type="radio" name="class_preference" value="offline" id="offline" required>
        <label for="offline">Offline</label>
        <br><br>
        Do you have any medical conditions or other information to share?
        <br><br>
        <input type="text" name="medical_info" placeholder="Enter any medical conditions or other information">
        <br><br>
        Dance Style:
        <br><br>
        <select name="dance_style" required>
            <option value="salsa">Salsa</option>
            <option value="chair_tap">Chair Tap</option>
            <option value="hip_hop">Hip Hop</option>
            <option value="contemporary_ballet">Contemporary Ballet</option>
            <option value="bollywood">Bollywood</option> 
        </select>
        <br><br>

          
        <button type="submit" name="submit">Sign up</button>

      </form>
      
      
      
    

    </div>
  </div>
  </div>

  </section>
  <?php
  if (isset($_POST['submit']))
   {
   
    $first = isset($_POST['first']) ? $_POST['first'] : "";
    $last = isset($_POST['last']) ? $_POST['last'] : "";
    $Username = isset($_POST['Username']) ? $_POST['Username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
    $address = isset($_POST['address']) ? $_POST['address'] : "";
    $class_preference = isset($_POST['class_preference']) ? $_POST['class_preference'] : "";
    $medical_info = isset($_POST['medical_info']) ? $_POST['medical_info'] : "";
    $dance_style = isset($_POST['dance_style']) ? $_POST['dance_style'] : "";
    $count=0;
    $sql="SELECT Username from `USER STUDENT`";
    $res=mysqli_query($db,$sql);
    while($row=mysqli_fetch_assoc($res))
    {
      if($row['Username']==$_POST['Username'])
    {
      $count=$count+1;
    }   
   }
   if($count==0)
        {
          $sql = "INSERT INTO `USER STUDENT` (first, last, Username, password, email, gender, address, class_preference, medical_info, dance_style)
         VALUES ('$first', '$last', '$Username', '$password', '$email', '$gender', '$address', '$class_preference', '$medical_info', '$dance_style')";
         
  
    if (mysqli_query($db, $sql)) {
      echo "Registration successful!"; 
    } else {
      echo "Error: " . mysqli_error($db);
    }
  
    mysqli_close($db);
  
?>
<script type="text/javascript">
  alert("Registration successful");
  window.location.href='registration.php';

  </script>
  <?php
       
  }

  else
  {
    ?>
<script type="text/javascript">
  alert("The username already exist");
  </script>
  <?php

  }

}


  ?>



</body>











  