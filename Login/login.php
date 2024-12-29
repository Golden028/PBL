<?php
session_start();
include 'db_connection.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Query untuk SuperAdmin
        $sql = "SELECT sa.nama, sa.password_hash, 'SuperAdmin' AS role 
                FROM SuperAdmin sa 
                WHERE sa.nama = ?";
        $params = [$username];
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (hash('sha256', $password) === bin2hex($user['password_hash'])) {
                $_SESSION['username'] = $user['nama'];
                $_SESSION['roles'] = $user['role'];
                header('Location: /Super Admin/Dashboard/Dashboard.html');
                exit();
            }
        }

        // Query untuk Admin_verification
        $sql = "SELECT av.admin_username AS nama, av.admin_password_hash AS password_hash, 'Admin_verification' AS role 
                FROM Admin_verification av 
                WHERE av.admin_username = ?";
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (hash('sha256', $password) === bin2hex($user['password_hash'])) {
                $_SESSION['username'] = $user['nama'];
                $_SESSION['roles'] = $user['role'];
                header('Location: /Admin Verification/Dashboard/beranda.html');
                exit();
            }
        }

        // Query untuk Student
        $sql = "SELECT s.nama, s.password_hash, 'Student' AS role 
                FROM Student s 
                WHERE s.nama = ?";
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (hash('sha256', $password) === bin2hex($user['password_hash'])) {
                $_SESSION['username'] = $user['nama'];
                $_SESSION['roles'] = $user['role'];
                header('Location: /Student/Dashboard/Dashboard.html');
                exit();
            }
        }

        // Jika tidak ditemukan
        $message = "Pengguna tidak ditemukan atau password salah!";
    } else {
        $message = "Isi semua kolom!";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
<?php if (!empty($message)): ?>
    <p><?= $message ?></p>
<?php endif; ?>
</body>
</html>
