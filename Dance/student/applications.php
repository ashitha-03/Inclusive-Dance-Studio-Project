<?php
include "connection.php";
include "navbar.php";

if (isset($_POST['assign_student_teacher'])) {
    $teacherId = $_POST['teacher_id'];
    $studentId = $_POST['student_id'];

    $checkAssignmentQuery = "SELECT * FROM teacher_student WHERE student_id = '$studentId'";
    $checkAssignmentResult = mysqli_query($db, $checkAssignmentQuery);

    if (mysqli_num_rows($checkAssignmentResult) > 0) {
        $updateAssignmentQuery = "UPDATE teacher_student SET teacher_id = '$teacherId' WHERE student_id = '$studentId'";
        $updateAssignmentResult = mysqli_query($db, $updateAssignmentQuery);

        if ($updateAssignmentResult) {
            echo '<script type="text/javascript">alert("Teacher is assigned successfully.");</script>';
        } else {
            echo "Error: Teacher assignment update failed. Please try again.";
        }
    } else {
        $insertAssignmentQuery = "INSERT INTO teacher_student (student_id, teacher_id) VALUES ('$studentId', '$teacherId')";
        $insertAssignmentResult = mysqli_query($db, $insertAssignmentQuery);

        if ($insertAssignmentResult) {
            echo '<script type="text/javascript">alert("Teacher is assigned successfully.");</script>';
        } else {
            echo "Error: Teacher assignment failed. Please try again.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Assign Students</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

  <section>
    <div class="box2">
      <h1 class="reg-text">List of Registered Students</h1>
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
          <th>Dance Styles</th>
        </tr>
        <?php

        $students_query = "SELECT u.*, ts.teacher_id as assigned_teacher, t.first as teacher_first, t.last as teacher_last,
                           GROUP_CONCAT(d.dance_form SEPARATOR ', ') AS dance_styles
                           FROM `USERS` u
                           LEFT JOIN student_dance_forms s ON u.user_id = s.student_id
                           LEFT JOIN dance_styles d ON s.dance_form_id = d.id
                           LEFT JOIN teacher_student ts ON u.user_id = ts.student_id
                           LEFT JOIN USERS t ON ts.teacher_id = t.user_id
                           WHERE u.user_type = 0
                           GROUP BY u.user_id";

        $students_result = mysqli_query($db, $students_query);

        while ($student = mysqli_fetch_assoc($students_result)) {
            echo "<tr>";
            echo "<td>" . $student['first'] . "</td>";
            echo "<td>" . $student['last'] . "</td>";
            echo "<td>" . $student['Username'] . "</td>";
            echo "<td>" . $student['email'] . "</td>";
            echo "<td>" . $student['gender'] . "</td>";
            echo "<td>" . $student['address'] . "</td>";
            echo "<td>" . $student['class_preference'] . "</td>";
            echo "<td>" . $student['medical_info'] . "</td>";
            echo "<td>";

            
            $danceStyles = explode(', ', $student['dance_styles']);
            foreach ($danceStyles as $danceStyle) {
                echo "<h3>$danceStyle</h3>";

                
                echo "<form method='post' action=''>
                      <select name='teacher_id'>
                        <option value=''>Select a Teacher</option>";

                $teachersQuery = "SELECT t.teacher_id, u.first, u.last 
                                  FROM teacher_dance_forms t
                                  JOIN dance_styles d ON t.dance_form_id = d.id
                                  JOIN USERS u ON t.teacher_id = u.user_id
                                  WHERE d.dance_form = '$danceStyle'";

                $teachersResult = mysqli_query($db, $teachersQuery);

                while ($teacher = mysqli_fetch_assoc($teachersResult)) {
                    $selected = ($teacher['teacher_id'] == $student['assigned_teacher']) ? 'selected' : '';
                    echo "<option value='" . $teacher['teacher_id'] . "' $selected>" . $teacher['first'] . " " . $teacher['last'] . "</option>";
                }

                echo "</select>
                      <input type='hidden' name='student_id' value='" . $student['user_id'] . "'>
                      <button type='submit' name='assign_student_teacher'>Assign Teacher</button>
                      </form>";
            }

            echo "</td>";
            echo "</tr>";
        }
        ?>
      </table>
    </div>
  </section>
</body>
</html>
