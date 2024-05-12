<?php
session_start(); 

include '../config.php'; 

$firstName = '';
$lastName = '';

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    
    $sql = "SELECT adm_fname, adm_lname 
            FROM tblAdmin 
            INNER JOIN tblLogin ON tblAdmin.lgn_id = tblLogin.lgn_id 
            WHERE tblLogin.lgn_username = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute statement
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Store result
    $stmt->store_result();

    // Check if username exists
    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($adm_fname, $adm_lname);

        // Fetch result
        $stmt->fetch();

        // Assign fetched values to variables
        $firstName = $adm_fname;
        $lastName = $adm_lname;
    }
}

// Count doctors
$sqlDoctors = "SELECT COUNT(*) AS totalDoctors FROM tbldoctor";
$resultDoctors = $conn->query($sqlDoctors);
$rowDoctors = $resultDoctors->fetch_assoc();
$totalDoctors = $rowDoctors['totalDoctors'];

// Count patients
$sqlPatients = "SELECT COUNT(*) AS totalPatients FROM tblpatient";
$resultPatients = $conn->query($sqlPatients);
$rowPatients = $resultPatients->fetch_assoc();
$totalPatients = $rowPatients['totalPatients'];

// Count appointments
$sqlAppointments = "SELECT COUNT(*) AS totalAppointments FROM tblappoint";
$resultAppointments = $conn->query($sqlAppointments);
$rowAppointments = $resultAppointments->fetch_assoc();
$totalAppointments = $rowAppointments['totalAppointments'];

$stmt->close(); // Close statement
$conn->close(); // Close connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
  <div class="sidebar">
    <div class="navbar">
      <div class="navbar-title" id="navbarTitle">ADMIN PANEL</div>
      <button class="nav-icon" onclick="toggleSidebar()">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </button>
    </div>
    <ul class="nav-links">
        <?php if($firstName && $lastName): ?>
            <li>
                <span>
                    <i class="fa fa-user-circle"></i>
                    <?php echo $firstName . ' ' . $lastName; ?>
                </span>
            </li>
        <?php endif; ?>
        <li><a href="admin_landing_page.php"><i class="fa fa-calendar"></i> <span>Dashboard</span></a></li>
        <li><a href="doctor.php"><i class="fa fa-stethoscope"></i> <span>Doctor</span></a></li>
        <li><a href="patients.php"><i class="fa fa-user"></i> <span>Patient</span></a></li>
        <li><a href="appointment.php"><i class="fa fa-clipboard"></i> <span>Appointment</span></a></li>
        <li><a href="account_details.php"><i class="fa fa-user-circle-o"></i> <span>Account Details</span></a></li>
        <li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
    </ul>
  </div>
  <div class="content">
    <div class="dashboard-container">
        <div class="dashboard">
          <h2>Welcome Back, <?php echo $firstName . ' ' . $lastName; ?> !</h2>
            <div class="dashboard-box">
                <h3>Total Doctors</h3>
                <p><?php echo $totalDoctors; ?></p>
            </div>
            <div class="dashboard-box">
                <h3>Total Patients</h3>
                <p><?php echo $totalPatients; ?></p>
            </div>
            <div class="dashboard-box">
                <h3>Total Appointments</h3>
                <p><?php echo $totalAppointments; ?></p>
            </div>
        </div>
    </div>
  </div>
  <script src="admin_script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
