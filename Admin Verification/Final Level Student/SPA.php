<?php
// Koneksi ke database
include('db_connection.php'); // Pastikan file db_connection.php ada dan berisi koneksi ke database

// Mengecek koneksi database
if (!$conn) {
    die("Connection failed: " . sqlsrv_errors());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $rejection_reason = $_POST['rejection_reason'] ?? null;

    // Mengupdate status berdasarkan aksi yang diterima
    if ($action === 'accept') {
        // Update status ke Verified
        $query = "UPDATE uploaded_files SET verification_status = 'Verified', rejection_reason = NULL WHERE id = ?";
        $params = [$id];
    } elseif ($action === 'reject') {
        // Update status ke Rejected dan tambahkan alasan penolakan
        $query = "UPDATE uploaded_files SET verification_status = 'Rejected', rejection_reason = ? WHERE id = ?";
        $params = [$rejection_reason, $id];
    }

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query, $params);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
    }
}

// Ambil data dari database, termasuk nama mahasiswa dan file names dari tabel verifikasi_dokumen
$query = "
    SELECT s.nama AS student_name, s.nim, v.tanda_terima, v.pkl_laporan, v.bebas_kompen, v.scan_toeic, uf.verification_status, uf.id
    FROM verifikasi_dokumen v
    LEFT JOIN Student s ON v.nim = s.nim
    LEFT JOIN uploaded_files uf ON uf.nim = s.nim
";
$result = sqlsrv_query($conn, $query);

if (!$result) {
    die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Sidebar */
        .bg-primary {
            background-color: #295f98 !important;
        }

        /* Container */
        .verification-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Table */
        .table-bordered {
            border: 1px solid #ddd;
        }

        .table th, .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Form Input */
        .form-control-sm {
            display: inline-block;
            width: auto;
            max-width: 200px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* Pemisah pada file name */
        .file-name {
            text-align: left;
            padding-left: 25px;
        }

        .file-name ul {
            list-style-type: none;
            padding-left: 0;
        }

        .file-name li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 5px;
        }

        .file-name li:before {
            content: "\2022";
            position: absolute;
            left: 0;
            top: 0;
            font-size: 20px;
            color: #000;
        }

        .file-link {
            text-align: left;
            padding-left: 25px;
            vertical-align: middle;
        }

        .file-link a {
            display: inline-block;
            margin-bottom: 5px;
        }

        .file-name, .file-link {
            width: 25%;
        }

        @media (max-width: 768px) {
            .table th, .table td {
                padding: 8px;
            }

            .file-name, .file-link {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column" style="background-color: #eee9da;">
        <div class="row flex-grow-1">
            <!-- Sidebar -->
            <div class="col-lg-2 bg-primary text-white p-4">
                <h3>siforbeta.</h3>
                <img src="/Admin Verification/Dashboard/polinema.png" alt="Polinema Logo" style="width: 125px;" class="my-3">
                <nav class="nav flex-column">
                    <a href="/Admin Verification/Dashboard/beranda.html" class="nav-link text-white mb-2">Dashboard</a>
                    <a href="/Admin Verification/Final Level Student/FLS.php" class="nav-link text-white mb-2">Verification</a>
                    <a href="/Admin Verification/History Verification/HV.php" class="nav-link text-white mb-2">History Verification</a>
                    <a href="/Logout/logout.html" class="nav-link text-white mt-5">Logout</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 p-5">
                <div class="verification-container p-5 rounded shadow-lg">
                    <h1 class="fw-bold">Verification Page</h1>
                    <hr>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>File Name</th>
                                <th>File Link</th>
                                <th>Verification Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['student_name'] ?? 'No Name') ?></td>
                                    <td><?= htmlspecialchars($row['nim'] ?? 'No NIM') ?></td>
                                    <td class="file-name">
                                        <ul>
                                            <?php
                                            // Daftar file sesuai dengan kolom dalam tabel verifikasi_dokumen
                                            $files = [];
                                            if (!empty($row['tanda_terima'])) $files[] = "Tanda Terima";
                                            if (!empty($row['pkl_laporan'])) $files[] = "PKL Laporan";
                                            if (!empty($row['bebas_kompen'])) $files[] = "Bebas Kompen";
                                            if (!empty($row['scan_toeic'])) $files[] = "Scan TOEIC";

                                            foreach ($files as $file) {
                                                echo "<li>$file</li>"; // Menampilkan lingkaran sebagai pemisah
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <td class="file-link">
                                        <?php if (!empty($row['tanda_terima'])): ?>
                                            <a href="<?= htmlspecialchars($row['tanda_terima']) ?>" class="btn btn-primary btn-sm" download>Download</a><br>
                                        <?php endif; ?>
                                        <?php if (!empty($row['pkl_laporan'])): ?>
                                            <a href="<?= htmlspecialchars($row['pkl_laporan']) ?>" class="btn btn-primary btn-sm" download>Download</a><br>
                                        <?php endif; ?>
                                        <?php if (!empty($row['bebas_kompen'])): ?>
                                            <a href="<?= htmlspecialchars($row['bebas_kompen']) ?>" class="btn btn-primary btn-sm" download>Download</a><br>
                                        <?php endif; ?>
                                        <?php if (!empty($row['scan_toeic'])): ?>
                                            <a href="<?= htmlspecialchars($row['scan_toeic']) ?>" class="btn btn-primary btn-sm" download>Download</a><br>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['verification_status'] ?? 'Pending') ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <!-- Accept Button -->
                                            <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to accept this file?');">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'] ?? '') ?>">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                            </form>
                                            
                                            <!-- Reject Button -->
                                            <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to reject this file?');">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'] ?? '') ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
