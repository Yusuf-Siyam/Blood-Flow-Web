<?php
/**
 * BloodFlow - Database Configuration
 * 
 * Secure database connection setup using PHP PDO and mysqli (for backward compatibility).
 * Environment variables are supported via an internal lightweight .env file parser.
 */

// Define directory path for the .env file
$envPath = __DIR__ . '/.env';

// Lightweight pure PHP helper to parse a .env file and populate environment variables
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Skip comments and empty lines
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }

        // Split by the first '=' character
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            list($key, $value) = $parts;
            $key = trim($key);
            $value = trim($value);

            // Strip enclosing quotes (double or single)
            if (preg_match('/^"(.*)"$/', $value, $matches) || preg_match('/^\'(.*)\'$/', $value, $matches)) {
                $value = $matches[1];
            }

            // Only set if not already set by the environment/system
            if (getenv($key) === false) {
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}

// Retrieve database credentials with defaults
$host    = getenv('DB_HOST') ?: 'localhost';
$port    = getenv('DB_PORT') ?: '3306';
$user    = getenv('DB_USER') ?: 'root';
$pass    = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$db_name = getenv('DB_NAME') ?: 'blood_flow';

try {
    // 1. Establish PDO Connection (Recommended for modern code and prepared statements)
    $dsn = "mysql:host={$host};port={$port};dbname={$db_name};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // Ensures native prepared statements
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Log the error internally and output a user-friendly error to prevent credential disclosure
    error_log("PDO Connection failed: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}

// 2. Establish mysqli Connection (Strictly for backward compatibility with existing project files)
$conn = mysqli_init();
if (!$conn) {
    error_log("mysqli_init failed");
    die("A database error occurred. Please try again later.");
}

// Set connection timeout and establish connection
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 5);
if (!@mysqli_real_connect($conn, $host, $user, $pass, $db_name, (int)$port)) {
    error_log("mysqli Connection failed: " . mysqli_connect_error());
    die("A database error occurred. Please try again later.");
}

// Enforce modern UTF-8 encoding for mysqli as well
mysqli_set_charset($conn, 'utf8mb4');