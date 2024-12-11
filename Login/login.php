<?php
// Start the session
session_start();

// Include the database connection
require 'C:/Users/ASUS/OneDrive/Dokumen/PBL/PBL/koneksi.php';

// Placeholder for message if login fails
$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (!empty($username) && !empty($password)) {
        // Query to check if the user exists and password matches
        $sql = "SELECT u.name, u.password, r.role_name AS roles
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE u.name = ? AND u.password = ?";
        $params = array($username, $password);

        $stmt = sqlsrv_query($conn, $sql, $params);

        // Check if the query executed successfully
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Fetch the user data
        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Set session variables
            $_SESSION['username'] = $user['name'];
            $_SESSION['roles_name'] = $user['roles'];  // Store the role in the session

            // Redirect based on user role
            if ($user['roles'] == 'super admin') {
                header('Location: /Super Admin/Dashboard/dashboard.html'); // Redirect to super admin dashboard
            } elseif ($user['roles'] == 'admin verification') {
                header('Location: /Admin Verification/Dashboard/Dashboard.html'); // Redirect to admin dashboard
            } elseif ($user['roles'] == 'student') {
                header('Location: /Student/Dashboard/beranda.html'); // Redirect to student dashboard
            }
            exit();
        } else {
            // Invalid username or password
            $message = "Invalid username or password!";
        }
    } else {
        $message = "Please fill in all fields!";
    }
}
?>
