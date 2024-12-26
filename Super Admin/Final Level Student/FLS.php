<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/Admin Verification/Dashboard/style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column" style="background-color: #eee9da;">
        <div class="row flex-grow-1">
            <!-- Sidebar -->
            <div class="col-lg-2 bg-primary text-white p-4">
                <h3>siforbeta.</h3>
                <img src="polinema.png" alt="Polinema Logo" style="width: 125px;" class="my-3">
                <nav class="nav flex-column">
                    <a href="/Super Admin/Dashboard/dashboard.html" class="nav-link text-white mb-2">Dashboard</a>
                    <a href="/Super Admin/General Student/GS.php" class="nav-link text-white mb-2">General Student</a>
                    <a href="/Super Admin/Final Level Student/FLS.php" class="nav-link text-white mb-2">Final Level Student</a>
                    <a href="/Logout/logout.html" class="nav-link text-white mt-5">Logout</a>
                </nav>
            </div>
            <!-- Main Content -->
            <div class="col-lg-10 p-5">
                <div class="container bg-white p-5 rounded shadow-lg">
                    <h2 class="fw-bold">Verification History</h2>
                    <p class="text-muted">List of student document verification history by study program admin.</p>
                    <hr>

                    <!-- Tabel History -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Dokumen</th>
                                    <th>Status</th>
                                    <th>Tanggal Verifikasi</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Koneksi ke database menggunakan SQLSRV
                                $serverName = "localhost"; // Ganti sesuai nama server SQL Server 
                                $connectionInfo = array(
                                    "Database" => "db_web_pbl",
                                    "UID" => "", // Ganti dengan username SQL Server 
                                    "PWD" => "", // Ganti dengan password SQL Server 
                                );
                                $conn = sqlsrv_connect($serverName, $connectionInfo);

                                // Cek koneksi
                                if ($conn === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }

                                // Query untuk mengambil data
                                $sql = "SELECT nim, tanda_terima AS dokumen, pkl_laporan AS status, bebas_kompen AS tanggal_verifikasi, scan_toeic AS catatan FROM verifikasi_dokumen";
                                $stmt = sqlsrv_query($conn, $sql);

                                if ($stmt === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }

                                // Menampilkan data dalam tabel
                                $i = 1; // Untuk nomor urut
                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row["nim"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["dokumen"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["tanggal_verifikasi"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["catatan"]) . "</td>";
                                    echo "</tr>";
                                }

                                if ($i === 1) { // Tidak ada data
                                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data verifikasi.</td></tr>";
                                }

                                // Tutup koneksi
                                sqlsrv_free_stmt($stmt);
                                sqlsrv_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
