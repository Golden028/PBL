<?php
// Koneksi ke SQL Server
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "Pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

if (!$conn_sqlserver) {
    die("Koneksi ke SQL Server gagal: " . print_r(sqlsrv_errors(), true));
} else {
    echo "Koneksi ke SQL Server berhasil!<br>";
}
?>
