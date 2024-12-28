<?php
// Database connection settings
$serverName = "localhost"; // Ganti dengan nama server Anda
$connectionOptions = [
    "Database" => "db_web_pbl", // Nama database Anda
    "Uid" => "",              // Username SQL Server Anda
    "PWD" => ""         // Password SQL Server Anda
];

// Membuat koneksi
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Cek apakah koneksi berhasil
if ($conn === false) {
    die("Database connection failed: " . print_r(sqlsrv_errors(), true));
}
?>
