<?php 
session_start(); 
include('config.php'); 

// User login kora na thakle login page-e pathiye dibe
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database theke request-er details fetch kora
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM requests WHERE id='$id'");
    
    if(mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_array($res);
    } else {
        die("Request not found!");
    }
} else {
    header("Location: search.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BloodFlow - Details</title>
    <link rel="stylesheet" href="request_details.css"> 
</head>
<body>

<?php include('navbar.php'); ?>

<div class="details-wrapper">
    <div class="details-box">
        <div class="details-header">
            <span class="status-text">Status: <?php echo ucfirst($data['status']); ?></span>
            <span class="blood-badge"><?php echo $data['blood_group']; ?> REQUIRED</span>
            <h1 style="margin-top: 20px;">Request for <?php echo $data['recipient_name']; ?></h1>
            <p class="location-tag">📍 <?php echo $data['location']; ?></p>
        </div>

        <div class="info-section">
            <div class="recipient-info">
                <h3>Recipient Information</h3>
                <p><strong>Hospital:</strong> <?php echo $data['hospital']; ?></p>
                <p><strong>Date:</strong> <?php echo $data['date']; ?></p>
                <p><strong>Time:</strong> <?php echo $data['time']; ?></p>
            </div>
            <div class="message-info">
                <h3>Requester Message</h3>
                <p class="msg-text">"<?php echo $data['message']; ?>"</p>
            </div>
        </div>

        <!-- Logic: Check if logged-in user is the one who made the request -->
        <div class="action-area">
            <?php if($_SESSION['user_id'] == $data['user_id']): ?>
                <!-- Request creator cannot donate to themselves -->
                <p style="color: #d32f2f; font-weight: bold; background: #ffebee; padding: 10px; border-radius: 5px; display: inline-block;">
                    ⚠️ This is your own request. You cannot commit as a donor here.
                </p>
            <?php else: ?>
                <!-- Show button only for other donors -->
                <button onclick="document.getElementById('modal').style.display='block'" class="donate-now-btn">DONATE NOW</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal: Confirm Donation Form -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h2>Confirm Donation</h2>
        <p style="margin-bottom: 20px; color: #666;">Enter your details to notify the requester.</p>
        
        <form action="confirm_logic.php" method="POST">
            <input type="hidden" name="req_id" value="<?php echo $data['id']; ?>">
            
            <div class="input-group">
                <label>Donor Name</label>
                <input type="text" name="d_name" placeholder="Enter your name" required>
            </div>
            
            <div class="input-group">
                <label>Contact (Phone/Email)</label>
                <input type="text" name="d_contact" placeholder="How to reach you?" required>
            </div>
            
            <button type="submit" name="confirm_btn" class="confirm-commit-btn">Confirm & Commit</button>
            <button type="button" onclick="document.getElementById('modal').style.display='none'" class="cancel-btn">Cancel</button>
        </form>
    </div>
</div>

<script>
window.onclick = function(event) {
    if (event.target == document.getElementById('modal')) {
        document.getElementById('modal').style.display = "none";
    }
}
</script>

<?php include('footer.php'); ?>
</body>
</html>