<?php
session_start();

// Initialize error messages
$error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Form validation
    if (empty($username) || empty($password)) {
        $error_message = "Must be filled.";
    } elseif (strlen($password) < 5) {
        $error_message = "Password is at least 5 characters.";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error_message = "Password must consist of letters and numbers.";
    } else {
        // If validation passes, save username and redirect to home
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit;
    }
}
if ($error_message):
    <div class="error-message"><echo $error_message; </div>
endif;
?>