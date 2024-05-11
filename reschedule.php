
<?php
// Include your database connection file
require_once 'config.php';

// Fetch and store the doctor schedules from the database
$sql = "SELECT doc_id, sched_date, start_time, end_time FROM tblschedule";
$result = mysqli_query($conn, $sql);
$doctorSchedules = array();
while ($row = mysqli_fetch_assoc($result)) {
    $doctorId = $row['doc_id'];
    $date = $row['sched_date'];
    $startTime = $row['start_time'];
    $endTime = $row['end_time'];
    // Store the schedule details under the corresponding doctor ID and date
    if (!isset($doctorSchedules[$doctorId])) {
        $doctorSchedules[$doctorId] = array();
    }
    if (!isset($doctorSchedules[$doctorId][$date])) {
        $doctorSchedules[$doctorId][$date] = array(
            'start_time' => $startTime,
            'end_time' => $endTime
        );
    }
}

// Store the doctor schedules as JSON for JavaScript access
echo '<script>var doctorSchedules = ' . json_encode($doctorSchedules) . ';</script>';
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
<?php
session_start();
?>
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
            <form action="process_reschedule.php" method="post">
                <div id="reschedule-input-box">
                    <div class="reschedule-input-box">
                        <select id="service" name="service" class="box">
                            <option value="" disabled selected>Choose Service</option>
                            <?php
                            // PHP code to fetch and display services from the database
                            require_once 'config.php'; // Include your database connection file
                            $sql = "SELECT * FROM tblservice";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['serv_id'] . "'>" . $row['serv_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="reschedule-input-box">
                        <select id="avail-date" name="date" class="box">
                            <option value="" disabled selected>Choose Date</option>
                        </select>
                    </div>
                </div>

                <div id="reschedule-input-box">
                    <div class="reschedule-input-box">
                        <div>
                        <select id="doctor" name="doctor" class="box">
                            <option value="" disabled selected>Choose Doctor</option>
                            <?php
                            // PHP code to fetch and display doctors from the database
                            $sql = "SELECT * FROM tbldoctor";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['doc_id'] . "'>" . "Dr. " . $row['doc_lname'] . "</option>";
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="reschedule-input-box">
                        <select id="avail-time" name="time" class="box">
                            <option value="" disabled selected>Choose Time</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="confirm-btn">Confirm</button>
            </form>
        </div>
    </div>

<?php
// Include your database connection file
require_once 'config.php';

// Define an array to store dates for each doctor
$doctorDates = array();

// Fetch dates for each doctor from the database
$sql = "SELECT doc_id, sched_date FROM tblschedule";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $doctorId = $row['doc_id'];
    $date = $row['sched_date'];
    // Store the date under the corresponding doctor ID
    if (!isset($doctorDates[$doctorId])) {
        $doctorDates[$doctorId] = array();
    }
    $doctorDates[$doctorId][] = $date;
}

// Store the dates as JSON for JavaScript access
echo '<script>var doctorDates = ' . json_encode($doctorDates) . ';</script>';
?>
<script>
    document.getElementById('service').addEventListener('change', function() {
    var selectedService = this.value;
    var doctorDropdown = document.getElementById('doctor');
    var doctors = doctorDropdown.getElementsByTagName('option');
    
    // Hide all doctors
    for (var i = 0; i < doctors.length; i++) {
        doctors[i].style.display = 'none';
    }
    
    // Show doctors based on the selected service
    switch(selectedService) {
        case '4321':
            // Show Dr. Mendoza and Dr. Callao for Service 4321
            showDoctorOption(doctors, 'Dr. Mendoza');
            showDoctorOption(doctors, 'Dr. Callao');
            break;
        case '4322':
            // Show Dr. Mendez and Dr. Tanzo for Service 4322
            showDoctorOption(doctors, 'Dr. Mendez');
            showDoctorOption(doctors, 'Dr. Tanzo');
            break;
        case '4323':
            // Show Dr. Callao and Dr. Aquino for Service 4323
            showDoctorOption(doctors, 'Dr. Callao');
            showDoctorOption(doctors, 'Dr. Aquino');
            break;
        case '4324':
            // Show Dr. Aquino and Dr. Mendoza for Service 4324
            showDoctorOption(doctors, 'Dr. Aquino');
            showDoctorOption(doctors, 'Dr. Mendoza');
            break;
        case '4325':
            // Show Dr. Bondoc and Dr. Mendez for Service 4325
            showDoctorOption(doctors, 'Dr. Bondoc');
            showDoctorOption(doctors, 'Dr. Mendez');
            break;
        case '4326':
            // Show Dr. Tanzo and Dr. Bondoc for Service 4326
            showDoctorOption(doctors, 'Dr. Tanzo');
            showDoctorOption(doctors, 'Dr. Bondoc');
            break;
        default:
            // Show all doctors if no service is selected
            for (var i = 0; i < doctors.length; i++) {
                doctors[i].style.display = 'block';
            }
            break;
    }
});

