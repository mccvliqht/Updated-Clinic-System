<?php
session_start();
include 'config.php'; // Include your database configuration file

// Retrieve the appointment ID from the form
$appointment_id = $_POST['appointment_id'];

// Validate the appointment ID in your database
$validate_query = "SELECT tblpatient.ptn_id, tblpatient.ptn_fname, tblpatient.ptn_lname FROM tblpatient INNER JOIN tblappoint ON tblpatient.ptn_id = tblappoint.ptn_id WHERE apt_id = ?";
$validate_stmt = $conn->prepare($validate_query);
$validate_stmt->bind_param("i", $appointment_id);
$validate_stmt->execute();
$validate_result = $validate_stmt->get_result();

// Check if the appointment ID is valid
if ($validate_result->num_rows > 0) {
    // Fetch user details
    $row = $validate_result->fetch_assoc();
    $first_name = $row['ptn_fname'];
    $last_name = $row['ptn_lname'];

    // Store user details in session
    $_SESSION['appointment_details'] = array(
        'appointment_id' => $appointment_id,
        'first_name' => $first_name,
        'last_name' => $last_name
    );

    // Redirect to the next page
    header("Location: reschedule.php");
    exit();
} else {
    // Invalid appointment ID, handle the error (e.g., display an error message)
    echo "Invalid appointment ID.";
}