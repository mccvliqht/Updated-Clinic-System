<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || isset($_SESSION['logged_out'])) {
    // Redirect to the login page
    header("location: ../login.php");
    exit;
}

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

    // Modify the SQL query to fetch data relevant to the current user
$sql = "SELECT apt_id, ptn_fname, ptn_lname, serv_name, ptn_contact, apt_date, apt_time, serv_duration, sched_status, tblPatient.ptn_id
FROM tblAppoint
INNER JOIN tblPatient ON tblAppoint.ptn_id = tblPatient.ptn_id
INNER JOIN tblService ON tblAppoint.serv_id = tblService.serv_id
WHERE tblAppoint.doc_id = ?";

// Check if a search term is provided
if (isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['criteria']) && !empty($_GET['criteria'])) {
$search = $_GET['search'];
$criteria = $_GET['criteria'];
$sql .= " AND $criteria LIKE '%$search%'";
}


    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute statement
    $stmt->bind_param("i", $doc_id);
    $stmt->execute();

    // Store result
    $result = $stmt->get_result();
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
    <span title="Logout"><a href="logout.php" onclick="return confirmSignOut()"><i id="logout" class="fa fa-sign-out"></i></a></span>
</div>

<div id="patientTable">
    <h2>MY PATIENT LIST</h2>
    <form id="searchFilter" action="" method="get">
    <select name="criteria">
        <option value="apt_id">ID</option>
        <option value="ptn_fname">First Name</option>
        <option value="ptn_lname">Last Name</option>
        <option value="serv_name">Service</option>
        <option value="ptn_contact">Contacts</option>
        <option value="apt_date">Date</option>
        <option value="apt_time">Start Time</option>
        <option value="serv_duration">Duration</option>
        <option value="sched_status">Status</option>
    </select>
    <input type="text" name="search" placeholder="Search..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <input type="submit" value="Search">
    <input type="button" value="Clear" onclick="window.location.href='Patient.php'">
</form>

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
        <?php
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
                echo "<td>";
                echo "<form id='deleteForm' action='' method='post'>";
                echo "<input type='hidden' name='apt_id' value='".$row["apt_id"]."'>";
                echo "<input type='submit' name='delete' value='Delete' onclick='return confirmDelete()'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
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

function confirmDelete() {
    return confirm("Are you sure you want to delete this record?");
}

function confirmSignOut() {
    return confirm("You want to Sign out?");
}
</script>
    
</body>
</html>

<?php
if(isset($_POST['delete'])) {
    $apt_id = $_POST['apt_id'];
    $delete_query = "DELETE tblAppoint, tblPatient FROM tblAppoint
                     INNER JOIN tblPatient ON tblAppoint.ptn_id = tblPatient.ptn_id
                     WHERE tblAppoint.apt_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $apt_id);
    if($delete_stmt->execute()) {
        echo "<script>alert('Record deleted successfully');</script>";
        echo "<script>window.location.href = 'Patient.php';</script>";
    } else {
        echo "<script>alert('Error deleting record');</script>";
    }
    $delete_stmt->close();
}
$conn->close();
?>
