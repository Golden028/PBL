<?php
$serverName = "localhost";
$connectionOptions = [
    "Database" => "db_web_pbl",
    "Uid" => "",
    "PWD" => ""
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>
