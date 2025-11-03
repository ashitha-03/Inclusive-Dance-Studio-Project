<?php
include "connection.php";
include " navbar.php";

if (isset($_POST['assign'])) {
    $studentName = $_POST['studentName'];
    $teacherName = $_POST['teacherName'];

    $sql = "INSERT INTO teacher_student (student_name, teacher_name) VALUES ('$studentName', '$teacherName')";

    if ($conn->query($sql) === TRUE) {
        echo "Teacher assigned successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
  <title>Assign Students</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    
   
  </style>
</head>
<body>
</body>
</html>
