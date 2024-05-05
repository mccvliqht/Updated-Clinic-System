<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules</title>
    <link rel="stylesheet" href="doc_style.css">
    <link rel="icon" href="LogoClinic.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <span style="font-size:30px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars"></i></span>
    
</head>
    <body>
    <div id="mySidenav" class="sidenav">
      <img src="Logo.png" id="mylogo" alt="Soriano Clinic logo">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="Doctor profile.html"><i class="fa fa-user-circle"></i>Doctor Name</a>
      <a href="doctor_landing_page.php"><i class="fa fa-home"></i>Home</a>
      <a href="Schedules.html"><i class="fa fa-calendar"></i>Schedules</a>
      <a href="Patient.html"><i class="fa fa-users"></i>Patients</a>
      <span title="Logout"><i id="logout" class="fa fa-sign-out"></i></span>
    </div>
    
  <div id="schedContainer">
    <div id="mainSched">

      <h3>ADD SCHEDULE</h3>
      <form action="insert_schedule.php" method="post">
        <div class="boxSched">
          <label for="date">Select Date</label><br>
          <input type="date" name="date"><br>
        </div>

        <div class="boxSched">
          <label for="time">Start Time</label><br>
          <input type="time" name="start_time"><br>
        </div>
        
        <div class="boxSched">
          <label for="">End Time</label><br>
          <input type="time" name="end_time"><br><br>
          <input type="submit" value="Submit"><br>
        </div>
        
        
      </form>

    </div>

    <div id="tableSched">
    <h3>MY SCHEDULES</h3><br>
      <table>
          <tr>
              <th>Schedules ID</th>
              <th>Schedules Date</th>
              <th>Start Time</th>
              <th>End Time</th>
          </tr>
          <?php include 'display_doc_schedules.php'; ?>
          <?php
            $result = $conn->query($sql);

            // Check if query was successful
            if ($result === false) {
                die("Error executing the query: " . $conn->error);
            }


            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["sched_id"]."</td>";
                    echo "<td>".$row["sched_date"]."</td>";
                    echo "<td>".$row["start_time"]."</td>";
                    echo "<td>".$row["end_time"]."</td>";
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