<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
?>
<nav class="navbar">
    <div class="logo">BloodFlow</div>
    <ul class="nav-menu">
        <li><a href="deshbord.php">Home</a></li>
        <li><a href="request_form.php">Donation Request</a></li>
        <li><a href="vlog.php">Blog</a></li>
        <li><a href="search.php">Search Request</a></li>
    </ul>
    <div class="nav-auth">
        <?php if(isset($_SESSION['user_name'])): ?>
            <!-- User login korle tar nam show korbe -->
            <span class="user-welcome">Hi, <?php echo $_SESSION['user_name']; ?></span>
            <a href="logout.php" class="btn-login">Logout</a>
        <?php else: ?>
            <!-- User login na thakle Login/Join Now button show korbe -->
            <a href="login.php" class="btn-login">Login</a>
            <a href="registration.php" class="btn-join">Join Now</a>
        <?php endif; ?>
    </div>
</nav>

<style>
/* Navbar basic styling */
.navbar { 
    background: linear-gradient(to right, #2c3e50, #4b79a1); 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    padding: 15px 50px; 
    color: white; 
}
.nav-menu { display: flex; list-style: none; gap: 20px; }
.nav-menu a { color: white; text-decoration: none; font-weight: bold; }
.btn-login { 
    background: rgba(130, 41, 41, 0.1); 
    border: 1px solid white; 
    padding: 5px 15px; 
    color: white; 
    border-radius: 5px; 
    text-decoration: none; 
}
.btn-join { 
    background: #1A1F2C; 
    padding: 5px 15px; 
    color: white; 
    border-radius: 5px; 
    text-decoration: none; 
    margin-left: 10px; 
}
.user-welcome { font-weight: bold; color: #50c878; margin-right: 10px; }
</style>