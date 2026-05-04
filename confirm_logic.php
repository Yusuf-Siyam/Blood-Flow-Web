<?php
session_start();
include('config.php');

// Backend Security: Login check
if(!isset($_SESSION['user_id'])) {
    die("Unauthorized! Please login first to commit a donation.");
}

if(isset($_POST['confirm_btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['req_id']);
    $name = mysqli_real_escape_string($conn, $_POST['d_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['d_contact']);
    $donor_id = $_SESSION['user_id'];

    // Double-check: Requester jeno donor na hoy
    $check_query = mysqli_query($conn, "SELECT user_id FROM requests WHERE id='$id'");
    $req_data = mysqli_fetch_array($check_query);

    if($req_data['user_id'] == $donor_id) {
        die("Action Denied: You cannot donate to your own request!");
    }

    // Update status to 'accepted' with donor details
    $query = "UPDATE requests SET donor_name='$name', donor_contact='$contact', status='accepted' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Confirmation Sent! Admin will verify your info.'); window.location='search.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>