<?php 
session_start();
include('config.php');
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background: #fff; }
        .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .admin-table th { background-color: #f8f9fa; color: #d32f2f; }
        .btn-verify { background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="admin-wrapper" style="padding: 30px;">
    <h1>Admin <span>Dashboard</span></h1>

    <!-- SECTION 1: New Blood Requests -->
    <h3>1. New Blood Requests (Status: Pending)</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Recipient</th>
                <th>Group</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Shudhu pending requests
            $res1 = mysqli_query($conn, "SELECT * FROM requests WHERE status='pending'");
            if(mysqli_num_rows($res1) > 0) {
                while($r = mysqli_fetch_array($res1)) {
                    echo "<tr>
                            <td>$r[recipient_name]</td>
                            <td>$r[blood_group]</td>
                            <td><a href='admin_logic.php?approve_req_id=$r[id]' style='background:green; color:white; padding:6px 12px; text-decoration:none; border-radius:4px;'>Approve Request</a></td>
                          </tr>";
                }
            } else { echo "<tr><td colspan='3'>No new requests.</td></tr>"; }
            ?>
        </tbody>
    </table>

    <!-- SECTION 2: Donor Confirmations (Force Check) -->
    <h3>2. Donor Confirmations (Need Verification)</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Donor Name</th>
                <th>For Recipient</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            /* FORCE QUERY: Jader donor_name ache kintu ekhono verified na */
            $res2 = mysqli_query($conn, "SELECT * FROM requests WHERE donor_name IS NOT NULL AND status='accepted'");
            
            if(mysqli_num_rows($res2) > 0) {
                while($d = mysqli_fetch_array($res2)) {
                    echo "<tr>
                            <td>$d[donor_name]</td>
                            <td>$d[recipient_name]</td>
                            <td>$d[donor_contact]</td>
                            <td><a href='admin_logic.php?verify_donor_id=$d[id]' class='btn-verify'>Verify & Notify User</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; color:gray;'>No donor confirmations found in database.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>