<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
    
    <h2 id="doclandh2">Welcome Doctor Name</h2>
    
   <div id="todayTable"> 
    <table>
        <tr>
            <th>Appointment ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Doctor First Name</th>
            <th>Doctor Last Name</th>
            <th>Service</th>
            <th>Appointment Time</th>
        </tr>
        <?php
        $conn = new mysqli('localhost', 'root', '', 'dbclinic');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $date = date('Y-m-d'); // Get today's date

        $sql = "SELECT apt_id, ptn_fname, ptn_lname, doc_fname, doc_lname, serv_name, apt_time
            FROM tblappoint 
            JOIN tblpatient ON tblappoint.ptn_id = tblpatient.ptn_id
            JOIN tbldoctor ON tblappoint.doc_id = tbldoctor.doc_id
            JOIN tblservice ON tblappoint.serv_id = tblservice.serv_id
            WHERE apt_date = '$date'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["apt_id"] . "</td>";
                echo "<td>" . $row["ptn_fname"] . "</td>";
                echo "<td>" . $row["ptn_lname"] . "</td>";
                echo "<td>" . $row["doc_fname"] . "</td>";
                echo "<td>" . $row["doc_lname"] . "</td>";
                echo "<td>" . $row["serv_name"] . "</td>";
                echo "<td>" . $row["apt_time"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No patients today</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    
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
