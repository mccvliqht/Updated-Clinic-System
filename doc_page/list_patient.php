<?php
$conn = new mysqli('localhost', 'root', '', 'dbclinic');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT apt_id, ptn_fname, ptn_lname, serv_name, ptn_contact, apt_date, apt_time, serv_duration, sched_status 
            FROM tblappoint 
            JOIN tblpatient ON tblappoint.ptn_id = tblpatient.ptn_id
            JOIN tbldoctor ON tblappoint.doc_id = tbldoctor.doc_id
            JOIN tblservice ON tblappoint.serv_id = tblservice.serv_id";
$result = $conn->query($sql);


?>
