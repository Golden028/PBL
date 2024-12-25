<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Verification Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/Super Admin/Dashboard/style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column" style="background-color: #eee9da;">
        <div class="row flex-grow-1">
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
                    <div class="d-flex justify-content-between align-items-center" style="background-color: #fff;">
                        <div>
                            <h1 class="fw-bold">General Student</h1>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                       <!-- Riwayat Status Table -->
<div class="mt-10">
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Student Name</th>
                <th>NIM</th>
                <th>Program</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Koneksi ke database
            $serverName = "localhost"; // Ubah sesuai dengan nama server Anda
            $connectionInfo = array(
                "Database" => "db_web_pbl",
                "UID" => "", // Kosongkan jika menggunakan Windows Authentication
                "PWD" => "", // Kosongkan jika menggunakan Windows Authentication
                "TrustServerCertificate" => true
            );

            $conn = sqlsrv_connect($serverName, $connectionInfo);

            if ($conn === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // Query untuk mengambil data mahasiswa
            $query = "SELECT nim, nama, program FROM Student";
            $stmt = sqlsrv_query($conn, $query);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // Menampilkan data dalam tabel
            $no = 1;
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$no}</td>";
                echo "<td>{$row['nama']}</td>";
                echo "<td>{$row['nim']}</td>";
                echo "<td>{$row['program']}</td>";
                echo "<td><a href='GS-Profile.html?nim={$row['nim']}' class='btn btn-primary'>Detail</a></td>";
                echo "</tr>";
                $no++;
            }

            // Menutup koneksi
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conn);
            ?>
        </tbody>
    </table>
</div>
