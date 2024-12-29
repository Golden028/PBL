<?php
// Koneksi ke database SQL Server
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "db_web_pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

// Cek jika koneksi gagal
if (!$conn_sqlserver) {
    die("Koneksi gagal: " . print_r(sqlsrv_errors(), true));
}

// Menerima data JSON yang dikirimkan
$data = json_decode(file_get_contents('php://input'), true);

// Cek apakah data yang diperlukan sudah ada
if (!isset($data['nim']) || !isset($data['status'])) {
    die("Error: Missing required parameters.");
}

$nim = $data['nim'];
$status = $data['status'];
$reason = isset($data['reason']) ? $data['reason'] : null;  // Jika tidak ada alasan, set null

// Query untuk memperbarui status verifikasi
$query = "
    UPDATE verifikasi_dokumen 
    SET document_status = ?, rejection_reason = ? 
    WHERE nim = ?
";
$params = [$status, $reason, $nim];

// Eksekusi query
$stmt = sqlsrv_query($conn_sqlserver, $query, $params);

// Cek jika query gagal
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Mengirimkan pesan sukses jika berhasil
echo "Status berhasil diperbarui!";
sqlsrv_close($conn_sqlserver);
?>
