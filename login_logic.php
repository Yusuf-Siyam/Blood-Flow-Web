<?php
session_start();
include('config.php');

if(isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Database check: Role fetch kora must
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_array($result);
        
        // Session settings
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['user_name'] = $user_data['fullname'];
        $_SESSION['user_role'] = $user_data['role'];

        // Role-wise redirection logic
        if($_SESSION['user_role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: deshbord.php");
        }
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password!'); window.location='login.php';</script>";
    }
}
?>