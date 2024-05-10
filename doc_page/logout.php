<?php
session_start();

// Set a session variable to indicate logout
$_SESSION['logged_out'] = true;

// Unset all of the other session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Redirect to the login page
header("location: ../login.php");
exit;
?>
