<?php
session_start();
include 'config.php'; // Include your database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if appointment ID is provided
    if (isset($_POST['appointment_id'])) {
        $appointment_id = $_POST['appointment_id'];

        // Check if the appointment exists in the database
        $check_appointment_query = "SELECT * FROM tblappoint WHERE apt_id = ?";
        $check_appointment_stmt = $conn->prepare($check_appointment_query);
        $check_appointment_stmt->bind_param("i", $appointment_id);
        $check_appointment_stmt->execute();
        $check_appointment_result = $check_appointment_stmt->get_result();

        if ($check_appointment_result->num_rows > 0) {
            // Appointment found, store appointment ID in session and redirect to confirmation page
            $_SESSION['cancellation_appointment_id'] = $appointment_id;
            header("Location: process_cancel.php");
            exit();
        } else {
            // Appointment not found, display error message
            $_SESSION['cancel_error'] = "Appointment not found. Please check the appointment ID and try again.";
            header("Location: cancel.html"); // Redirect back to cancel page
            exit();
        }
    } else {
        // Appointment ID not provided, display error message
        $_SESSION['cancel_error'] = "Please provide the appointment ID.";
        header("Location: cancel.html"); // Redirect back to cancel page
        exit();
    }
} else {
    // Redirect to the cancel page if accessed directly without POST request
    header("Location: cancel.html");
    exit();
}
