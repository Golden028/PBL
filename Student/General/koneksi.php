<?php
// Koneksi ke SQL Server
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "db_web_pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

if (!$conn_sqlserver) {
    die("Koneksi ke SQL Server gagal: " . print_r(sqlsrv_errors(), true));
}
?>
