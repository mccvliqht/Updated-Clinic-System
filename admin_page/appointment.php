<?php
session_start(); // Start the session

// Include your database configuration file
include '../config.php'; 

$firstName = '';
$lastName = '';

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare SQL statement to fetch first name and last name
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

$stmt->close(); // Close statement

// Fetch appointment records
$appointmentSql = "SELECT apt.apt_id, 
                          CONCAT(ptn.ptn_fname, ' ', ptn.ptn_lname) AS patient, 
                          serv.serv_name AS service, 
                          CONCAT(doc.doc_fname, ' ', doc.doc_lname) AS service_provider, 
                          apt.apt_date, 
                          apt.apt_time, 
                          serv.serv_duration AS duration,
                          apt.sched_status
                   FROM tblappoint apt 
                   INNER JOIN tblpatient ptn ON apt.ptn_id = ptn.ptn_id 
                   INNER JOIN tbldoctor doc ON apt.doc_id = doc.doc_id 
                   INNER JOIN tblservice serv ON apt.serv_id = serv.serv_id";

$appointmentResult = $conn->query($appointmentSql);
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
        <li><a href="admin_landing_page.php"><i class="fa fa-calendar"></i> <span>Calendar</span></a></li>
        <li><a href="doctor.php"><i class="fa fa-stethoscope"></i> <span>Doctor</span></a></li>
        <li><a href="patients.php"><i class="fa fa-user"></i> <span>Patient</span></a></li>
        <li><a href="appointment.php"><i class="fa fa-clipboard"></i> <span>Appointment</span></a></li>
        <li><a href="account_details.php"><i class="fa fa-user-circle-o"></i> <span>Account Details</span></a></li>
    </ul>
  </div>
  <div class="content">
    <h2>Appointments List</h2>
    <div class="toolbar">
      <div class="toolbox-left">
        <div class="status-buttons">
          <button class="status-button" data-status="all">All</button>
          <button class="status-button" data-status="upcoming">Upcoming</button>
          <button class="status-button" data-status="completed">Completed</button>
          <button class="status-button" data-status="canceled">Canceled</button>
        </div>
      </div>
      <div class="toolbar__search">
        <input type="text" placeholder="Search...">
        <button class="search-button"><i class="fa fa-search"></i></button>
      </div>
      <div class="toolbar__filter">
        <button>Filter</button>
      </div>
  </div>
    <table class="appointment-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Patient</th>
          <th>Service</th>
          <th>Service Provider</th>
          <th>Date</th>
          <th>Start Time</th>
          <th>Duration (minutes)</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Populate table rows with appointment records
          if ($appointmentResult->num_rows > 0) {
              while ($row = $appointmentResult->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['apt_id'] . "</td>";
                  echo "<td>" . $row['patient'] . "</td>";
                  echo "<td>" . $row['service'] . "</td>";
                  echo "<td>" . $row['service_provider'] . "</td>";
                  echo "<td>" . $row['apt_date'] . "</td>";
                  echo "<td>" . $row['apt_time'] . "</td>";
                  echo "<td>" . $row['duration'] . "</td>";
                  echo "<td>" . $row['sched_status'] . "</td>";
                  echo "<td><i class='fa fa-trash delete-icon action-icon'></i> <i class='fa fa-pencil edit-icon action-icon'></i></td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='9'>No records found</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
  <script src="admin_script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
