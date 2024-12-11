<?php
// Debugging untuk memastikan file koneksi ditemukan
if (!file_exists('koneksi.php')) {
    die("File koneksi.php tidak ditemukan di path: " . realpath('koneksi.php'));
}

// Memasukkan koneksi ke database
include 'koneksi.php'; // Sesuaikan path relatif ke lokasi koneksi.php

// Validasi koneksi
if (!$conn_sqlserver) {
    die("Koneksi ke SQL Server gagal: " . print_r(sqlsrv_errors(), true));
}

// Query data Student
$nim = 2341720289; // NIM Student yang akan diambil
$sql = "SELECT nama, prodi, program, semester FROM Student WHERE nim = ?";
$params = array($nim);
$stmt = sqlsrv_query($conn_sqlserver, $sql, $params);

if ($stmt === false) {
    die("Error saat menjalankan query: " . print_r(sqlsrv_errors(), true));
}

$Student = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siforbeta General</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column" style="background-color: #eee9da;">
        <div class="row flex-grow-1">
            <!-- Sidebar -->
            <div class="col-lg-2 bg-primary text-white p-4">
                <h3>siforbeta.</h3>
                <img src="polinema.png" alt="Polinema Logo" style="width: 125px;" class="my-3">
                <nav class="nav flex-column">
                    <a href="/Student/Dashboard/beranda.html" class="nav-link text-white mb-2">Dashboard</a>
                    <a href="/Student/General/General.html" class="nav-link text-white mb-2">General</a>
                    <a href="/Student/Academic/Academic.html" class="nav-link text-white mb-2">Academic</a>
                    <a href="/Student/UKT/UKT.html" class="nav-link text-white mb-2">UKT</a>
                    <a href="/Student/Final Level/FL.html" class="nav-link text-white mb-2">Final Level</a>
                    <a href="/Logout/logout.html" class="nav-link text-white mt-5">Logout</a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10 p-5">
                <div class="welcome-container p-5 rounded shadow-lg">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fw-bold">General</h1>
                            <p class="text-muted">Manage and explore system features through the sections below.</p>
                        </div>
                        <!-- User Avatar -->
                        <img src="user.png" alt="User Avatar" style="width: 100px; border-radius: 50%;">
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <!-- Profile Section -->
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Profile</h5>
                                    <p class="card-text">Nama: <?= $Student['nama'] ?? 'Data tidak ditemukan'; ?></p>
                                    <p class="card-text">Prodi: <?= $Student['prodi'] ?? 'Data tidak ditemukan'; ?></p>
                                    <a href="/Student/General/Profile.php" class="btn btn-primary btn-sm">Go to Profile</a>
                                </div>
                            </div>
                        </div>
                        <!-- Riwayat Status Section -->
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Riwayat Status</h5>
                                    <p class="card-text">Check your academic progress and status history.</p>
                                    <a href="/Student/General/RiwayatStatus.html" class="btn btn-primary btn-sm">View History</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
