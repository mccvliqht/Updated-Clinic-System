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

// Fetch patient records with their appointment ID
$patientSql = "SELECT p.ptn_id AS ID, p.ptn_lname AS 'Last Name', p.ptn_fname AS 'First Name', 
                     p.ptn_contact AS Contacts, p.ptn_email AS Email, 
                     TIMESTAMPDIFF(YEAR, p.ptn_birthdate, CURDATE()) AS Age, p.ptn_gender AS Gender, 
                     a.apt_id AS 'Appointment ID' 
              FROM tblpatient p
              LEFT JOIN tblappoint a ON p.ptn_id = a.ptn_id";
$patientResult = $conn->query($patientSql);

// Handle record deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ptnId'])) {
  // Get the ptnId from the POST data
  $ptnId = $_POST['ptnId'];

  // Prepare and execute the SQL statement to delete appointments for the patient
  $deleteAppointmentsSql = "DELETE FROM tblappoint WHERE ptn_id = ?";
  $stmtAppointments = $conn->prepare($deleteAppointmentsSql);
  $stmtAppointments->bind_param("i", $ptnId);

  // Execute appointment deletion query
  if ($stmtAppointments->execute()) {
      // Prepare and execute the SQL statement to delete the patient record
      $deletePatientSql = "DELETE FROM tblpatient WHERE ptn_id = ?";
      $stmtPatient = $conn->prepare($deletePatientSql);
      $stmtPatient->bind_param("i", $ptnId);

      // Execute patient deletion query
      if ($stmtPatient->execute()) {
          // If both deletions are successful, echo 'success'
          $response = array('success' => true);
          echo json_encode($response);
          exit();
      } else {
          // If patient deletion fails, echo 'error'
          $response = array('success' => false, 'message' => 'Error deleting patient record.');
          echo json_encode($response);
          exit();
      }
  } else {
      // If appointment deletion fails, echo 'error'
      $response = array('success' => false, 'message' => 'Error deleting appointment records.');
      echo json_encode($response);
      exit();
  }

  // Close statements
  $stmtAppointments->close();
  $stmtPatient->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <h2>Patients List</h2>
    <div class="toolbar">
      <div class="toolbar__search">
        <input type="text" placeholder="Search...">
        <button class="search-button"><i class="fas fa-search"></i></button>
      </div>
    </div>

    <table class="doctor-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Last Name</th>
          <th>First Name</th>
          <th>Contacts</th>
          <th>Email</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Appointment ID</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // Populate table rows with patient records
          if ($patientResult->num_rows > 0) {
              while ($row = $patientResult->fetch_assoc()) {
                  echo "<tr data-id='" . $row['ID'] . "'>";
                  echo "<td>" . $row['ID'] . "</td>";
                  echo "<td>" . $row['Last Name'] . "</td>";
                  echo "<td>" . $row['First Name'] . "</td>";
                  echo "<td>" . $row['Contacts'] . "</td>";
                  echo "<td>" . $row['Email'] . "</td>";
                  echo "<td>" . $row['Age'] . "</td>";
                  echo "<td>" . $row['Gender'] . "</td>";
                  echo "<td>" . $row['Appointment ID'] . "</td>";
                  echo "<td>
                  <form method='post' class='delete-form'>
                      <input type='hidden' name='ptnId' value='" . $row['ID'] . "'>
                      <div class='action-icons'>
                          <button type='button' class='delete-icon' onclick='confirmDelete(" . $row['ID'] . ");'><i class='fa fa-trash'></i></button>
                      </div>
                  </form>
                 </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='9'>No records found</td></tr>";
          }
        ?>
      </tbody>
    </table>
    
  </div>
  <script>
    // Function to prevent form resubmission on page reload
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

    // Function to confirm deletion
    function confirmDelete(ptnId) {
        if (confirm('Are you sure you want to delete this patient?')) {
            $.ajax({
                type: 'POST',
                url: 'patients.php',
                data: { ptnId: ptnId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Patient deleted successfully.');
                        location.reload();
                    } else {
                        alert('Error: ' + result.message);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the patient.');
                }
            });
        }
    }
  </script>
  <script src="admin_script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
