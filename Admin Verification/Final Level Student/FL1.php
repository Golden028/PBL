<?php
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Koneksi ke database
    $conn = new PDO("sqlsrv:Server=localhost;Database=db_web_pbl", "", "");

    // Query untuk mengambil detail mahasiswa
    $sql = "SELECT * FROM Student WHERE nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nim]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        echo "<h1>Detail Mahasiswa</h1>";
        echo "<p>Nama: " . htmlspecialchars($student['nama'] ?? '') . "</p>";
        echo "<p>NIM: " . htmlspecialchars($student['nim'] ?? '') . "</p>";
        // Tambahkan detail lainnya...
    } else {
        echo "Data mahasiswa tidak ditemukan.";
    }
} else {
    echo "NIM tidak ditemukan.";
}
?>
