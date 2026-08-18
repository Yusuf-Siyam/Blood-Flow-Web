<?php 
// Ensure session is started if not already
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
$display_name = $_SESSION['name'] ?? ($_SESSION['user_name'] ?? null);
$user_role = $_SESSION['user_role'] ?? null;
?>
<nav class="navbar">
    <div class="logo">BloodFlow</div>
    <ul class="nav-menu">
        <li><a href="deshbord.php">Home</a></li>
        <li><a href="blood_banks_list.php">Blood Bank Inventory</a></li>
        <?php if($display_name): ?>
            <li><a href="request_form.php">Post Request</a></li>
            <li><a href="user_my_req.php">My Requests</a></li>
        <?php endif; ?>
        
        <li><a href="search.php">Donation Requests</a></li>
        <li><a href="vlog.php">Blog</a></li>

        <?php if($user_role === 'donor'): ?>
            <li><a href="thalassemia_alerts.php">Thalassemia Alerts</a></li>
        <?php endif; ?>
    </ul>
    
    <div class="nav-auth">
        <?php if($display_name): ?>
            <?php if($user_role == 'admin'): ?>
                <a href="admin_dashboard.php" class="btn-login" style="color: #86efac; border-color: #86efac; margin-right: 10px;">Admin Panel</a>
            <?php endif; ?>

            <span class="user-welcome">Hi, <?php echo htmlspecialchars($display_name); ?></span>
            <a href="logout.php" class="btn-login">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
            <a href="registration.php" class="btn-join">Join Now</a>
        <?php endif; ?>
    </div>
</nav>