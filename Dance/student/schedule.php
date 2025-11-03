<?php
include "connection.php";
include "navbar.php";

if (isset($_SESSION['user_id'])) {
    $teacher_id = $_SESSION['user_id'];

    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $dance_form = $_POST['dance_form_id'];
        $class_day = $_POST['class_day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $danceFormQuery = "SELECT id FROM dance_styles WHERE dance_form = '$dance_form'";
        $danceFormResult = mysqli_query($db, $danceFormQuery);
        $row = mysqli_fetch_assoc($danceFormResult);
        $dance_form_id = $row['id'];

        $query = "UPDATE dance_class_timings SET dance_form_id='$dance_form_id', class_day='$class_day', start_time='$start_time', end_time='$end_time' WHERE id=$id";
        $result = mysqli_query($db, $query);

        if (!$result) {
            echo "Error updating record: " . mysqli_error($db);
        }
    }

    if (isset($_POST['add'])) {
        $dance_form = $_POST['dance_form_id'];
        $class_day = $_POST['class_day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $danceFormQuery = "SELECT id FROM dance_styles WHERE dance_form = '$dance_form'";
        $danceFormResult = mysqli_query($db, $danceFormQuery);
        $row = mysqli_fetch_assoc($danceFormResult);
        $dance_form_id = $row['id'];

        $query = "INSERT INTO dance_class_timings (dance_form_id, class_day, start_time, end_time) VALUES ('$dance_form_id', '$class_day', '$start_time', '$end_time')";
        $result = mysqli_query($db, $query);

        if ($result) {
            $timing_id = mysqli_insert_id($db);

            $teacherScheduleQuery = "INSERT INTO teacher_schedule (teacher_id, timing_id) VALUES ('$teacher_id', '$timing_id')";
            $teacherScheduleResult = mysqli_query($db, $teacherScheduleQuery);

            if (!$teacherScheduleResult) {
                echo "Error assigning schedule to teacher: " . mysqli_error($db);
            }
        } else {
            echo "Error adding record: " . mysqli_error($db);
        }

        header("Location: schedule.php");
        exit;
    }

    if (isset($_POST['delete'])) {
        $id_to_delete = $_POST['id_to_delete'];
        $query = "DELETE FROM dance_class_timings WHERE id = $id_to_delete";
        $result = mysqli_query($db, $query);

        if (!$result) {
            echo "Error deleting record: " . mysqli_error($db);
        }

        header("Location: schedule.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dance Class Timings</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <section class="teacher-schedule">
        <div class="box2">
            <h1 class="reg-text">Dance Class Timings</h1>
            <table border="1">
                <tr>
                    <th>Dance Type</th>
                    <th>Class Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                <?php
                $query = "SELECT dc.id, ds.dance_form, dc.class_day, dc.start_time, dc.end_time , dc.dance_form_id
                          FROM dance_class_timings dc
                          JOIN dance_styles ds ON dc.dance_form_id = ds.id
                          WHERE dc.dance_form_id IN (SELECT dance_form_id FROM teacher_dance_forms WHERE teacher_id = $teacher_id)";
                $result = mysqli_query($db, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";

                    echo "<td><select name='dance_form_id'>";
                    $danceFormQuery = "SELECT id, dance_form FROM dance_styles";
                    $danceFormQuery .= " WHERE id IN (SELECT dance_form_id FROM teacher_dance_forms WHERE teacher_id = $teacher_id)";
                    $danceFormResult = mysqli_query($db, $danceFormQuery);
                    while ($danceFormRow = mysqli_fetch_assoc($danceFormResult)) {

                        $selected = ($danceFormRow['id'] === $row['dance_form_id']) ? 'selected' : '';
                        echo "<option value='" . $danceFormRow['dance_form'] . "' $selected>" . $danceFormRow['dance_form'] . "</option>";
                    }
                    echo "</select></td>";

                    echo "<td>";
                    echo "<select name='class_day'>";
                    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    foreach ($daysOfWeek as $day) {
                        $selected = ($day === $row['class_day']) ? 'selected' : '';
                        echo "<option value='$day' $selected>$day</option>";
                    }
                    echo "</select>";
                    echo "</td>";

                    echo "<td><input type='time' name='start_time' value='" . $row['start_time'] . "'></td>";
                    echo "<td><input type='time' name='end_time' value='" . $row['end_time'] . "'></td>";
                    echo "<td><button type='submit' name='submit'>Update</button></td>";
                    echo "</form>";

                    echo "<form method='post'>";
                    echo "<input type='hidden' name='id_to_delete' value='" . $row['id'] . "'>";
                    echo "<td><button type='submit' name='delete'>Delete</button></td>";
                    echo "</form>";

                    echo "</tr>";
                }
                ?>
            </table>
            <div class="add-schedule">
                <form method="post">
                    <tr>
                        <td>
                            <select name='dance_form_id'>
                                <?php
                                $danceFormQuery = "SELECT id, dance_form FROM dance_styles";
                                $danceFormQuery .= " WHERE id IN (SELECT dance_form_id FROM teacher_dance_forms WHERE teacher_id = $teacher_id)";
                                $danceFormResult = mysqli_query($db, $danceFormQuery);
                                while ($danceFormRow = mysqli_fetch_assoc($danceFormResult)) {
                                    echo "<option value='" . $danceFormRow['dance_form'] . "'>" . $danceFormRow['dance_form'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name='class_day'>
                                <?php
                                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                foreach ($daysOfWeek as $day) {
                                    echo "<option value='$day'>$day</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type='time' name='start_time'></td>
                        <td><input type='time' name='end_time'></td>
                        <td><button type='submit' name='add'>Add</button></td>
                    </tr>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
