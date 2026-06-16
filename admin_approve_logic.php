<?php
session_start();
include('config.php');

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$request_id = isset($_GET['request_id']) ? (int) $_GET['request_id'] : 0;
$action = $_GET['action'] ?? '';

if($request_id <= 0 || ($action !== 'approve' && $action !== 'reject')) {
    header('Location: admin_dashboard.php');
    exit();
}

$req_q = mysqli_query($conn, "SELECT id, blood_group, donor_id FROM requests WHERE id = $request_id LIMIT 1");
if(!$req_q || mysqli_num_rows($req_q) === 0) {
    echo "<script>alert('Request not found.'); window.location='admin_dashboard.php';</script>";
    exit();
}

$req = mysqli_fetch_assoc($req_q);
$requested_group = $req['blood_group'];
$donor_id = (int)($req['donor_id'] ?? 0);
$donor_group = '';

if($donor_id > 0) {
    $donor_q = mysqli_query($conn, "SELECT blood_group FROM users WHERE id = $donor_id LIMIT 1");
    if($donor_q && mysqli_num_rows($donor_q) > 0) {
        $donor_row = mysqli_fetch_assoc($donor_q);
        $donor_group = $donor_row['blood_group'];
    }
}

if($action === 'approve') {
    if($donor_group !== '' && $donor_group === $requested_group) {
        mysqli_query($conn, "UPDATE requests SET status='approved' WHERE id = $request_id");
        echo "<script>alert('Request approved successfully.'); window.location='admin_dashboard.php';</script>";
        exit();
    }

    echo "<script>alert('Blood group mismatch. Please reject or review manually.'); window.location='admin_dashboard.php';</script>";
    exit();
}

if($action === 'reject') {
    mysqli_query($conn, "UPDATE requests SET status='rejected', donor_name=NULL, donor_contact=NULL WHERE id = $request_id");
    echo "<script>alert('Request rejected and cleared.'); window.location='admin_dashboard.php';</script>";
    exit();
}

header('Location: admin_dashboard.php');
exit();
?>