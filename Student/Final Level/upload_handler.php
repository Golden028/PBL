<?php
// Koneksi ke SQL Server
$host_sqlserver = "DESKTOP-7J8U2B0";
$connInfo = array("Database" => "db_web_pbl", "UID" => "", "PWD" => "");
$conn_sqlserver = sqlsrv_connect($host_sqlserver, $connInfo);

if (!$conn_sqlserver) {
    die("Koneksi ke SQL Server gagal: " . print_r(sqlsrv_errors(), true));
}

// Fungsi untuk menangani upload file
function uploadFile($file, $targetDir) {
    $fileName = time() . "_" . basename($file["name"]); // Tambahkan timestamp untuk nama file unik
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validasi tipe file
    $allowedTypes = ['pdf', 'zip', 'rar'];
    if (!in_array($fileType, $allowedTypes)) {
        return "Tipe file tidak diperbolehkan.";
    }

    // Validasi ukuran file
    if ($file["size"] > 1048576000) { // 1 GB
        return "Ukuran file terlalu besar.";
    }

    // Memindahkan file ke folder target
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    } else {
        return false;
    }
}

// Menangani file yang diunggah
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah 'nim' ada di POST
    if (!isset($_POST['nim']) || empty($_POST['nim'])) {
        die("NIM tidak ditemukan.");
    }
    $nim = $_POST['nim']; // Ambil nilai NIM dari form
    $targetDir = "uploads/";

    // Buat folder jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Upload file
    $finalProject = isset($_FILES["final_project"]) ? uploadFile($_FILES["final_project"], $targetDir) : false;
    $uploadProgram = isset($_FILES["upload_program"]) ? uploadFile($_FILES["upload_program"], $targetDir) : false;
    $uploadPublication = isset($_FILES["upload_publication"]) ? uploadFile($_FILES["upload_publication"], $targetDir) : false;

    // Validasi jika semua file berhasil diupload
    if ($finalProject && $uploadProgram && $uploadPublication) {
        // Periksa apakah data sudah ada
        $checkSql = "SELECT COUNT(*) AS count FROM uploaded_files WHERE nim = ?";
        $checkStmt = sqlsrv_query($conn_sqlserver, $checkSql, array($nim));

        if ($checkStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
        if ($row['count'] > 0) {
            // Update data jika sudah ada
            $sql = "UPDATE uploaded_files 
                    SET final_project = ?, upload_program = ?, upload_publication = ?, created_at = GETDATE() 
                    WHERE nim = ?";
            $params = array($finalProject, $uploadProgram, $uploadPublication, $nim);
        } else {
            // Insert data baru jika belum ada
            $sql = "INSERT INTO uploaded_files (nim, final_project, upload_program, upload_publication) 
                    VALUES (?, ?, ?, ?)";
            $params = array($nim, $finalProject, $uploadProgram, $uploadPublication);
        }

        $stmt = sqlsrv_query($conn_sqlserver, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header("Location: sukses.html");  // Redirect ke halaman sukses setelah upload berhasil
            exit();
        }
    } else {
        echo "Ada kesalahan dalam proses upload file.";
    }

    sqlsrv_close($conn_sqlserver);
}
?>
