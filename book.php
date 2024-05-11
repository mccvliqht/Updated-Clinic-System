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
    <title>Book Appointment</title>
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


    <div class="book-container">
            <h1>Book an Appointment</h1>
            <p>To proceed with booking an appointment, please provide the required information below.</p>

            <div class="book-form">
                <form action="process_book.php" method="post"> <!--Updated form-->
                    <div id="book-input-box">
                    <div class="book-input-box">
                        <label for="last-name" class="name">Last Name</label>
                        <input type="text" name="last-name" required class="your-name">
                    </div>
                    <div class="book-input-box">
                        <label for="first-name" class="name">First Name</label>
                        <input type="text" name="first-name" required class="your-name">
                    </div>
                    </div>

                    <div id="book-input-box">
                    <div class="book-input-box">
                        <label for="datepicker">Birthdate</label>
                        <input type="date" id="datepicker" name="datepicker" class="box">
                    </div>
                    <div class="book-input-box">
                        <label for="gender">Biological Gender</label>
                        <select id="gender" name="gender" class="box box2">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    </div>

                    <div id="book-input-box">
                    <div class="book-input-box">
                        <label for="contact-number" class="contact">Contact Number</label>
                        <input type="tel" name="contact" required class="your-contact">
                    </div>
                    <div class="book-input-box">
                        <label for="email" class="email">Email</label>
                        <input type="text" name="email" required class="your-email">
                    </div>
                    </div>

            <div id="book-input-box">
                <div class="book-input-box">
                    <label for="service">Choose service</label>
                    <select id="service" name="service" class="box2">
                        <option value="" disabled selected>Select Service</option>
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
                    <div class="book-input-box">
                        <label for="doctor">Available Doctor</label>
                        <select id="doctor" name="doctor" class="box box2">
                            <option value="" disabled selected>Select Doctor</option>
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
                    

                    <div id="book-input-box">
                    <div class="book-input-box">
                        <label for="avail-date">Available Date</label>
                        <select id="avail-date" name="date" class="box box2">
                            <option value="" disabled selected>Select Date</option>
                            <option value=""></option>
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="book-input-box">
                        <label for="avail-time">Available Time</label>
                        <select id="avail-time" name="time" class="box box2">
                            <option id="ot" value="" disabled selected>Select Time</option>
                        </select>
                    </div>
                    </div>
                    <button type="submit" id="proceed-btn">Confirm</button>
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
    timeSelect.style.width = "200px"; // Adjust the width as needed
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
