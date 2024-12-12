<?php
// Koneksi ke SQL Server
$serverName = "DESKTOP-7J8U2B0"; // Nama server SQL Anda
$connectionOptions = array(
    "Database" => "db_web_pbl", // Nama database Anda
    "Uid" => "",  // Username SQL Server
    "PWD" => ""   // Password SQL Server
);

// Membuat koneksi ke database
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Cek koneksi
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
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
                    <a href="/Admin Verification/Dashboard/beranda.html" class="nav-link text-white mb-2">Dashboard</a>
                    <a href="/Admin Verification/Final Level Student/DVS.html" class="nav-link text-white mb-2">Verification</a>
                    <a href="/Admin Verification/History Verification/HV.php" class="nav-link text-white mb-2">History Verification</a>
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
                                    <th>Student Name</th>
                                    <th>Documents</th>
                                    <th>Verification Status</th>
                                    <th>Verification Date</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh server-side PHP -->
                                <?php
                                // Query untuk mengambil data dari verifikasi_dokumen dan bergabung dengan Student untuk mendapatkan nama mahasiswa
                                $sql = "SELECT vd.nim, s.nama, vd.tanda_terima, vd.pkl_laporan, vd.bebas_kompen, vd.scan_toeic, vd.created_at
                                        FROM verifikasi_dokumen vd
                                        INNER JOIN Student s ON vd.nim = s.nim";

                                $stmt = sqlsrv_query($conn, $sql);

                                if ($stmt === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }

                                $counter = 1;

                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $counter++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                    echo "<td>
                                            <ul>
                                                <li>Tanda Terima Penyerahan Laporan TA/Skripsi: <a href='Student/Final Level/uploads" . htmlspecialchars($row['tanda_terima']) . "' target='_blank'>View</a></li>
                                                <li>Tanda Terima Penyerahan Laporan PKL/Magang: <a href='Student/Final Level/uploads" . htmlspecialchars($row['pkl_laporan']) . "' target='_blank'>View</a></li>
                                                <li>Surat Bebas Kompen: <a href='Student\Final Level\uploads" . htmlspecialchars($row['bebas_kompen']) . "' target='_blank'>View</a></li>
                                                <li>Scan TOEIC: <a href='Student/Final Level/uploads" . htmlspecialchars($row['scan_toeic']) . "' target='_blank'>View</a></li>
                                            </ul>
                                        </td>";
                                    echo "<td>" . "Verified" . "</td>"; // Status verifikasi, sesuaikan jika perlu
                                    echo "<td>" . $row['created_at']->format('Y-m-d H:i:s') . "</td>";
                                    echo "<td>" . "No notes" . "</td>"; // Catatan, sesuaikan jika perlu
                                    echo "</tr>";
                                }

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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
