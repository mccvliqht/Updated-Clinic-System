<?php
session_start();
include 'config.php'; // Include your database configuration file

// Retrieve the appointment ID from the session
$appointment_id = $_SESSION['appointment_details']['appointment_id'];

// Retrieve the form data for rescheduling
$service = $_POST['service'];
$date = $_POST['date'];
$doctor = $_POST['doctor'];
$time = $_POST['time'];

// Retrieve service ID based on service name
$service_id_sql = "SELECT serv_id FROM tblservice WHERE serv_name = ?";
$service_stmt = $conn->prepare($service_id_sql);
$service_stmt->bind_param("s", $service);
$service_stmt->execute();
$service_result = $service_stmt->get_result();

// Check if the query returned any rows
if ($service_result->num_rows > 0) {
    // Fetch the row and retrieve the service ID
    $service_row = $service_result->fetch_assoc();
    $service_id = $service_row['serv_id'];
} else {
    // Handle the case where the service name was not found in the database
    // For example, you can display an error message or set a default service ID
    echo "Error: Service not found in the database.";
    exit(); // Stop execution or handle the error appropriately
}

// Retrieve doctor ID based on doctor name
$doctor_id_sql = "SELECT doc_id FROM tbldoctor WHERE doc_lname = ?";
$doctor_stmt = $conn->prepare($doctor_id_sql);
$doctor_stmt->bind_param("s", $doctor);
$doctor_stmt->execute();
$doctor_result = $doctor_stmt->get_result();

// Check if the query returned any rows
if ($doctor_result->num_rows > 0) {
    // Fetch the row and retrieve the doctor ID
    $doctor_row = $doctor_result->fetch_assoc();
    $doctor_id = $doctor_row['doc_id'];
} else {
    // Handle the case where the doctor name was not found in the database
    // For example, you can display an error message or set a default doctor ID
    echo "Error: Doctor not found in the database.";
    exit(); // Stop execution or handle the error appropriately
}

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
