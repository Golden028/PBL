<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Verification Student Data</title>
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
                <img src="/Admin Verification/Dashboard/polinema.png" alt="Polinema Logo" style="width: 125px;" class="my-3">
                <nav class="nav flex-column">
                    <a href="/Admin Verification/Dashboard/beranda.html" class="nav-link text-white mb-2">Dashboard</a>
                    <a href="/Admin Verification/Final Level Student/FLS.html" class="nav-link text-white mb-2">Verification</a>
                    <a href="/Admin Verification/History Verification/HV.php" class="nav-link text-white mb-2">History Verification</a>
                    <a href="/Logout/logout.html" class="nav-link text-white mt-5">Logout</a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10 p-5">
                <div class="welcome-container p-5 rounded shadow-lg">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fw-bold">Verification</h1>
                            <p class="text-muted">Please verify the documents uploaded by students.</p>
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
                                        <th>Verification Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Koneksi ke database
                                    $conn = new PDO("sqlsrv:Server=localhost;Database=db_web_pbl", "", "");

                                    // Query untuk mengambil data
                                    $sql = "SELECT nama, nim, prodi, verification_status FROM Student";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Menampilkan data di tabel
                                    if ($results) {
                                        $no = 1;
                                        foreach ($results as $row) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama'] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nim'] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row['prodi'] ?? '') . "</td>";
                                            echo "<td><span class='badge bg-warning text-dark'>" . htmlspecialchars($row['verification_status'] ?? 'Unknown') . "</span></td>";
                                            // Tambahkan tautan untuk halaman detail
                                            echo "<td><a href='/Admin Verification/Final Level Student/FL.html?nim=" . urlencode($row['nim']) . "' class='btn btn-primary btn-sm'>Detail</a></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>