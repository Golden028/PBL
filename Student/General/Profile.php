<?php
// Konfigurasi database
$serverName = "localhost"; // Ganti dengan nama server SQL Server Anda
$dbName = "db_web_pbl";
$username = ""; // Ganti dengan username SQL Server Anda
$password = ""; // Ganti dengan password SQL Server Anda

try {
    // Membuat koneksi ke database
    $conn = new PDO("sqlsrv:server=$serverName;Database=$dbName", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil data mahasiswa berdasarkan NIM
    $nim = 2341720289; // Ganti dengan NIM mahasiswa yang ingin diambil
    $stmt = $conn->prepare("SELECT nama, email, prodi, program, semester FROM Student WHERE nim = :nim");
    $stmt->bindParam(':nim', $nim);
    $stmt->execute();
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$studentData) {
        throw new Exception("Data mahasiswa dengan NIM $nim tidak ditemukan.");
    }
} catch (Exception $e) {
    die("Koneksi atau query gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column bg-light">
        <div class="row flex-grow-1">
            <!-- Sidebar -->
            <div class="col-lg-2 bg-primary text-white p-4 sidebar">
                <h3 class="fw-bold">siforbeta.</h3>
                <img src="polinema.png" alt="Polinema Logo" class="my-3 rounded-circle" style="width: 100px;">
                <nav class="nav flex-column">
                    <a href="/Student/Dashboard/Dashboard.html" class="nav-link text-white mb-2">Dashboard</a>
                    <a href="/Student/General/General.html" class="nav-link text-white mb-2">General</a>
                    <a href="/Student/Final Level/FL.html" class="nav-link text-white mb-2">Final Level</a>
                    <a href="/Logout/logout.html" class="nav-link text-white mt-5">Logout</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 p-5">
                <div class="welcome-container p-5 rounded shadow-lg">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fw-bold">Student Profile</h1>
                            <p class="text-muted">View your profile information below.</p>
                        </div>
                        <img src="/Student/Dashboard/user.png" style="width: 125px;" class="my-3">
                    </div>
                    <hr>
                    <div class="row">
                        <!-- Academic Information -->
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Academic Information</h5>
                                    <hr>
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($studentData['nama']); ?></p>
                                    <p><strong>Program:</strong> <?php echo htmlspecialchars($studentData['program']); ?></p>
                                    <p><strong>Major:</strong> <?php echo htmlspecialchars($studentData['prodi']); ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Personal Information</h5>
                                    <hr>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($studentData['email']); ?></p>
                                    <p><strong>NIM:</strong> <?php echo htmlspecialchars($nim); ?></p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End of Two Columns -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
