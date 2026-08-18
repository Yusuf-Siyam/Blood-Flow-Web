<?php
/**
 * BloodFlow - Session Verification Middleware
 * 
 * Reusable session verification functions to prevent unauthorized URL access.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Ensures the user is logged in.
 * If not, redirects to the login page.
 */
if (!function_exists('check_logged_in')) {
    function check_logged_in() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php?msg=" . urlencode("Please login to access this page."));
            exit();
        }
    }
}

/**
 * Ensures the logged-in user is an admin.
 * If not, redirects to the user dashboard.
 */
if (!function_exists('check_admin')) {
    function check_admin() {
        check_logged_in();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: deshbord.php?msg=" . urlencode("Unauthorized access."));
            exit();
        }
    }
}
