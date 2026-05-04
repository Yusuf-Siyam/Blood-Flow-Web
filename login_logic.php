<?php
session_start();
include('config.php'); // Database connection include kora

if(isset($_POST['login_btn'])) {
    // Form theke email ar password neya
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Database theke user khuje ber kora
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_array($result);
        
        // Session-e data save kora jate Navbar-e nam show kore
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['user_name'] = $user_data['fullname'];
        $_SESSION['user_role'] = $user_data['role'];

        // Login successful hole Dashboard-e pathiye dewa
        header("Location: deshbord.php");
        exit();
    } else {
        // Jodi email ba password vul hoy
        echo "<script>alert('Invalid Email or Password!'); window.location='login.php';</script>";
    }
}
?>