<?php
// Include your database configuration file
include 'config.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $sql = "SELECT lgn_id, user_type, lgn_password FROM tblLogin WHERE lgn_username = ?";

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
        $stmt->bind_result($lgn_id, $user_type, $hashed_password);

        // Fetch result
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables and redirect
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $user_type;

            // Redirect based on user type
            if ($user_type === 'admin') {
                // Redirect to admin account page with admin ID
                header("Location: admin_page/admin_landing_page.php?lgn_id=$lgn_id");
                exit();
            } elseif ($user_type === 'doctor') {
                // Redirect to doctor account page with doctor ID
                header("Location: doc_page/doctor_landing_page.php?lgn_id=$lgn_id");
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
