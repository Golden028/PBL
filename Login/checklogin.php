<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Student WHERE nama = ?";
    $params = [$username];
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($user) {
        if (hash('sha256', $password) === bin2hex($user['password'])) {
            $_SESSION['roles'] = $user['roles'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit();
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Pengguna tidak ditemukan!";
    }
}
?>
