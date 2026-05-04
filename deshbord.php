<?php 
session_start(); 
include('config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BloodFlow - Dashboard</title>
    <link rel="stylesheet" href="deshbord.css"> 
</head>
<body>

<?php 
// Case-sensitive check for navbar.php
if(file_exists('navbar.php')){
    include('navbar.php'); 
} else {
    echo "<div style='background: #ffcccc; color: #d8000c; padding: 10px; text-align: center; border: 1px solid #d8000c;'>
            <strong>Warning:</strong> navbar.php file ta 'blood_flow' folder-e khuje paoa jachhe na!
          </div>";
}
?>

<!-- Hero Section -->
<section class="hero">
    <h1>Welcome to <span>BloodFlow</span></h1>
    <div class="hero-box">
        <h2>Give Blood, Give Hope</h2>
        <p>A single donation can save multiple lives. Be the reason someone gets a second chance today.</p>
        <div class="hero-btns">
            <a href="registration.php" class="btn-box-red">Join as Donor</a>
            <a href="search.php" class="btn-box-green">Search Donors</a>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="info-grid">
    <h2 class="section-title">Why Support Blood Donation?</h2>
    <div class="cards-container">
        <div class="card">
            <h3>Community Impact</h3>
            <p>Your contribution directly supports local hospitals and emergency medical needs.</p>
        </div>
        <div class="card">
            <h3>Donor Network</h3>
            <p>Join thousands of volunteers committed to making blood donation seamless.</p>
        </div>
        <div class="card">
            <h3>Quick Process</h3>
            <p>Our platform ensures a fast connection between donors and recipients.</p>
        </div>
    </div>
</section>

<!-- Map Section: Real Google Map -->
<section class="visuals">
    <h2 class="map-title">Our Location</h2>
    <div class="map-container">
        <!-- Google Maps Iframe (Real Map) -->
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9022699890664!2d90.4524458!3d23.7508734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087021c81%3A0x19690180a009fb52!2sUnited%20International%20University!5e0!3m2!1sen!2sbd!4v1714770000000!5m2!1sen!2sbd" 
            width="100%" 
            height="450" 
            style="border:0; border-radius: 15px;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        
    </div>
</section>

<?php include('footer.php'); ?>

</body>
</html>