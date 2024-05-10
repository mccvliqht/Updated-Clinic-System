<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || isset($_SESSION['logged_out'])) {
    // Redirect to the login page
    header("location: ../login.php");
    exit;
}

include '../config.php';

if(isset($_POST['sched_id'])) {
    $sched_id = $_POST['sched_id'];

    // Delete the schedule from the database
    $delete_sql = "DELETE FROM tblSchedule WHERE sched_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $sched_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    // Redirect back to the schedules page
    header("location: Schedules.php");
    exit;
} else {
    // Redirect back to the schedules page if no sched_id is provided
    header("location: Schedules.php");
    exit;
}
?>
