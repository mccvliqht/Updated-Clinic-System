<?php
session_start();
include 'config.php'; // Include your database configuration file

// Check if the appointment details are set in the session
if (!isset($_SESSION['appointment_details'])) {
    // Redirect to the homepage or another appropriate page if appointment details are not set
    header("Location: home.html");
    exit();
}

// Retrieve the appointment details from the session
$appointment_details = $_SESSION['appointment_details'];

// Retrieve the updated appointment details from the database
$get_appointment_query = "SELECT a.*, s.serv_name, d.doc_lname
                          FROM tblappoint a 
                          INNER JOIN tblservice s ON a.serv_id = s.serv_id 
                          INNER JOIN tbldoctor d ON a.doc_id = d.doc_id 
                          WHERE a.apt_id = ?";
$get_appointment_stmt = $conn->prepare($get_appointment_query);
$get_appointment_stmt->bind_param("i", $appointment_details['appointment_id']);
if (!$get_appointment_stmt->execute()) {
    echo "Error retrieving appointment details: " . $conn->error;
    exit();
}
$get_appointment_result = $get_appointment_stmt->get_result();

// Fetch the appointment details
if ($get_appointment_result->num_rows > 0) {
    $appointment_row = $get_appointment_result->fetch_assoc();
} else {
    echo "Error: Appointment not found.";
    exit();
}

// Retrieve the patient details from the database
$get_patient_query = "SELECT * FROM tblpatient WHERE ptn_id = ?";
$get_patient_stmt = $conn->prepare($get_patient_query);
$get_patient_stmt->bind_param("i", $appointment_row['ptn_id']);
if (!$get_patient_stmt->execute()) {
    echo "Error retrieving patient details: " . $conn->error;
    exit();
}
$get_patient_result = $get_patient_stmt->get_result();

// Fetch the patient details
if ($get_patient_result->num_rows > 0) {
    $patient_details = $get_patient_result->fetch_assoc();
} else {
    echo "Error: Patient details not found.";
    exit();
}

// Close prepared statements
$get_appointment_stmt->close();
$get_patient_stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Elsie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="appt-logo">
        <img src="img/logo.png" alt="logo icon">
    </div>

    <div class="appt-doctor-pic">
        <img src="img/doc3.png" alt="doctor">
    </div>

    <div class="confirmation-container">
        <h1>Rescheduling Successful!</h1>
        <p>Your appointment has been successfully rescheduled. Please save the <strong>appointment ID</strong> provided, 
            as it is not only crucial for any changes, cancellations, or rescheduling of your appointment 
            but also necessary for verification on your appointment day. For your privacy and security, 
            please refrain from sharing this ID with just anyone.</p>
        
        <table class="confirmation-details">
    <tr>
        <td><strong>Appointment ID:</strong> <?php echo $appointment_row['apt_id']; ?></td>
    </tr>
    <tr>
        <td><strong>Name:</strong> <?php echo $patient_details['ptn_fname'] . " " . $patient_details['ptn_lname']; ?></td>
    </tr>
    <tr>
        <td><strong>Birthdate:</strong> <?php echo $patient_details['ptn_birthdate']; ?></td>
    </tr>
    <tr>
        <td><strong>Gender:</strong> <?php echo ucfirst($patient_details['ptn_gender']); ?></td>
    </tr>
    <tr>
        <td><strong>Contact:</strong> <?php echo $patient_details['ptn_contact']; ?></td>
    </tr>
    <tr>
        <td><strong>Email:</strong> <?php echo $patient_details['ptn_email']; ?></td>
    </tr>
    <tr>
        <td><strong>Service:</strong> <?php echo $appointment_row['serv_name']; ?></td>
    </tr>
    <tr>
        <td><strong>Doctor:</strong> Dr. <?php echo $appointment_row['doc_lname']; ?></td>
    </tr>
    <tr>
        <td><strong>Date:</strong> <?php echo $appointment_row['apt_date']; ?></td>
    <tr>
        <td><strong>Time:</strong> <?php echo $appointment_row['apt_time']; ?></td>
    </tr>
    <tr>
        <td><strong>Duration: </strong><?php echo "30 minutes"; ?></td>
    </tr>
</table>

        <a href="home.html" id="proceed-btn">Back to Home</a>
    </div>
</body>
</html>
