<?php

$db = mysqli_connect("localhost", "root", "", "dance studio");
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

?>
