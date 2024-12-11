<?php
include 'koneksi.php'; // Memasukkan koneksi database

// Query data Student
$nim = 2341720289; // NIM Student
$sql = "SELECT * FROM Student WHERE nim = ?";
$params = array($nim);
$stmt = sqlsrv_query($conn_sqlserver, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$Student = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Student</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="welcome-container p-4">
            <h2 class="text-center fw-bold mb-4">Profile Student</h2>
            <table class="table table-bordered table-hover shadow-sm">
                <tbody>
                    <tr>
                        <th class="bg-primary text-white">Full Name</th>
                        <td><?= htmlspecialchars($Student['nama'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">NIM</th>
                        <td><?= htmlspecialchars($Student['nim'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Major</th>
                        <td><?= htmlspecialchars($Student['prodi'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Program</th>
                        <td><?= htmlspecialchars($Student['program'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Semester</th>
                        <td><?= htmlspecialchars($Student['semester'] ?? 'Data not found') . "th Semester"; ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Academic Advisor</th>
                        <td><?= htmlspecialchars($Student['pembimbing_akademik'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Address</th>
                        <td><?= htmlspecialchars($Student['alamat'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Phone Number</th>
                        <td><?= htmlspecialchars($Student['no_telepon'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Email</th>
                        <td><?= htmlspecialchars($Student['email'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Gender</th>
                        <td><?= htmlspecialchars($Student['jenis_kelamin'] ?? 'Data not found'); ?></td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white">Religion</th>
                        <td><?= htmlspecialchars($Student['agama'] ?? 'Data not found'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
