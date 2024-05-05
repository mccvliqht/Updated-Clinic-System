<?php
// Define your database credentials
$db_server = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'dbclinic';

// Create a connection to the database
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

// Prepare the SQL statement
$sql = "INSERT INTO tblschedule (sched_date, start_time, end_time) VALUES ('$date', '$start_time', '$end_time')";

// Execute the SQL statement
if ($conn->query($sql) === TRUE) {

    echo "<script>alert('Data submitted'); window.location.replace(document.referrer);</script>";
    
} else {
    $message = "Error: " . $sql . "<br>" . $conn->error;
    echo "<script>alert('Data failed to Submit'); window.location.replace(document.referrer);</script>";
}

// Close the connection
$conn->close();

?>