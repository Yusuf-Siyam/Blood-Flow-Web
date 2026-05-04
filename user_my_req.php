<?php 
// user_my_req.php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
include('config.php'); 

// User login na thakle login page-e redirect kora hobe
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Requests - BloodFlow</title>
    <!-- CSS file link -->
    <link rel="stylesheet" href="user_my_req.css"> 
</head>
<body>

<?php include('navbar.php'); ?>

<div class="user-req-wrapper">
    <div class="container">
        <h1>User <span>Requests Dashboard</span></h1>
        <p>Manage your blood requests and view donor responses.</p>

        <div class="requests-list">
            <?php 
            // Database query: Logged-in user-er shob request fetch kora
            $query = "SELECT * FROM requests WHERE user_id = '$user_id' ORDER BY id DESC";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) { 
            ?>
                <div class="request-card">
                    <div class="req-header">
                        <h3>Recipient: <?php echo $row['recipient_name']; ?></h3>
                        <span class="blood-type"><?php echo $row['blood_group']; ?></span>
                    </div>
                    
                    <p><strong>Hospital:</strong> <?php echo $row['hospital']; ?></p>
                    <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                    
                    <!-- Status Badge -->
                    <p><strong>Status:</strong> 
                        <span class="badge <?php echo $row['status']; ?>">
                            <?php 
                                // Status ta k ektu shundor bhabe dekhano
                                if($row['status'] == 'verified') echo "Donor Verified";
                                elseif($row['status'] == 'accepted') echo "Waiting for Admin Verification";
                                else echo ucfirst($row['status']); 
                            ?>
                        </span>
                    </p>

                    <!-- NOTIFICATION LOGIC -->
                    
                    <?php if($row['status'] == 'verified'): ?>
                        <!-- Admin verify korar por donor details show korbe -->
                        <div class="donor-notif" style="border-left: 5px solid #28a745; background: #e9f7ef; padding: 15px; border-radius: 5px; margin-top: 15px;">
                            <h4 style="color: #28a745;">✅ Admin Verified Donor Found!</h4>
                            <p><strong>Name:</strong> <?php echo $row['donor_name']; ?></p>
                            <p><strong>Contact:</strong> <span class="phone" style="font-weight: bold; color: #d32f2f;"><?php echo $row['donor_contact']; ?></span></p>
                            <p style="font-size: 13px; color: #555; margin-top: 10px;"><em>You can now safely contact the donor.</em></p>
                        </div>

                    <?php elseif($row['status'] == 'accepted'): ?>
                        <!-- Donor info dise kintu admin ekhono approve kore nai -->
                        <div class="donor-notif" style="border-left: 5px solid #3498db; background: #ebf5fb; padding: 15px; border-radius: 5px; margin-top: 15px;">
                            <h4 style="color: #3498db;">ℹ️ Donor Response Received</h4>
                            <p>A donor has responded to your request. Admin is currently verifying their information. Please check back later.</p>
                        </div>

                    <?php elseif($row['status'] == 'approved'): ?>
                        <!-- Admin approve korse kintu ekhono donor paoa jay nai -->
                        <p style="color: #f39c12; font-size: 14px; margin-top: 10px;">Searching for donors in your area...</p>

                    <?php endif; ?>
                </div>
            <?php 
                }
            } else {
                echo "<p class='empty'>You haven't made any requests yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>