<?php
session_start();
include('config.php');

// Security Check: Only Admin can execute these logics
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') { 
    die("Unauthorized Access! Only admin can perform this action."); 
}

// LOGIC 1: Approve User's Blood Request (Section 1)
if(isset($_GET['approve_req_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['approve_req_id']);
    
    // Status update: pending -> approved
    $sql = "UPDATE requests SET status='approved' WHERE id='$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php?msg=approved_success");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// LOGIC 2: Verify Donor's Confirmation (Section 2)
if(isset($_GET['verify_donor_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['verify_donor_id']);
    
    // Status update: accepted -> verified
    // Jokhoni verified hobe, tokhoni oita Section 2 theke sore jabe
    $sql = "UPDATE requests SET status='verified' WHERE id='$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php?msg=donor_verified_success");
        exit();
    } else {
        echo "Error verifying donor: " . mysqli_error($conn);
    }
}
?>