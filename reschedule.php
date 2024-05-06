<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment</title>
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

    <div class="reschedule-container">
        <h1>Appointment Details</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Magni perspiciatis id saepe quia illo adipisci delectus, 
            officiis voluptate vel itaque.</p>
        <table class="resched-details">
        <tr>
            <td><strong>Appointment ID: </strong><?php echo $_SESSION['appointment_details']['appointment_id']; ?></td>
        </tr>
        <tr>
            <td><strong>Name: </strong><?php echo $_SESSION['appointment_details']['first_name'] . " " . $_SESSION['appointment_details']['last_name']; ?></td>
        </tr>
        </table>
        <div class="reschedule">
            <form action="" method="post">
                <div id="reschedule-input-box">
                    <div class="reschedule-input-box">
                        <select id="service" name="service" class="box">
                            <option value="" disabled selected>Choose Service</option>
                            <option value="Blood Test">Blood Test</option>
                            <option value="Vaccination">Vaccination</option>
                            <option value="Minor Illness">Minor Illness</option>
                            <option value="Chronic Disease">Chronic Disease</option>
                            <option value="Ultrasound">Ultrasound</option>
                            <option value="Dental">Dental</option>
                        </select>
                    </div>
                    <div class="reschedule-input-box">
                        <select id="avail-date" name="date" class="box">
                            <option value="" disabled selected>Choose Date</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div id="reschedule-input-box">
                    <div class="reschedule-input-box">
                        <div>
                        <select id="doctor" name="doctor" class="box">
                            <option value="" disabled selected>Choose Doctor</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                        </div>
                    </div>
                    <div class="reschedule-input-box">
                        <select id="avail-time" name="time" class="box">
                            <option value="" disabled selected>Choose Time</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="confirm-btn">Confirm</button>
            </form>
        </div>
    </div>
        <script src="reschedule.js"></script>
</body>
</html>
