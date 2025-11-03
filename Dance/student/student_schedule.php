<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>

  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>



<?php

include "navbar.php";
include "connection.php";


if (isset($_SESSION['user_id'])) {
  $studentId = $_SESSION['user_id'];

  
  $getAssignedTeacherQuery = "SELECT u.* 
                              FROM `USERS` u
                              INNER JOIN teacher_student ts ON u.user_id = ts.teacher_id
                              WHERE ts.student_id = '$studentId'";

  $getAssignedTeacherResult = mysqli_query($db, $getAssignedTeacherQuery);

  
  echo '<section class="main-container">';
  echo '<div class="box2">';
  echo '<h1 class="title">Student Dashboard</h1>';

  if ($getAssignedTeacherResult && mysqli_num_rows($getAssignedTeacherResult) > 0) {
    $assignedTeacher = mysqli_fetch_assoc($getAssignedTeacherResult);

    echo "<h3 class='section-title'>Assigned Teacher</h3>";
    echo "<p class='content'>Name: " . $assignedTeacher['first'] . " " . $assignedTeacher['last'] . "<br>";
    echo "Username: " . $assignedTeacher['Username'] . "<br>";
    echo "Email: " . $assignedTeacher['email'] . "</p>";
  } else {
    echo "<p class='content'>You don't have an assigned teacher at the moment.</p>";
  }

  
  $getDanceFormIdsQuery = "SELECT dance_form_id FROM student_dance_forms WHERE student_id = '$studentId'";
  $danceFormIdsResult = mysqli_query($db, $getDanceFormIdsQuery);

  if ($danceFormIdsResult) {
    while ($row = mysqli_fetch_assoc($danceFormIdsResult)) {
      $danceFormId = $row['dance_form_id'];

      
      $getDanceFormNameQuery = "SELECT dance_form FROM dance_styles WHERE id = '$danceFormId'";
      $danceFormNameResult = mysqli_query($db, $getDanceFormNameQuery);
      $danceFormNameRow = mysqli_fetch_assoc($danceFormNameResult);
      $danceFormName = $danceFormNameRow['dance_form'];

      
      $getTimingsQuery = "SELECT class_day, start_time, end_time FROM dance_class_timings WHERE dance_form_id = '$danceFormId'";
      $timingsResult = mysqli_query($db, $getTimingsQuery);

      if ($timingsResult && mysqli_num_rows($timingsResult) > 0) {
        echo "<h2 class='section-title'>Dance Class Timings for $danceFormName</h2>";

        while ($timingRow = mysqli_fetch_assoc($timingsResult)) {
          echo "<p class='content'>Day: " . $timingRow['class_day'] . "<br>";
          echo "Start Time: " . $timingRow['start_time'] . "<br>";
          echo "End Time: " . $timingRow['end_time'] . "</p>";
        }
      } else {
        echo "<p class='content'>No dance class timings available for $danceFormName</p>";
      }
    }
  } else {
    echo "<p class='content'>Error fetching dance form IDs</p>";
  }

  echo '</div>';
  echo '</section>';
} else {
  echo "<p class='content'>Please log in to view your assigned teacher and dance class timings.</p>";
}
?>

</body>
</html>
