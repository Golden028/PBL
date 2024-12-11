<?php
$host = "DESKTOP-03IKLJ8"; // nama server\nama_instance
$connInfo = array("Database" => "PBL", "UID" => "", "PWD" => "");
$conn = sqlsrv_connect($host, $connInfo);

if ($conn) {
  echo "Koneksi berhasil.<br />";
} else {
  echo "Koneksi Gagal";
  die (print_r(sqlsrv_errors(), true));
}
?>