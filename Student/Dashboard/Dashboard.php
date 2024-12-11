<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: /Login/login.php"); // Corrected path for redirect
    exit;
}

// Get logged-in user's username
$username = $_SESSION['username'];

// Include the database connection file
include '../koneksi.php'; // Corrected path

// Fetch user information from the database
$sql = "SELECT 
            u.username,
            u.email,
            s.student_id,
            s.prodi,
            s.fullName
        FROM sibatta_user u
        JOIN sibatta_student s ON u.user_id = s.user_id
        WHERE u.username = ?";
$params = array($username);
$stmt = sqlsrv_query($conn, $sql, $params);

// Check for errors
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the user's data
$userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Close the statement
sqlsrv_free_stmt($stmt);

if (!$userData) {
    echo "No data found for the user.";
    exit;
}
?>