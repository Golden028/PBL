<?php
// Check if a session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require 'C:/Users/ASUS/OneDrive/Dokumen/PBL/PBL/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check the user in the database
    $query = "SELECT * FROM Student WHERE username = ? AND password = ?";
    
    // Prepare the statement
    $params = array($username, $password);
    $stmt = sqlsrv_prepare($conn, $query, $params);
    
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Execute the statement
    $result = sqlsrv_execute($stmt);

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch the data
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($user) {
        // Store user information in session
        $_SESSION['roles'] = $user['roles'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['username'] = $user['username'];

        // Redirect based on role
        if ($user['roles'] === 'user') {
            header("Location: Student/Dashboard/dashboard.html");
        } else if ($user['role'] === 'library_admin') {
            header("Location: adminPerpus/mainPerpus.php");
        } else if ($user['role'] === 'academic_admin') {
            header("Location: adminAkademik/mainAkademik.php");
        }
        exit;
    } else {
        // If no user found, return an error
        $message = "Invalid username or password.";
        include '/Login/index.php'; // Show the login page with the error message
    }

    // Free the statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>