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

// Retrieve appointment details from tblappoint
$get_appointment_query = "SELECT a.*, s.serv_name, d.doc_lname 
                          FROM tblappoint a 
                          INNER JOIN tblservice s ON a.serv_id = s.serv_id 
                          INNER JOIN tbldoctor d ON a.doc_id = d.doc_id 
                          WHERE a.apt_id = ?";
$get_appointment_stmt = $conn->prepare($get_appointment_query);
$get_appointment_stmt->bind_param("i", $cancellation_appointment_id);
$get_appointment_stmt->execute();
$get_appointment_result = $get_appointment_stmt->get_result();

if ($get_appointment_result->num_rows > 0) {
    $appointment_row = $get_appointment_result->fetch_assoc();
} else {
    // Redirect back to cancel page if appointment details are not found
    $_SESSION['cancel_error'] = "Appointment details not found.";
    header("Location: cancel.html");
    exit();
}

// Retrieve patient details from tblpatient
$get_patient_query = "SELECT * FROM tblpatient WHERE ptn_id = ?";
$get_patient_stmt = $conn->prepare($get_patient_query);
$get_patient_stmt->bind_param("i", $appointment_row['ptn_id']);
$get_patient_stmt->execute();
$get_patient_result = $get_patient_stmt->get_result();

if ($get_patient_result->num_rows > 0) {
    $patient_details = $get_patient_result->fetch_assoc();
} else {
    // Redirect back to cancel page if patient details are not found
    $_SESSION['cancel_error'] = "Patient details not found.";
    header("Location: cancel.html");
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
    <title>Confirmation - Cancel Appointment</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Elsie&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        #cc {
            margin-top: 20px;
        }
        .cbtn {
            text-align: center;
            display:flex;
            justify: space-between;
        }
        .cancel-btn, .confirm {
            margin: 10px 20px;
        }
        .cancel-btn {
            background: #fff;
            color: #7da0ca;
            border: 1px solid #7da0ca;
            border-radius: 20px; 
            padding: 8px 40px; 
            font-size: 13px; 
            cursor: pointer; 
            width: fit-content; 
            margin-top: 20px;
        }
        .cancel-btn:hover {
            background-color: ivory; 
        }
    </style>
</head>
<body>
    <div class="appt-logo">
        <img src="img/logo.png" alt="logo icon">
    </div>

    <div class="appt-doctor-pic">
        <img src="img/doc3.png" alt="doctor">
    </div>

    <div class="confirmation-container" id="cc">
        <h1>Cancel Appointment?</h1>
        <p>Please review the details below before confirming the cancellation:</p>
        
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
            </tr>
            <tr>
                <td><strong>Time:</strong> <?php echo $appointment_row['apt_time']; ?></td>
            </tr>
            <tr>
                <td><strong>Duration: </strong><?php echo "30 minutes"; ?></td>
            </tr>
        </table>
        <div class="cbtn">
        <a href="cancel.php" class="cancel-btn">Back</a>

        <form action="cancel-success.php" method="post">
            <input type="hidden" name="appointment_id" value="<?php echo $appointment_row['apt_id']; ?>">
            <button type="submit" id="proceed-btn" class="confirm">Confirm</button>
        </form>
        </div>
    </div>
</body>
</html>
