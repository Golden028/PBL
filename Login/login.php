<?php
session_start();
include 'db_connection.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT sa.nama, sa.password_hash, r.role_name AS roles 
                FROM SuperAdmin sa
                JOIN roles r ON r.id = sa.nip
                WHERE sa.nama = ?";
        $params = [$username];

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if (hash('sha256', $password) === bin2hex($user['password_hash'])) {
                $_SESSION['username'] = $user['nama'];
                $_SESSION['roles_name'] = $user['roles'];

                if ($user['roles'] == 'SuperAdmin') {
                    header('Location: /SuperAdmin/Dashboard/dashboard.html');
                } elseif ($user['roles'] == 'verifikasi_dokumen') {
                    header('Location: /AdminVerification/Dashboard/beranda.html');
                } else {
                    header('Location: /Student/Dashboard/dashboard.html');
                }
                exit();
            } else {
                $message = "Password salah!";
            }
        } else {
            $message = "Pengguna tidak ditemukan!";
        }
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
