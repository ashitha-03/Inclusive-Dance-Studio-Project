<?php
include "connection.php";
include "navbar.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted

    // Retrieve values from the form and cast to integers
    $danceStyleId = (int)$_POST['dance_class_id'];
    $teacherId = (int)$_POST['teacher_id'];

    // You may want to add further validation and error handling here

    // Insert into teacher_schedule table
    $insertQuery = "INSERT INTO teacher_schedule (teacher_id, timing_id) 
                    VALUES ('$teacherId', '$danceStyleId')";

    $result = mysqli_query($db, $insertQuery);

    if ($result) {
        header("Location: admin_schedule.php"); // Redirect back to the schedule page
        exit();
    } else {
        echo "Error assigning teacher: " . mysqli_error($db);
    }
}

// Retrieve all schedules grouped by dance form
$query = "SELECT ds.id AS dance_style_id, ds.dance_form, dc.id AS dance_class_id, dc.class_day, dc.start_time, dc.end_time
          FROM dance_class_timings dc
          JOIN dance_styles ds ON dc.dance_form_id = ds.id
          ORDER BY ds.dance_form, dc.class_day";

$result = mysqli_query($db, $query);

if (!$result) {
    echo "Error fetching schedules: " . mysqli_error($db);
}

// Retrieve the list of teachers for each dance style
$teacherQuery = "SELECT u.user_id AS teacher_id, u.first, u.last, ds.dance_form
                 FROM users u
                 JOIN teacher_dance_forms td ON u.user_id = td.teacher_id
                 JOIN dance_styles ds ON td.dance_form_id = ds.id";
$teacherResult = mysqli_query($db, $teacherQuery);

if (!$teacherResult) {
    echo "Error fetching teachers: " . mysqli_error($db);
}

// Retrieve the assigned teacher for each dance style
$assignedTeachers = array();
$assignedQuery = "SELECT teacher_id, timing_id FROM teacher_schedule";
$assignedResult = mysqli_query($db, $assignedQuery);

if ($assignedResult) {
    while ($row = mysqli_fetch_assoc($assignedResult)) {
        $assignedTeachers[$row['timing_id']] = $row['teacher_id'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dance Class Schedules</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <section class="admin-schedule">
        <div class="box2">
            <h1 class="reg-text">Admin Dance Class Schedules</h1>
            <table border="1">
                <tr>
                    <th>Dance Form</th>
                    <th>Class Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Assign Teacher</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['dance_form'] . "</td>";
                    echo "<td>" . $row['class_day'] . "</td>";
                    echo "<td>" . $row['start_time'] . "</td>";
                    echo "<td>" . $row['end_time'] . "</td>";
                    echo "<td>";
                    echo "<form method='post' action='admin_schedule.php'>";
                    echo "<input type='hidden' name='dance_class_id' value='" . $row['dance_class_id'] . "'>";
                    echo "<select name='teacher_id'>";
                    echo "<option value='' selected>Select a Teacher</option>"; // Default option
                    mysqli_data_seek($teacherResult, 0); // Reset the pointer to the beginning
                    while ($teacherRow = mysqli_fetch_assoc($teacherResult)) {
                        if ($teacherRow['dance_form'] == $row['dance_form']) {
                            $selected = isset($assignedTeachers[$row['dance_class_id']]) && $assignedTeachers[$row['dance_class_id']] == $teacherRow['teacher_id'] ? "selected" : "";
                            echo "<option value='" . $teacherRow['teacher_id'] . "' $selected>" . $teacherRow['first'] . " " . $teacherRow['last'] . "</option>";
                        }
                    }
                    echo "</select>";
                    echo "<input type='submit' value='Assign'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <!-- Display the list of unassigned teachers -->
        <div class="box2">
            <h2 class="reg-text">Unassigned Teachers</h2>
            <table border="1">
                <tr>
                    <th>Teacher ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Dance Form</th>
                </tr>
                <?php
                mysqli_data_seek($teacherResult, 0); // Reset the pointer to the beginning
                while ($teacherRow = mysqli_fetch_assoc($teacherResult)) {
                    $teacherId = $teacherRow['teacher_id'];
                    if (!in_array($teacherId, $assignedTeachers)) {
                        echo "<tr>";
                        echo "<td>" . $teacherId . "</td>";
                        echo "<td>" . $teacherRow['first'] . "</td>";
                        echo "<td>" . $teacherRow['last'] . "</td>";
                        echo "<td>" . $teacherRow['dance_form'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
    </section>
</body>

</html>
