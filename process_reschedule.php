<?php
session_start();
include 'config.php'; // Include your database configuration file

// Retrieve the appointment ID from the session
$appointment_id = $_SESSION['appointment_details']['appointment_id'];

// Retrieve the form data for rescheduling
$service_id = $_POST['service'];
$date = $_POST['date'];
$doctor_id = $_POST['doctor'];
$time = $_POST['time'];

// Update the appointment details in the database
$update_query = "UPDATE tblappoint SET doc_id = ?, serv_id = ?, apt_date = ?, apt_time = ? WHERE apt_id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("iissi", $doctor_id, $service_id, $date, $time, $appointment_id);
$update_result = $update_stmt->execute();

if ($update_result) {
    // Appointment details updated successfully, redirect to confirmation page
    header("Location: reschedule-success.php");
    exit();
} else {
    // Error updating appointment details, handle the error (e.g., display an error message)
    echo "Error updating appointment details.";
}
