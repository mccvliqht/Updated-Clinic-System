<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || isset($_SESSION['logged_out'])) {
    // Redirect to the login page
    header("location: ../login.php");
    exit;
}
?>
<?php


include '../config.php'; 

$firstName = '';
$lastName = '';

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT doc_id, doc_fname, doc_lname 
            FROM tblDoctor
            INNER JOIN tblLogin ON tblDoctor.lgn_id = tblLogin.lgn_id 
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
        $stmt->bind_result($doc_id, $doc_fname, $doc_lname);

        // Fetch result
        $stmt->fetch();

        // Assign fetched values to variables
        $firstName = $doc_fname;
        $lastName = $doc_lname;
    }
    $stmt->close(); // Close statement
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient page</title>
    <link rel="stylesheet" href="doc_style.css">
    <link rel="icon" href="LogoClinic.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <span id="BarsNav" style="font-size:30px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars"></i></span>
    
</head>
    <body>
    <div id="mySidenav" class="sidenav">
      <img src="Logo.png" id="mylogo" alt="Soriano Clinic logo">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <?php if($firstName && $lastName): ?>
        <a href="doctor_profile.php" class="doctor_name"><i class="fa fa-user-circle"></i><?php echo $firstName . ' ' . $lastName; ?></a>
      <?php endif; ?>    
      <a href="doctor_landing_page.php"><i class="fa fa-home"></i>Home</a>
      <a href="Schedules.php"><i class="fa fa-calendar"></i>Schedules</a>
      <a href="Patient.php"><i class="fa fa-users"></i>Patients</a>
      <span title="Logout"><a href="logout.php"><i id="logout" class="fa fa-sign-out"></i></a></span>
    </div>

    <div id="patientTable">
      <h2>PATIENT LIST</h2>
    <table>
          <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Service</th>
              <th>Contacts</th>
              <th>Date</th>
              <th>Start Time</th>
              <th>Duration</th>
              <th>Status</th>
              <th>Action</th>

          </tr>
          <?php include 'list_patient.php'; ?>
          <?php
            $result = $conn->query($sql);

            // Check if query was successful
            if ($result === false) {
                die("Error executing the query: " . $conn->error);
            }


            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["apt_id"]."</td>";
                    echo "<td>".$row["ptn_fname"]."</td>";
                    echo "<td>".$row["ptn_lname"]."</td>";
                    echo "<td>".$row["serv_name"]."</td>";
                    echo "<td>".$row["ptn_contact"]."</td>";
                    echo "<td>".$row["apt_date"]."</td>";
                    echo "<td>".$row["apt_time"]."</td>";
                    echo "<td>".$row["serv_duration"]."</td>";
                    echo "<td>".$row["sched_status"]."</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='3'>No records found</td></tr>";
          }

          $result->free();

          // Close connection
          $conn->close();

          ?>
      </table>
    </div>
        
    <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }
    
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
    </script>
       
    </body>
</html>