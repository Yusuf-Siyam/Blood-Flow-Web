<?php
session_start();
include('config.php');

if(isset($_POST['register_btn'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = $_POST['role'];
    $nid_number = mysqli_real_escape_string($conn, $_POST['nid_number']);
    $blood_group = $_POST['blood_group'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (fullname, email, role, nid_number, blood_group, password) 
              VALUES ('$fullname', '$email', '$role', '$nid_number', '$blood_group', '$password')";

    if(mysqli_query($conn, $query)) {
        // Auto-login bondho korar jonno nicher line-ta comment out ba delete koro:
        // $_SESSION['user_name'] = $fullname; 

        // Direct login na hoye login page-e pathiye dao
        header("Location: login.php?msg=Registration Successful! Please Login.");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>