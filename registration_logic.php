<?php
/**
 * BloodFlow - Secure User Registration Logic
 * 
 * Implements input validation, email syntax & uniqueness checks, NID length limits,
 * BCRYPT password hashing, and secure parameterized PDO inserts.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

if (isset($_POST['register_btn'])) {
    // 1. Sanitize and Trim Inputs
    $name        = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email       = isset($_POST['email']) ? trim($_POST['email']) : '';
    $user_role   = isset($_POST['role']) ? trim($_POST['role']) : 'user';
    $donor_type  = isset($_POST['donor_type']) ? trim($_POST['donor_type']) : 'regular';
    $nid_number  = isset($_POST['nid_number']) ? trim($_POST['nid_number']) : '';
    $blood_group = isset($_POST['blood_group']) ? trim($_POST['blood_group']) : '';
    $password    = isset($_POST['password']) ? $_POST['password'] : '';

    // 2. Validate Inputs
    $errors = [];

    if (empty($name) || strlen($name) > 100) {
        $errors[] = "Full name is required and must be under 100 characters.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $errors[] = "A valid email address is required and must be under 100 characters.";
    }

    $valid_roles = ['user', 'donor', 'admin'];
    if (!in_array($user_role, $valid_roles)) {
        $user_role = 'user';
    }

    if ($user_role !== 'donor') {
        $donor_type = 'regular';
    } else {
        $valid_donor_types = ['regular', 'fixed'];
        if (!in_array($donor_type, $valid_donor_types)) {
            $donor_type = 'regular';
        }
    }

    if (empty($nid_number) || strlen($nid_number) > 20) {
        $errors[] = "NID number is required and must be under 20 characters.";
    }

    $valid_blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    if (empty($blood_group) || !in_array($blood_group, $valid_blood_groups)) {
        $errors[] = "Please select a valid blood group.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (!empty($errors)) {
        $error_msg = implode("\\n", $errors);
        echo "<script>alert('{$error_msg}'); window.history.back();</script>";
        exit();
    }

    try {
        // 3. Check for Duplicate Email (to prevent unique constraint database crash)
        $stmt_email = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $stmt_email->execute(['email' => $email]);
        if ($stmt_email->fetch()) {
            echo "<script>alert('Email is already registered!'); window.history.back();</script>";
            exit();
        }

        // 4. Check for Column Compatibility dynamically
        $has_donor_type = false;
        $col_check = $pdo->query("SHOW COLUMNS FROM users LIKE 'donor_type'");
        if ($col_check && $col_check->rowCount() > 0) {
            $has_donor_type = true;
        }

        // 5. Secure Hash Password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // 6. Parameterized Insert Query
        if ($has_donor_type) {
            $stmt = $pdo->prepare("INSERT INTO users (fullname, email, role, donor_type, nid_number, blood_group, password) 
                                   VALUES (:name, :email, :role, :donor_type, :nid_number, :blood_group, :password)");
            $params = [
                'name'        => $name,
                'email'       => $email,
                'role'        => $user_role,
                'donor_type'  => $donor_type,
                'nid_number'  => $nid_number,
                'blood_group' => $blood_group,
                'password'    => $hashed_password
            ];
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (fullname, email, role, nid_number, blood_group, password) 
                                   VALUES (:name, :email, :role, :nid_number, :blood_group, :password)");
            $params = [
                'name'        => $name,
                'email'       => $email,
                'role'        => $user_role,
                'nid_number'  => $nid_number,
                'blood_group' => $blood_group,
                'password'    => $hashed_password
            ];
        }

        if ($stmt->execute($params)) {
            header("Location: login.php?msg=" . urlencode("Registration Successful! Please Login."));
            exit();
        } else {
            echo "<script>alert('Failed to register user. Please try again.'); window.history.back();</script>";
            exit();
        }
    } catch (PDOException $e) {
        error_log("Registration failed: " . $e->getMessage());
        echo "<script>alert('An internal server error occurred. Please try again later.'); window.history.back();</script>";
        exit();
    }
}