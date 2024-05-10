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

// Include your database configuration file
include '../config.php'; 

$firstName = '';
$lastName = '';
$username = '';
$email = '';
$contact = '';
$specialization = '';
$birthdate = '';

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare SQL statement to fetch account details
    $sql = "SELECT doc_fname, doc_lname, doc_email, doc_contact, doc_spec, doc_birthdate, lgn_username
        FROM tbldoctor
        INNER JOIN tblLogin ON tbldoctor.lgn_id = tblLogin.lgn_id
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
      $stmt->bind_result($doc_fname, $doc_lname, $doc_email, $doc_contact, $doc_spec, $doc_birthdate, $lgn_username);

      // Fetch result
      $stmt->fetch();

      // Assign fetched values to variables
      $firstName = $doc_fname;
      $lastName = $doc_lname;
      $email = $doc_email;
      $contact = $doc_contact;
      $username = $lgn_username;
      $specialization = $doc_spec;
      $birthdate = $doc_birthdate;

    }

    // Predefined dark colors
    $darkColors = [
      '#2c3e50', // Dark blue
      '#34495e', // Dark blue-gray
      '#1f3a93', // Dark royal blue
      '#273c75', // Dark blue
      '#192a56', // Dark navy blue
      '#2c3e50', // Dark blue
      '#2e86de', // Dark cerulean blue
      '#006266', // Dark teal blue
      '#3b3b98', // Dark indigo blue
      '#2d3436', // Dark grayish blue
      '#7f8c8d', // Dark gray
    ];

    // Randomly select a dark color
    $randomColor = $darkColors[array_rand($darkColors)];
}

$stmt->close(); 

if(isset($_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['contact'], $_POST['specialization'], $_POST['birthdate'])) {
    $oldUsername = $_SESSION['username'];
    $newUsername = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $specialization = $_POST['specialization'];
    $birthdate = $_POST['birthdate'];


    // Start a transaction
    $conn->begin_transaction();

    try {
        // Prepare SQL statement to update account details in tblAdmin
        $sqlAdmin = "UPDATE tbldoctor 
                     INNER JOIN tblLogin ON tbldoctor.lgn_id = tblLogin.lgn_id 
                     SET doc_fname = ?, doc_lname = ?, doc_email = ?, doc_contact = ?, doc_spec = ?, doc_birthdate = ?, tblLogin.lgn_username = ?
                     WHERE tblLogin.lgn_username = ?";

        // Prepare the SQL statement for updating admin details
        $stmtAdmin = $conn->prepare($sqlAdmin);

        if (!$stmtAdmin) {
            throw new Exception("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        // Bind parameters and execute statement
        $stmtAdmin->bind_param("ssssssss", $firstName, $lastName, $email, $contact, $specialization, $birthdate, $newUsername, $oldUsername);
        if (!$stmtAdmin->execute()) {
            throw new Exception("Execute failed: (" . $stmtAdmin->errno . ") " . $stmtAdmin->error);
        }

        if ($stmtAdmin->affected_rows <= 0) {
            throw new Exception("No rows affected");
        }

        $stmtAdmin->close();

        // Update session variables with new details
        $_SESSION['username'] = $newUsername;

        // Commit the transaction
        $conn->commit();

        // Redirect to prevent form resubmission
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        // Handle error - Display error message or log it for debugging
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home</title>
  
    <link rel="stylesheet" href="try.css?v=<?php echo time(); ?>">
    <link rel="icon" href="LogoClinic.png" type="image/png">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<span id="BarsNav" style="font-size:30px;cursor:pointer" onclick="openNav()"><i class="fa fa-bars"></i></span>

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

<div class="content">
    <div class="profile-container">
      <div class="profile-letter" style="background-color: <?php echo $randomColor; ?>">
        <?php echo $firstName ? strtoupper(substr($firstName, 0, 1)) : ''; ?>
      </div>
      <div class="admin-details">
        <div class="admin-name">
          <?php echo $firstName . ' ' . $lastName; ?>
        </div>
        <div class="admin-email">
          <?php echo $email; ?>
        </div>
      </div>
    </div>
    <div class="edit-account-details">
      <div class="account-section">
        <h2>Account Details</h2>
        <hr>
        <form id="editAccountForm" action="" method="post">
          <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" class="edit-input" readonly>
          </div>
          <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>" class="edit-input" readonly>
          </div>
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" class="edit-input" readonly>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="edit-input" readonly>
          </div>
          <div class="form-group contact">
            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" class="edit-input" readonly>
          </div>
          <div class="form-group">
            <label for="specialization">Specialization:</label>
            <input type="text" id="specialization" name="specialization" value="<?php echo htmlspecialchars($specialization); ?>" class="edit-input" readonly>
          </div>
          <div class="form-group">
            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" class="edit-input" readonly>
          </div>
          <div class="button-group">
            <button type="button" id="editBtn">Edit Details</button>
            <button type="submit" id="saveBtn" style="display: none;">Save Changes</button>
          </div>
        </form>
      </div>
      <div class="pass-account-section">
        <h2>Change Password</h2>
        <hr>
        <form id="changePasswordForm" action="" method="post">
          <div class="form-group">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" class="edit-input" required>
          </div>
          <div class="form-group">
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" class="edit-input" required>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="edit-input" required>
          </div>
          <div class="button-group">
            <button type="submit" id="changePasswordBtn">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
  // Function to enable editing of input fields
  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


  function enableEdit() {
    document.querySelectorAll('.edit-input').forEach(function(input) {
      input.removeAttribute('readonly');
    });
    document.getElementById('editBtn').style.display = 'none';
    document.getElementById('saveBtn').style.display = 'inline-block';
  }

  document.getElementById('editBtn').addEventListener('click', enableEdit);

  // Function to prevent form resubmission on page reload
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }


</script>
</body>
</html>
