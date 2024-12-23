<?php
// Koneksi ke SQL Server
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "db_web_pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

if (!$conn_sqlserver) {
    die("Koneksi ke SQL Server gagal: " . print_r(sqlsrv_errors(), true));
}

// Fungsi untuk menangani upload file
function uploadFile($file, $targetDir) {
    $fileName = basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validasi tipe file dan ukuran
    if ($fileType != "pdf") {
        return "Hanya file PDF yang diperbolehkan.";
    }
    if ($file["size"] > 1048576) { // 1 MB
        return "Ukuran file terlalu besar.";
    }

    // Memindahkan file ke folder target
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    } else {
        return "Terjadi kesalahan saat mengupload file.";
    }
}

// Menangani file yang di-upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/";

    // Buat folder jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Upload file
    $tandaTerima = uploadFile($_FILES["tanda_terima"], $targetDir);
    $pklLaporan = uploadFile($_FILES["pkl_laporan"], $targetDir);
    $bebasKompen = uploadFile($_FILES["bebas_kompen"], $targetDir);
    $scanToeic = uploadFile($_FILES["scan_toeic"], $targetDir);

    if (strpos($tandaTerima, "uploads/") !== false &&
        strpos($pklLaporan, "uploads/") !== false &&
        strpos($bebasKompen, "uploads/") !== false &&
        strpos($scanToeic, "uploads/") !== false) {

        $nim = 2341720289; // NIM mahasiswa, ganti sesuai kebutuhan
        $checkSql = "SELECT COUNT(*) AS count FROM verifikasi_dokumen WHERE nim = ?";
        $checkStmt = sqlsrv_query($conn_sqlserver, $checkSql, array($nim));

        if ($checkStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
        if ($row['count'] > 0) {
            $sql = "UPDATE verifikasi_dokumen 
                    SET tanda_terima = ?, pkl_laporan = ?, bebas_kompen = ?, scan_toeic = ? 
                    WHERE nim = ?";
            $params = array($tandaTerima, $pklLaporan, $bebasKompen, $scanToeic, $nim);
        } else {
            $sql = "INSERT INTO verifikasi_dokumen (nim, tanda_terima, pkl_laporan, bebas_kompen, scan_toeic) 
                    VALUES (?, ?, ?, ?, ?)";
            $params = array($nim, $tandaTerima, $pklLaporan, $bebasKompen, $scanToeic);
        }

        $stmt = sqlsrv_query($conn_sqlserver, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            // Redirect ke halaman sukses.html
            header("Location: sukses.html");
            exit();
        }
    } else {
        echo "Ada kesalahan dalam proses upload file.";
    }

    sqlsrv_close($conn_sqlserver);
}
?>
