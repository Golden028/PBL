<?php
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "db_web_pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

if (!$conn_sqlserver) {
    die("Koneksi ke SQL Server gagal: " . print_r(sqlsrv_errors(), true));
}

$query = "
    SELECT s.nim, s.nama, s.prodi, vd.tanda_terima, vd.pkl_laporan, vd.bebas_kompen, vd.scan_toeic, vd.document_status
    FROM Student s
    JOIN verifikasi_dokumen vd ON s.nim = vd.nim
";
$stmt = sqlsrv_query($conn_sqlserver, $query);
$data = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}
header('Content-Type: application/json');
echo json_encode($data);
sqlsrv_close($conn_sqlserver);
?>
