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

    // Perform basic validation
    if ($password !== $confirm_password) {
        // Passwords do not match
        echo "Error: Passwords do not match.";
        exit(); // Stop execution
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into tbllogin table
    $login_sql = "INSERT INTO tbllogin (lgn_username, lgn_password, user_type) 
                  VALUES ('$username', '$hashed_password', '$user_type')";
    if ($conn->query($login_sql) !== TRUE) {
        // Error inserting into tbllogin
        echo "Error: " . $login_sql . "<br>" . $conn->error;
        exit(); // Stop execution
    }

    // Retrieve the auto-generated lgn_id
    $login_id = $conn->insert_id;

    // Insert data into tbldoctor or tbladmin table
    if ($user_type === 'admin') {
        // Insert into tbladmin table
        $admin_sql = "INSERT INTO tbladmin (adm_fname, adm_lname, adm_contact, adm_email, lgn_id) 
                      VALUES ('$first_name', '$last_name', '$contact', '$email', '$login_id')";
        if ($conn->query($admin_sql) !== TRUE) {
            // Error inserting into tbladmin
            echo "Error: " . $admin_sql . "<br>" . $conn->error;
            // Rollback insertion into tbllogin
            $conn->query("DELETE FROM tbllogin WHERE lgn_id = $login_id");
            exit(); // Stop execution
        }
    } elseif ($user_type === 'doctor') {
        // Insert into tbldoctor table
        $doctor_sql = "INSERT INTO tbldoctor (doc_fname, doc_lname, doc_contact, doc_email, lgn_id) 
                       VALUES ('$first_name', '$last_name', '$contact', '$email', '$login_id')";
        if ($conn->query($doctor_sql) !== TRUE) {
            // Error inserting into tbldoctor
            echo "Error: " . $doctor_sql . "<br>" . $conn->error;
            // Rollback insertion into tbllogin
            $conn->query("DELETE FROM tbllogin WHERE lgn_id = $login_id");
            exit(); // Stop execution
        }
    } else {
        // Invalid user type
        echo "Error: Invalid user type.";
        // Rollback insertion into tbllogin
        $conn->query("DELETE FROM tbllogin WHERE lgn_id = $login_id");
        exit(); // Stop execution
    }

    // Success
    // Redirect to login.php after successful account creation
    header("Location: login.php?registration=success");
    exit(); // Ensure script execution stops after redirection
} else {
    // Redirect back to the registration page if the form is not submitted
    header("Location: registration.html");
    exit();
}
?>
