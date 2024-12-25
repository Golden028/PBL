<?php
// Koneksi ke database
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "db_web_pbl", // Nama database
    "Uid" => "", // Username
    "PWD" => "" // Password
);

$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

$nim = $_GET['nim'] ?? '2341720289'; // Default NIM jika tidak ada
$nama = '';
$email = '';

// Cek data mahasiswa berdasarkan NIM
$query = "SELECT nama, email FROM Student WHERE nim = ?";
$params = array($nim);
$stmt = sqlsrv_query($conn, $query, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if ($row) {
    $nama = $row['nama'];
    $email = $row['email'];
}

// Proses update ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    // Cek apakah email sudah digunakan oleh mahasiswa lain
    $checkEmailQuery = "SELECT COUNT(*) AS email_count FROM Student WHERE email = ? AND nim != ?";
    $checkStmt = sqlsrv_query($conn, $checkEmailQuery, array($email, $nim));
    if ($checkStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
    if ($row['email_count'] > 0) {
        $error_message = "Email sudah digunakan oleh mahasiswa lain.";
    } else {
        // Update data mahasiswa di tabel Student
        $updateQuery = "UPDATE Student SET nama = ?, email = ?, updated_at = GETDATE() WHERE nim = ?";
        $params = array($nama, $email, $nim);
        $stmt = sqlsrv_query($conn, $updateQuery, $params);

        if ($stmt === false) {
            $error_message = "Gagal memperbarui data.";
        } else {
            $success_message = "Profil berhasil diperbarui.";
        }
    }
}

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="/Super Admin/Dashboard/style.css">
</head>
<body>
    <div class="container-fluid d-flex">
        <!-- Sidebar -->
        <div class="col-lg-2 bg-primary text-white p-4">
            <h3>siforbeta.</h3>
            <img src="polinema.png" alt="Polinema Logo" style="width: 125px;" class="my-3">
            <nav class="nav flex-column">
                <a href="/Super Admin/Dashboard/Dashboard.html" class="nav-link text-white mb-2">Dashboard</a>
                <a href="/Super Admin/General Student/GS.html" class="nav-link text-white mb-2">General Student</a>
                <a href="/Super Admin/Final Level Student/FLS.php" class="nav-link text-white mb-2">Final Level Student</a>
                <a href="/Logout/logout.html" class="nav-link text-white mt-5">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-lg-10 p-5">
            <div class="welcome-container p-5 rounded shadow-lg">
                <h1 class="fw-bold">Update Student Profile</h1>
                <p class="text-muted">Update your student profile information below.</p>
                <hr>

                <!-- Messages -->
                <?php if (isset($error_message)): ?>
                    <p class="text-danger"><?php echo $error_message; ?></p>
                <?php endif; ?>
                
                <?php if (isset($success_message)): ?>
                    <p class="text-success"><?php echo $success_message; ?></p>
                <?php endif; ?>

                <!-- Form Update -->
                <form action="UPS.php" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>

                <!-- Button Back to Previous Page -->
                <a href="GS.php" class="btn btn-secondary mt-3">Back to General Student</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
