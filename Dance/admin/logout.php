<?php
session_start(); 


if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true)
 {
    
    $_SESSION = array();

    
    session_destroy();
}

header("Location: index.php");

exit();
?>