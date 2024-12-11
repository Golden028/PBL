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
    
    // Memastikan file adalah PDF dan ukuran kurang dari 1 MB
    if ($fileType != "pdf") {
        return "Hanya file PDF yang diperbolehkan.";
    }
    if ($file["size"] > 1048576) { // 1 MB
        return "Ukuran file terlalu besar.";
    }
    
    // Memindahkan file ke folder target
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile; // Kembalikan path file yang di-upload
    } else {
        return "Terjadi kesalahan saat mengupload file.";
    }
}

// Menangani file yang di-upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/"; // Direktori untuk menyimpan file
    
    // Periksa apakah folder upload sudah ada, jika belum buat
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $tandaTerima = uploadFile($_FILES["tanda_terima"], $targetDir);
    $pklLaporan = uploadFile($_FILES["pkl_laporan"], $targetDir);
    $bebasKompen = uploadFile($_FILES["bebas_kompen"], $targetDir);
    $scanToeic = uploadFile($_FILES["scan_toeic"], $targetDir);

    // Jika file berhasil diupload, simpan ke database
    if (strpos($tandaTerima, "uploads/") !== false &&
        strpos($pklLaporan, "uploads/") !== false &&
        strpos($bebasKompen, "uploads/") !== false &&
        strpos($scanToeic, "uploads/") !== false) {
        
        // Menyimpan data ke dalam database
        $nim = 2341720289; // Anda bisa mengganti dengan NIM yang sesuai
        $sql = "INSERT INTO verifikasi_dokumen (nim, tanda_terima, pkl_laporan, bebas_kompen, scan_toeic) 
                VALUES (?, ?, ?, ?, ?)";
        
        $params = array($nim, $tandaTerima, $pklLaporan, $bebasKompen, $scanToeic);
        $stmt = sqlsrv_query($conn_sqlserver, $sql, $params);
        
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Data berhasil disimpan.";
        }
    } else {
        echo "Ada kesalahan dalam proses upload file.";
    }

    sqlsrv_close($conn_sqlserver);
}
?>
