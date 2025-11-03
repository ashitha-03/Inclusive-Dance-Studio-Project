<?php
include "connection.php";
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>List of Students</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

  <section class="students">
    <div class="box2">
      <h1 class="reg-text">List of Students</h1>
      <table>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Address</th>
          <th>Class Preference</th>
          <th>Medical Information</th>
        </tr>
        <?php
           
      if (isset($_SESSION['user_id'])) {
        $teacher_id = $_SESSION['user_id'];
        
        $all_students_query = "SELECT s.*, u.first AS teacher_first, u.last AS teacher_last
                               FROM `USERS` s
                               LEFT JOIN teacher_student t ON s.user_id = t.student_id
                               LEFT JOIN `USERS` u ON t.teacher_id = u.user_id
                               WHERE s.user_type = 'student' AND t.teacher_id = $teacher_id";
        $all_students_result = mysqli_query($db, $all_students_query);

        while ($student = mysqli_fetch_assoc($all_students_result)) {
          echo "<tr>";
          echo "<td>" . $student['first'] . "</td>";
          echo "<td>" . $student['last'] . "</td>";
          echo "<td>" . $student['Username'] . "</td>";
          echo "<td>" . $student['email'] . "</td>";
          echo "<td>" . $student['gender'] . "</td>";
          echo "<td>" . $student['address'] . "</td>";
          echo "<td>" . $student['class_preference'] . "</td>";
          echo "<td>" . $student['medical_info'] . "</td>";
          echo "</tr>";
        }
      }
        ?>
      </table>
    </div>
  </section>
</body>
</html>
