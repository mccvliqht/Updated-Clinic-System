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

// Fetch doctor records
$doctorSql = "SELECT doc_id, doc_fname, doc_lname, doc_contact, doc_email, 
                     TIMESTAMPDIFF(YEAR, doc_birthdate, CURDATE()) AS age, 
                     doc_spec 
              FROM tbldoctor";
$doctorResult = $conn->query($doctorSql);

// Handle record deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['docId'])) {
  // Get the docId from the POST data
  $docId = $_POST['docId'];

  // Prepare and execute the SQL statement to delete the record from tbldoctor
  $deleteDoctorSql = "DELETE FROM tbldoctor WHERE doc_id = ?";
  $stmtDoctor = $conn->prepare($deleteDoctorSql);
  $stmtDoctor->bind_param("i", $docId);

  // Execute doctor deletion query
  if ($stmtDoctor->execute()) {
      // Prepare and execute the SQL statement to delete the record from tbllogin
      $deleteLoginSql = "DELETE tbllogin FROM tbllogin INNER JOIN tbldoctor ON tbllogin.lgn_id = tbldoctor.lgn_id WHERE tbldoctor.doc_id = ?";
      $stmtLogin = $conn->prepare($deleteLoginSql);
      $stmtLogin->bind_param("i", $docId);

      if ($stmtLogin->execute()) {
          // If deletion is successful for both tables, redirect back to the admin page
          header("Location: doctor.php");
          exit();
      } else {
          // If deletion from tbllogin fails, handle the error
          echo 'Error deleting record from tbllogin!';
      }
  } else {
      // If deletion from tbldoctor fails, handle the error
      echo 'Error deleting record from tbldoctor!';
  }
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
    <h2>Doctors List</h2>
      <div class="toolbar">
        <div class="toolbar__search">
          <input type="text" placeholder="Search...">
          <button class="search-button"><i class="fas fa-search"></i></button>
        </div>
        <div class="toolbar__filter">
          <button class="filter-button"><i class="fas fa-filter"></i> Filter</button>
        </div>
      </div>

      <table class="doctor-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Age</th>
            <th>Specialization</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Populate table rows with doctor records
            if ($doctorResult->num_rows > 0) {
                while ($row = $doctorResult->fetch_assoc()) {
                    echo "<tr data-id='" . $row['doc_id'] . "'>";
                    echo "<td>" . $row['doc_id'] . "</td>";
                    echo "<td>" . $row['doc_lname'] . "</td>";
                    echo "<td>" . $row['doc_fname'] . "</td>";
                    echo "<td>" . $row['doc_contact'] . "</td>";
                    echo "<td>" . $row['doc_email'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['doc_spec'] . "</td>";
                    echo "<td>
                    <form method='post'>
                        <input type='hidden' name='docId' value='" . $row['doc_id'] . "'>
                        <div class='action-icons'>
                            <button type='submit' class='delete-button'><i class='fa fa-trash delete-icon action-icon'></i></button>
                        </div>
                    </form>
                   </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No records found</td></tr>";
            }
          ?>
        </tbody>
      </table>
      
  </div>
  <script src="admin_script.js?v=<?php echo time(); ?>"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
