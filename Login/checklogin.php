<?php 
session_start(); 
include 'db_connection.php'; 
if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    // Query untuk mencari berdasarkan username
    $query = "SELECT * FROM Student WHERE username = ?"; 
    $params = [$username]; 
    $stmt = sqlsrv_query($conn, $query, $params); 

    if ($stmt === false) { 
        die(print_r(sqlsrv_errors(), true)); 
    } 

    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC); 

    if ($user) { 
        // Mengecek password hash
        if (hash('sha256', $password) === bin2hex($user['password_hash'])) { 
            // Mengatur session untuk user yang login
            $_SESSION['roles'] = $user['roles']; 
            $_SESSION['name'] = $user['nama']; 
            $_SESSION['username'] = $user['username']; 

            // Pengalihan sesuai dengan role
            if ($user['roles'] == 'Student') {
                header("Location: student_dashboard.php");
            } elseif ($user['roles'] == 'SuperAdmin') {
                header("Location: /Super Admin/Dashboard/beranda.php");
            } elseif ($user['roles'] == 'Admin_verification') {
                header("Location:Admin%20Verification/Dashboard/beranda.html");
            } else {
                echo "Role tidak dikenal!";
            }
            exit(); 
        } else { 
            echo "Password salah!"; 
        } 
    } else { 
        echo "Pengguna tidak ditemukan!"; 
    } 
}
?>
