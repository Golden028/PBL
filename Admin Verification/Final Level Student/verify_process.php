<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db_connection.php';

    $id = $_POST['id'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 'Approved' : 'Rejected';

    $sql = "UPDATE uploaded_files SET status = ? WHERE id = ?";
    $params = [$status, $id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        echo "Document has been $status.";
    } else {
        echo "Error: " . print_r(sqlsrv_errors(), true);
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>
