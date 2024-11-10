<?php
include "koneksi.php";

// Baca mode absensi terakhir
$mode_query = mysqli_query($konek, "SELECT mode FROM status LIMIT 1");
if (!$mode_query) {
    die("Query gagal: " . mysqli_error($konek));
}

$data_mode = mysqli_fetch_assoc($mode_query);
if (!$data_mode) {
    die("Data mode tidak ditemukan.");
}

// Ambil nilai mode_absen terakhir
$mode_absen = (int)$data_mode['mode'];

// Tentukan mode absensi berikutnya
$mode_absen += 1;

// Jika mode lebih dari 2, kembali ke 1 (masuk)
if ($mode_absen > 2) {
    $mode_absen = 1;
}

// Update mode absensi di tabel status
$update_query = "UPDATE status SET mode = ?";
$stmt = $konek->prepare($update_query);
if (!$stmt) {
    die("Prepare statement gagal: " . $konek->error);
}

$stmt->bind_param("i", $mode_absen);

if ($stmt->execute()) {
    // Redirect ke halaman scan untuk memperbarui tampilan
    header("Location: scan.php");
    exit(); // Pastikan tidak ada kode yang dijalankan setelah redirect
} else {
    echo "Gagal memperbarui mode absensi: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
mysqli_close($konek);
?>
