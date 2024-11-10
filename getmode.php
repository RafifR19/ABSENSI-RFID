<?php
// Konfigurasi database
include "koneksi.php";

// Query untuk mendapatkan nilai mode dari tabel status
$sql = "SELECT mode FROM status "; // Mengambil nilai mode terbaru
$result = $konek->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Jika ada hasil, ambil nilai mode
    $row = $result->fetch_assoc();
    $response["modeResponse"] = (int)$row["mode"];
} else {
    // Jika tidak ada data, kembalikan nilai default
    $response["modeResponse"] = 0; // 0 bisa diartikan sebagai mode tidak valid
}

// Mengatur header JSON dan mencetak respon
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$konek->close();
?>
