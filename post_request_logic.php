<?php
session_start();
include('config.php');

if(isset($_POST['post_request_btn'])) {
    // Current logged in user ID
    $user_id = $_SESSION['user_id'];
    
    // Sanitize and get form data
    $recipient_name = mysqli_real_escape_string($conn, $_POST['recipient_name']);
    $blood_group = $_POST['blood_group'];
    $hospital = mysqli_real_escape_string($conn, $_POST['hospital']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // SQL to insert data into requests table
    $query = "INSERT INTO requests (user_id, recipient_name, blood_group, hospital, location, date, time, message, status) 
              VALUES ('$user_id', '$recipient_name', '$blood_group', '$hospital', '$location', '$date', '$time', '$message', 'pending')";

    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Blood Request Posted Successfully!'); window.location='deshbord.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>