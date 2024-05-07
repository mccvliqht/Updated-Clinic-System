<?php
session_start(); // Start the session

// Include your database configuration file
include '../config.php'; 

$firstName = '';
$lastName = '';
$username = '';
$email = '';
$contact = '';

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare SQL statement to fetch account details
    $sql = "SELECT adm_fname, adm_lname, adm_email, adm_contact, lgn_username 
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
        $stmt->bind_result($adm_fname, $adm_lname, $adm_email, $adm_contact, $lgn_username);

        // Fetch result
        $stmt->fetch();

        // Assign fetched values to variables
        $firstName = $adm_fname;
        $lastName = $adm_lname;
        $email = $adm_email;
        $contact = $adm_contact;
        $username = $lgn_username;
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

if(isset($_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['contact'])) {
    $oldUsername = $_SESSION['username'];
    $newUsername = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Prepare SQL statement to update account details in tblAdmin
        $sqlAdmin = "UPDATE tblAdmin 
                     INNER JOIN tblLogin ON tblAdmin.lgn_id = tblLogin.lgn_id 
                     SET adm_fname = ?, adm_lname = ?, adm_email = ?, adm_contact = ?, tblLogin.lgn_username = ?
                     WHERE tblLogin.lgn_username = ?";

        // Prepare the SQL statement for updating admin details
        $stmtAdmin = $conn->prepare($sqlAdmin);

        if (!$stmtAdmin) {
            throw new Exception("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        // Bind parameters and execute statement
        $stmtAdmin->bind_param("ssssss", $firstName, $lastName, $email, $contact, $newUsername, $oldUsername);
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
        <li><a href="admin_landing_page.php"><i class="fa fa-calendar"></i> <span>Calendar</span></a></li>
        <li><a href="doctor.php"><i class="fa fa-stethoscope"></i> <span>Doctor</span></a></li>
        <li><a href="patients.php"><i class="fa fa-user"></i> <span>Patient</span></a></li>
        <li><a href="appointment.php"><i class="fa fa-clipboard"></i> <span>Appointment</span></a></li>
        <li><a href="account_details.php"><i class="fa fa-user-circle-o"></i> <span>Account Details</span></a></li>
    </ul>
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


  <script src="admin_script.js"></script>
</body>
</html>
