<?php
session_start();

// Dummy user data (replace with database queries in real applications)
$users = [
    'admin' => 'admin123',
    'user' => 'user123'
];

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (array_key_exists($username, $users) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header('Location: /Beranda/beranda.html'); // Redirect to dashboard
        exit();
    } else {
        $error = "Invalid username or password";
        header("Location: index.html?error=" . urlencode($error));
        exit();
    }
}
?>
