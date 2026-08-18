<?php
/**
 * BloodFlow - Secure User Login Logic
 * 
 * Implements input sanitization, PDO prepared statements, BCRYPT password verification
 * with transparent legacy plaintext auto-upgrading, session fixation prevention,
 * and role-based routing.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

if (isset($_POST['login_btn'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location='login.php';</script>";
        exit();
    }

    try {
        // Fetch the user record by email using parameterized query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user_data = $stmt->fetch();

        if ($user_data) {
            $authenticated = false;
            $needs_upgrade = false;

            // 1. Verify using BCRYPT
            if (password_verify($password, $user_data['password'])) {
                $authenticated = true;
            } 
            // 2. Fallback to plaintext comparison (specifically for legacy database seed users)
            elseif ($password === $user_data['password']) {
                $authenticated = true;
                $needs_upgrade = true;
            }

            if ($authenticated) {
                // Perform transparent automatic password hashing upgrade if legacy format was detected
                if ($needs_upgrade) {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $upgrade_stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                    $upgrade_stmt->execute([
                        'password' => $hashed_password,
                        'id' => $user_data['id']
                    ]);
                }

                // Mitigate session fixation attacks by regenerating the session identifier
                session_regenerate_id(true);

                // Populate session data securely
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['name'] = $user_data['fullname'] ?? '';
                $_SESSION['user_name'] = $user_data['fullname'] ?? '';
                $_SESSION['user_role'] = $user_data['role'] ?? 'user';
                $_SESSION['donor_type'] = $user_data['donor_type'] ?? 'regular';

                // Route to appropriate dashboard
                if ($_SESSION['user_role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: deshbord.php");
                }
                exit();
            }
        }

        // Generic error alert and redirect
        echo "<script>alert('Invalid Email or Password!'); window.location='login.php';</script>";
        exit();

    } catch (PDOException $e) {
        error_log("Login failed: " . $e->getMessage());
        echo "<script>alert('An internal server error occurred. Please try again later.'); window.location='login.php';</script>";
        exit();
    }
}