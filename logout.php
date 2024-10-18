<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION['user_id'] = null;
$_SESSION['user_name'] = null;
$_SESSION['user_email'] = null;
$_SESSION['user_type'] = null;

// Alternatively, you can use session_unset() to clear all session variables
// session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit;
?>