function showDoctorOption(doctors, doctorName) {
    for (var i = 0; i < doctors.length; i++) {
        if (doctors[i].textContent.trim() === doctorName) {
            doctors[i].style.display = 'block';
            break;
        }
    }
}

document.getElementById('doctor').addEventListener('change', function() {
    var selectedDoctor = this.value;
    var dateDropdown = document.getElementById('avail-date');
    dateDropdown.innerHTML = '<option value="" disabled selected>Select Date</option>';
    if (selectedDoctor) {
        // Get the dates for the selected doctor from the loaded data
        var dates = doctorDates[selectedDoctor];
        if (dates && dates.length > 0) {
            // Populate the dates dropdown
            dates.forEach(function(date) {
                dateDropdown.innerHTML += '<option value="' + date + '">' + date + '</option>';
            });
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
    // Add event listeners to the date and time dropdowns
    document.getElementById('avail-date').addEventListener('change', updateAvailableTimes);
    document.getElementById('avail-time').addEventListener('change', checkAvailability);
});

function updateAvailableTimes() {
    var selectedDoctor = document.getElementById('doctor').value;
    var selectedDate = document.getElementById('avail-date').value;
    var timeSelect = document.getElementById('avail-time');

    // Clear existing options
    timeSelect.innerHTML = '';

    // Fetch doctor schedules from JavaScript variable
    var doctorSchedules = <?php echo json_encode($doctorSchedules); ?>;

    // Check if selectedDoctor and selectedDate are valid
    if (selectedDoctor && selectedDate && doctorSchedules[selectedDoctor] && doctorSchedules[selectedDoctor][selectedDate]) {
        var startTime = doctorSchedules[selectedDoctor][selectedDate]['start_time'];
        var endTime = doctorSchedules[selectedDoctor][selectedDate]['end_time'];
        var interval = 30; // Interval in minutes

        // Convert start time and end time to timestamps for easier calculation
        var startTimestamp = new Date("1970-01-01 " + startTime).getTime();
        var endTimestamp = new Date("1970-01-01 " + endTime).getTime();

        // Generate available time slots
        for (var i = startTimestamp; i < endTimestamp; i += interval * 60 * 1000) {
            var time = new Date(i).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
            var option = document.createElement("option");
            option.text = time;
            option.value = time;
            timeSelect.appendChild(option);
        }
    } else {
        // Display a message if no times are available for the selected date and doctor
        var option = document.createElement("option");
        option.text = "No Available Times";
        timeSelect.appendChild(option);
    }
    // Set a fixed width for the dropdown
    timeSelect.style.width = "100%"; // Adjust the width as needed
}

function checkAvailability() {
    var selectedDate = document.getElementById('avail-date').value;
    var selectedTime = document.getElementById('avail-time').value;

    // Make an AJAX request to check if the selected date and time slot is available
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                var response = JSON.parse(this.responseText);
                if (response.available === false) {
                    alert("This time slot is already booked. Please choose another time.");
                    // Reset the selected time
                    document.getElementById('avail-time').value = '';
                }
            } else {
                console.error('Request failed:', this.statusText);
            }
        }
    };
    xhr.open("POST", "check-time.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("avail-date=" + selectedDate + "&avail-time=" + selectedTime);
}
</script>
<script src="script.js"></script>
</body>
</html>
