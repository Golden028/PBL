<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowedTypes = ['application/pdf'];
    $maxSize = 1 * 1024 * 1024; // 1 MB

    $files = ['tanda_terima', 'pkl_laporan', 'bebas_kompen', 'scan_toeic'];

    foreach ($files as $file) {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($_FILES[$file]['tmp_name']);
            $fileSize = $_FILES[$file]['size'];

            if (!in_array($fileType, $allowedTypes)) {
                die("File $file harus berupa PDF.");
            }

            if ($fileSize > $maxSize) {
                die("File $file melebihi ukuran maksimal 1 MB.");
            }

            // Pindahkan file ke folder tujuan
            $destination = "uploads/" . basename($_FILES[$file]['name']);
            move_uploaded_file($_FILES[$file]['tmp_name'], $destination);
        } else {
            die("Gagal mengunggah file $file.");
        }
    }

    echo "Semua dokumen berhasil diunggah!";
} else {
    echo "Metode tidak valid.";
}
?>
