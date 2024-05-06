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
      <a href="doctor_profile.php"><i class="fa fa-user-circle"></i>Doctor Name</a>
      <a href="doctor_landing_page.php"><i class="fa fa-home"></i>Home</a>
      <a href="Schedules.php"><i class="fa fa-calendar"></i>Schedules</a>
      <a href="Patient.php"><i class="fa fa-users"></i>Patients</a>
      <span title="Logout"><i id="logout" class="fa fa-sign-out"></i></span>
    </div>
    
    <div>

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