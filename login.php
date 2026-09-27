<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'ai_nexus';
$username = 'root';
$password = '';

// Error reporting (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Connect to database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Check for admin credentials
    if ($username === 'admin' && $password === 'admin') {
        // Start a session
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'admin';
        $_SESSION['is_admin'] = true;
        
        // Remember me functionality
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 30);
            
            // Store the token in the database
            $stmt = $conn->prepare("UPDATE users SET remember_token = :token, token_expiry = :expiry WHERE username = 'admin'");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->execute();
            
            // Set the cookie
            setcookie('remember_token', $token, time() + 60 * 60 * 24 * 30, '/', null, false, true);
        }

        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid credentials
        header("Location: login.htm?error=invalid_credentials");
        exit();
    }
} catch(PDOException $e) {
    error_log($e->getMessage());
    header("Location: login.htm?error=server_error");
    exit();
}

// Close the connection
$conn = null;
?>