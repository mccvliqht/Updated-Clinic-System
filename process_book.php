<?php
// Include your database configuration file
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $last_name = $_POST['last-name'];
    $first_name = $_POST['first-name'];
    $datepicker = $_POST['datepicker'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $service_name = $_POST['service']; // Retrieve service name from the form
    $doctor_name = $_POST['doctor']; // Retrieve doctor name from the form
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Check if the email already exists
    $check_email_sql = "SELECT ptn_id FROM tblpatient WHERE ptn_email = ?";
    $check_stmt = $conn->prepare($check_email_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        // Email already exists
        echo "Error: Email already exists.";
        exit(); // Stop execution
    }

    // Retrieve service ID based on service name
    $service_id_sql = "SELECT serv_id FROM tblservice WHERE serv_name = ?";
    $service_stmt = $conn->prepare($service_id_sql);
    $service_stmt->bind_param("s", $service_name);
    $service_stmt->execute();
    $service_result = $service_stmt->get_result();

    // Check if the query returned any rows
    if ($service_result->num_rows > 0) {
    // Fetch the row and retrieve the service ID
    $service_row = $service_result->fetch_assoc();
    $service_id = $service_row['serv_id'];
    } else {
    // Handle the case where the service name was not found in the database
    // For example, you can display an error message or set a default service ID
    echo "Error: Service not found in the database.";
    exit(); // Stop execution or handle the error appropriately
    }

    // Retrieve doctor ID based on doctor name
    $doctor_id_sql = "SELECT doc_id FROM tbldoctor WHERE doc_lname = ?";
    $doctor_stmt = $conn->prepare($doctor_id_sql);
    $doctor_stmt->bind_param("s", $doctor_name);
    $doctor_stmt->execute();
    $doctor_result = $doctor_stmt->get_result();
    $doctor_row = $doctor_result->fetch_assoc();
    $doctor_id = $doctor_row['doc_id'];

    // Insert data into tblpatient table
    $patient_sql = "INSERT INTO tblpatient (ptn_fname, ptn_lname, ptn_birthdate, ptn_gender, ptn_contact, ptn_email) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $patient_stmt = $conn->prepare($patient_sql);
    $patient_stmt->bind_param("ssssis", $first_name, $last_name, $datepicker, $gender, $contact, $email);
    if ($patient_stmt->execute()) {
        // Retrieve the auto-generated ptn_id
        $patient_id = $patient_stmt->insert_id;

        // Insert into tblappoint table
        $appoint_sql = "INSERT INTO tblappoint (ptn_id, doc_id, serv_id, apt_time, apt_date) 
                      VALUES (?, ?, ?, ?, ?)";
        $appoint_stmt = $conn->prepare($appoint_sql);
        $appoint_stmt->bind_param("iiiss", $patient_id, $doctor_id, $service_id, $time, $date);   
        
        if ($appoint_stmt->execute()) {
            $patient_id = $patient_stmt->insert_id;

            // Retrieve the appointment ID
            $appoint_id_sql = "SELECT apt_id FROM tblappoint WHERE ptn_id = ?";
            $appoint_id_stmt = $conn->prepare($appoint_id_sql);
            $appoint_id_stmt->bind_param("i", $patient_id);
            $appoint_id_stmt->execute();
            $appoint_id_result = $appoint_id_stmt->get_result();
            $appoint_id_row = $appoint_id_result->fetch_assoc();
            $appointment_id = $appoint_id_row['apt_id'];
            // Store necessary data in session variables
            session_start();
            $_SESSION['appointment_details'] = array(
                'appointment_id' => $appointment_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'birthdate' => $datepicker,
                'gender' => $gender,
                'contact' => $contact,
                'email' => $email,
                'service' => $service_name,
                'doctor' => $doctor_name,
                'date' => $date,
                'time' => $time
            );

            // Redirect to confirmation page
            header("Location: book-success.php");
            exit();
        } else {
            echo "Error: " . $appoint_stmt->error;
        }
    
        // Close prepared statements
        $appoint_stmt->close();
        $patient_stmt->close();
    
        // Close database connection
        $conn->close();
    } else {
        echo "Error: " . $patient_stmt->error;
    }
}