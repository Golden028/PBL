<?php
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "db_web_pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

if (!$conn_sqlserver) {
    die("Koneksi ke SQL Server gagal: " . print_r(sqlsrv_errors(), true));
}

$data = json_decode(file_get_contents('php://input'), true);
$nim = $data['nim'];
$status = $data['status'];
$reason = $data['reason'] ?? null;

$query = "
    UPDATE verifikasi_dokumen 
    SET document_status = ?, rejection_reason = ? 
    WHERE nim = ?
";
$params = [$status, $reason, $nim];
$stmt = sqlsrv_query($conn_sqlserver, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "Status updated successfully!";
sqlsrv_close($conn_sqlserver);
?>
