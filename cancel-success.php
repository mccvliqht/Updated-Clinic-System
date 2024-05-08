<?php
session_start();
include 'config.php'; // Include your database configuration file

// Check if the cancellation appointment ID is set in the session
if (!isset($_SESSION['cancellation_appointment_id'])) {
    // Redirect to the cancel page if cancellation appointment ID is not set
    header("Location: cancel.html");
    exit();
}

// Retrieve the cancellation appointment ID from the session
$cancellation_appointment_id = $_SESSION['cancellation_appointment_id'];

// Retrieve the patient ID associated with the cancellation appointment
$get_patient_id_query = "SELECT ptn_id FROM tblappoint WHERE apt_id = ?";
$get_patient_id_stmt = $conn->prepare($get_patient_id_query);
$get_patient_id_stmt->bind_param("i", $cancellation_appointment_id);
$get_patient_id_stmt->execute();
$get_patient_id_result = $get_patient_id_stmt->get_result();

if ($get_patient_id_result->num_rows > 0) {
    $patient_id_row = $get_patient_id_result->fetch_assoc();
    $patient_id = $patient_id_row['ptn_id'];

    // Delete appointment from tblappoint
    $delete_appointment_query = "DELETE FROM tblappoint WHERE apt_id = ?";
    $delete_appointment_stmt = $conn->prepare($delete_appointment_query);
    $delete_appointment_stmt->bind_param("i", $cancellation_appointment_id);
    $delete_appointment_result = $delete_appointment_stmt->execute();

    // Delete patient from tblpatient
    $delete_patient_query = "DELETE FROM tblpatient WHERE ptn_id = ?";
    $delete_patient_stmt = $conn->prepare($delete_patient_query);
    $delete_patient_stmt->bind_param("i", $patient_id);
    $delete_patient_result = $delete_patient_stmt->execute();

    // Check if both deletions were successful
    if ($delete_appointment_result && $delete_patient_result) {
        // Display confirmation message
        echo "Appointment cancelled successfully.";
    } else {
        // Display error message
        echo "Error cancelling appointment. Please try again later.";
    }

    // Close prepared statements
    $delete_appointment_stmt->close();
    $delete_patient_stmt->close();
} else {
    // Appointment not found
    $error_message = "Error: Appointment not found.";
}

// Close prepared statements
$get_patient_id_stmt->close();