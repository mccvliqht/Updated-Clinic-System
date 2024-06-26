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

// Initialize variables
$searchTerm = "";
$searchSql = "";

// Check if search term is provided
if(isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    
    // Build the search SQL query dynamically
    $searchSql = "WHERE ptn.ptn_fname LIKE '%$searchTerm%' OR ptn.ptn_lname LIKE '%$searchTerm%' OR serv.serv_name LIKE '%$searchTerm%' OR CONCAT(doc.doc_fname, ' ', doc.doc_lname) LIKE '%$searchTerm%' OR apt.apt_id = '$searchTerm'";
}

// Fetch appointment records with search filter
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
                   INNER JOIN tblservice serv ON apt.serv_id = serv.serv_id
                   $searchSql"; // Append search filter SQL

$appointmentResult = $conn->query($appointmentSql);


// Handle record deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recordId'])) {
  // Get the recordId from the POST data
  $recordId = $_POST['recordId'];

  // Check if status is being updated
  if (isset($_POST['status'])) {
    $status = $_POST['status'];
    // Prepare and execute the SQL statement to update the appointment record
    $updateAppointmentSql = "UPDATE tblappoint SET sched_status = ? WHERE apt_id = ?";
    $stmtAppointment = $conn->prepare($updateAppointmentSql);
    $stmtAppointment->bind_param("si", $status, $recordId);

    // Execute appointment update query
    if ($stmtAppointment->execute()) {
        // If update is successful, echo 'success'
        
    } else {
        // If update fails, echo 'error'
       
    }

    // Close statement
    $stmtAppointment->close();
  } else {
    // Prepare and execute the SQL statement to delete the appointment record
    $deleteAppointmentSql = "DELETE FROM tblappoint WHERE apt_id = ?";
    $stmtAppointment = $conn->prepare($deleteAppointmentSql);
    $stmtAppointment->bind_param("i", $recordId);

    // Execute appointment deletion query
    if ($stmtAppointment->execute()) {
        // If deletion is successful, echo 'success'
        
    } else {
        // If deletion fails, echo 'error'
        
    }

    // Close statement
    $stmtAppointment->close();
  }
} else {
  // If the request method is not POST or recordId is not set, echo 'error'
  echo 'error';
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
  <style>
    .status-input {
      display: none;
    }
  </style>
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
                    echo "<td>
                          <form id=\"delete-form-" . $row['apt_id'] . "\" class=\"delete-form\" method=\"post\" onsubmit=\"return confirmDelete();\">
                              <input type=\"hidden\" name=\"recordId\" value=\"" . $row['apt_id'] . "\">
                              <button type=\"submit\" class=\"delete-icon\"><i class=\"fa fa-trash\"></i></button>
                          </form>
                          <form id=\"edit-form-" . $row['apt_id'] . "\" class=\"action-form\" method=\"post\">
                              <input type=\"hidden\" name=\"recordId\" value=\"" . $row['apt_id'] . "\">
                              <input type=\"text\" name=\"status\" placeholder=\"Enter status\" value=\"" . $row['sched_status'] . "\" class=\"status-input\">
                              <button type=\"button\" class=\"edit-icon\" onclick=\"toggleStatusInput(this)\"><i class=\"fa fa-pencil\"></i></button>
                              <button type=\"submit\" class=\"submit-icon\" style=\"display: none;\"><i class=\"fa fa-check\"></i></button>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="admin_script.js?v=<?php echo time(); ?>"></script>
  <script>
    
        // Function to prevent form resubmission on page reload
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    
    function toggleStatusInput(button) {
      var form = button.parentElement;
      var input = form.querySelector('.status-input');
      var submitButton = form.querySelector('.submit-icon');
      
      input.style.display = 'block';
      button.style.display = 'none';
      submitButton.style.display = 'block';
    }

    // JavaScript function to display a confirmation prompt before deleting an appointment
    function confirmDelete() {
        return confirm("Are you sure you want to delete this appointment?");
    }

    // Function to toggle status input and show confirmation prompt
    function toggleStatusInput(button) {
        var form = button.parentElement;
        var input = form.querySelector('.status-input');
        var submitButton = form.querySelector('.submit-icon');
      
        // Display the status input field
        input.style.display = 'block';
        // Hide the edit icon
        button.style.display = 'none';
        // Show the submit icon
        submitButton.style.display = 'block';

        // Attach event listener to the submit button for confirmation
        submitButton.addEventListener('click', function(event) {
            if (!confirmSaveChanges()) {
                event.preventDefault(); // Prevent form submission if user selects "No"
            }
        });
    }

    // Function to confirm before saving changes
    function confirmSaveChanges() {
        return confirm("Are you sure you want to save changes?");
    }

      // Function to filter appointment records based on status
      function filterAppointments(status) {
          var rows = document.querySelectorAll(".appointment-table tbody tr");

          rows.forEach(function(row) {
              var rowStatus = row.querySelector("td:nth-child(8)").textContent.trim();
              if (status === 'all' || rowStatus.toLowerCase() === status.toLowerCase()) {
                  row.style.display = "table-row";
              } else {
                  row.style.display = "none";
              }
          });

          // Remove active class from all buttons
          document.querySelectorAll(".status-button").forEach(function(button) {
              button.classList.remove("active-status");
          });

          // Add active class to the selected button
          document.querySelector(".status-button[data-status='" + status + "']").classList.add("active-status");
      }

      // Add event listeners to status buttons to filter appointments
      document.querySelectorAll(".status-button").forEach(function(button) {
          button.addEventListener("click", function() {
              var status = this.dataset.status;
              filterAppointments(status);
          });
      });
  </script>
</body>
</html>
