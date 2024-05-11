<?php
// Start the session
session_start();
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
        <h1>Successfully Booked!</h1>
        <p>Thank you for booking your appointment with us! Please save the <strong>appointment ID</strong> provided, 
            as it is not only crucial for any changes, cancellations, or rescheduling of your appointment 
            but also necessary for verification on your appointment day. For your privacy and security, 
            please refrain from sharing this ID with just anyone. </p>
        <table class="confirmation-details">
            <tr>
                <td><strong>Appointment ID:</strong> <?php echo $_SESSION['appointment_details']['appointment_id']; ?></td>
            </tr>
            <tr>
                <td><strong>Name:</strong> <?php echo $_SESSION['appointment_details']['first_name'] . " " . $_SESSION['appointment_details']['last_name']; ?></td>
            </tr>
            <tr>
                <td><strong>Gender:</strong> <?php echo ucfirst($_SESSION['appointment_details']['gender']); ?></td>
            </tr>
            <tr>
                <td><strong>Birthdate:</strong> <?php echo $_SESSION['appointment_details']['birthdate']; ?></td>
            </tr>
            <tr>
                <td><strong>Contact:</strong> <?php echo $_SESSION['appointment_details']['contact']; ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong> <?php echo $_SESSION['appointment_details']['email']; ?></td>
            </tr>
            <tr>
                <td><strong>Service:</strong> <?php echo $_SESSION['appointment_details']['service']; ?></td>
            </tr>
            <tr>
                <td><strong>Doctor:</strong><?php echo " Dr. ". $_SESSION['appointment_details']['doctor']; ?></td>
            </tr>
            <tr>
                <td><strong>Date:</strong> <?php echo $_SESSION['appointment_details']['avail-date']; ?></td>
            </tr>
            <tr>
                <td><strong>Time:</strong> <?php echo $_SESSION['appointment_details']['avail-time']; ?></td>
            </tr>
            <tr>
                <td><strong>Duration: </strong><?php echo "30 minutes"; ?></td>
            </tr>
        </table>
        <a href="home.html" id="proceed-btn">Back</a>
    </div>
    
</body>
</html>
