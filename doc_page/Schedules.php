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
  
  $doc_id = '';
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
          $doc_id = $doc_id; // Use the correct variable name
          $firstName = $doc_fname;
          $lastName = $doc_lname;

      }
  }
  
  $stmt->close(); // Close statement

  if(isset($_POST['date']) && isset($_POST['start_time']) && isset($_POST['end_time'])) {
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
    // Insert the schedule into the database
    $insert_sql = "INSERT INTO tblSchedule (doc_id, sched_date, start_time, end_time) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("isss", $doc_id, $date, $start_time, $end_time);
    $insert_stmt->execute();
    $insert_stmt->close();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules</title>
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
                <input type="hidden" name="doc_id" value="<?php echo $doc_id; ?>">
                <input type="submit" value="Submit" onclick="return confirmSubmit()"><br>
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
                <th>Action</th>
            </tr>
            <?php
            $sql_display = "SELECT * FROM tblSchedule WHERE doc_id = ?";
            $stmt_display = $conn->prepare($sql_display);
            $stmt_display->bind_param("i", $doc_id);
            $stmt_display->execute();
            $result = $stmt_display->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["sched_id"]."</td>";
                    echo "<td>".$row["sched_date"]."</td>";
                    echo "<td>".$row["start_time"]."</td>";
                    echo "<td>".$row["end_time"]."</td>";
                    echo "<td>";
                    echo "<form action='delete_schedule.php' method='post'>";
                    echo "<input type='hidden' name='sched_id' value='".$row["sched_id"]."'>";
                    echo "<input type='submit' value='Delete' onclick='return confirmDelete()'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No Schedules found</td></tr>";
            }

            $stmt_display->close();
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

    function confirmDelete() {
    return confirm("Are you sure you want to delete this record?");
    }

    function confirmSubmit() {
    return confirm("Are you sure you want to submit this schedule?");
}

    </script>

</body>
</html>
