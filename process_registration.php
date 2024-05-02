<?php
// Include your database configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type = $_POST['user-type'];

    // Check if the username already exists
    $check_username_sql = "SELECT lgn_id FROM tblLogin WHERE lgn_username = ?";
    $check_stmt = $conn->prepare($check_username_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        // Username already exists
        echo "Error: Username already exists.";
        exit(); // Stop execution
    }
    
    // Perform basic validation
    if ($password !== $confirm_password) {
        // Passwords do not match
        echo "Error: Passwords do not match.";
        exit(); // Stop execution
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into tbllogin table
    $login_sql = "INSERT INTO tblLogin (lgn_username, lgn_password, user_type) 
                  VALUES (?, ?, ?)";
    $login_stmt = $conn->prepare($login_sql);
    $login_stmt->bind_param("sss", $username, $hashed_password, $user_type);
    if ($login_stmt->execute()) {
        // Retrieve the auto-generated lgn_id
        $login_id = $login_stmt->insert_id;

        // Insert data into tbldoctor or tbladmin table
        if ($user_type === 'admin') {
            // Insert into tbladmin table
            $admin_sql = "INSERT INTO tbladmin (adm_fname, adm_lname, adm_contact, adm_email, lgn_id) 
                          VALUES (?, ?, ?, ?, ?)";
            $admin_stmt = $conn->prepare($admin_sql);
            $admin_stmt->bind_param("ssssi", $first_name, $last_name, $contact, $email, $login_id);
            if (!$admin_stmt->execute()) {
                // Error inserting into tbladmin
                echo "Error: " . $admin_stmt->error;
                exit(); // Stop execution
            }
        } elseif ($user_type === 'doctor') {
            // Insert into tbldoctor table
            $doctor_sql = "INSERT INTO tbldoctor (doc_fname, doc_lname, doc_contact, doc_email, lgn_id) 
                           VALUES (?, ?, ?, ?, ?)";
            $doctor_stmt = $conn->prepare($doctor_sql);
            $doctor_stmt->bind_param("ssssi", $first_name, $last_name, $contact, $email, $login_id);
            if (!$doctor_stmt->execute()) {
                // Error inserting into tbldoctor
                echo "Error: " . $doctor_stmt->error;
                exit(); // Stop execution
            }
        } else {
            // Invalid user type
            echo "Error: Invalid user type.";
            exit(); // Stop execution
        }

        // Success
        // Redirect to login.php after successful account creation
        header("Location: login.php?registration=success");
        exit(); // Ensure script execution stops after redirection
    } else {
        // Error inserting into tbllogin
        echo "Error: " . $login_stmt->error;
        exit(); // Stop execution
    }

    // Close statements and connection
    $check_stmt->close();
    $login_stmt->close();
    if (isset($admin_stmt)) {
        $admin_stmt->close();
    }
    if (isset($doctor_stmt)) {
        $doctor_stmt->close();
    }
    $conn->close();
} else {
    // Redirect back to the registration page if the form is not submitted
    header("Location: create-account.php");
    exit();
}
?>
