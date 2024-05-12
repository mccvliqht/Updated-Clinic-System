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
    <title>Doctor Home</title>
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
    <span title="Logout"><a href="logout.php" onclick="return confirmSignOut()"><i id="logout" class="fa fa-sign-out"></i></a></span>
</div>

<h2 id="doclandh2" class="doctor_name">Welcome Doctor <?php echo $firstName . ' ' . $lastName; ?></h2>
<div id="todayTable"> 
    <h2>Today's Patients</h2>
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
        if ($firstName && $lastName) {
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
                WHERE apt_date = '$date' AND tbldoctor.doc_id = '$doc_id'";
        
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
        }
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

function confirmSignOut() {
    return confirm("You want to Sign out?");
}
</script>
</body>
</html>
