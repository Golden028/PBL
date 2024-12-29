<?php
// Koneksi ke database SQL Server
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "db_web_pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

// Cek jika koneksi gagal
if (!$conn_sqlserver) {
    die("Koneksi gagal: " . print_r(sqlsrv_errors(), true));
}

// Query untuk mengambil data dari tabel verifikasi_dokumen
$query = "SELECT nim, nama, prodi, tanda_terima, pkl_laporan, bebas_kompen, scan_toeic, document_status FROM verifikasi_dokumen";
$result = sqlsrv_query($conn_sqlserver, $query);

// Cek jika query gagal
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Array untuk menyimpan data
$data = array();

// Mengambil data dari result dan memasukkan ke dalam array
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

// Menutup koneksi
sqlsrv_close($conn_sqlserver);

// Mengirimkan data dalam format JSON
echo json_encode($data);
?>
