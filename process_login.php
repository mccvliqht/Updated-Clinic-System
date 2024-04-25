<?php
// Include your database configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];

    // Prepare SQL statement
    $sql = "SELECT lgn_id, lgn_password, user_type FROM tbllogin WHERE lgn_username = ?";

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
        $stmt->bind_result($lgn_id, $lgn_password, $user_type);

        // Fetch result
        $stmt->fetch();

        // Verify password
        if (password_verify($_POST['password'], $lgn_password)) {
            // Password is correct
            // Redirect based on user type
            if ($user_type === 'admin') {
                header("Location: admin_page/admin_landing_page.php"); // Adjusted URL
                exit();
            } elseif ($user_type === 'doctor') {
                header("Location: doc_page/doctor_landing_page.php"); // Adjusted URL
                exit();
            } else {
                // Invalid user type
                echo "Invalid user type.";
                exit();
            }
        } else {
            // Incorrect password
            echo "Incorrect password.";
            exit();
        }
    } else {
        // Username not found
        echo "Username not found.";
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect back to the login page if the form is not submitted
    header("Location: login.php");
    exit();
}
?>
