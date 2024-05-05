<?php
$conn = new mysqli('localhost', 'root', '', 'dbclinic');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sched_id, sched_date, start_time, end_time FROM tblschedule";
$result = $conn->query($sql);


?>
