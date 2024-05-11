<?php
// Include your database connection file
require_once 'config.php';

// Check if the date and time slot is available
$date = $_POST['avail-date'];
$time = $_POST['avail-time'];

// Perform a query to check if the date and time slot is available in your database
// Example:
$sql = "SELECT COUNT(*) AS count FROM tblappoint WHERE apt_date = ? AND apt_time = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $date, $time);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $row['count'];

// Send response back to the client
$response = array('available' => ($count == 0));
echo json_encode($response);

