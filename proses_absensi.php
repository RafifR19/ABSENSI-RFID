<?php
include "koneksi.php";

// Menerima data kartu dari AJAX
if (isset($_POST['kartu'])) {
    $nokartu = $_POST['kartu'];

    // Mendapatkan informasi nama dan kelas berdasarkan kartu yang terbaca
    $query = "SELECT nama, kelas FROM siswa WHERE no_kartu = '$nokartu'";
    $result = mysqli_query($konek, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data_siswa = mysqli_fetch_assoc($result);
        $nama = $data_siswa['nama'];
        $kelas = $data_siswa['kelas'];
        
        // Memeriksa apakah sudah ada data absensi untuk nama yang sama pada tanggal ini
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');

        $checkQuery = "SELECT * FROM absensi WHERE nama = '$nama' AND tanggal = '$tanggal'";
        $checkResult = mysqli_query($konek, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "Data sudah ada, tidak perlu menyimpan ulang.";
        } else {
            // Jika belum ada, maka insert data baru
            $jam_masuk = date('H:i:s');
            $insertQuery = "INSERT INTO absensi (nokartu, nama, kelas, tanggal, jam_masuk) VALUES ('$nokartu', '$nama', '$kelas', '$tanggal', '$jam_masuk')";
            $insertResult = mysqli_query($konek, $insertQuery);

            if ($insertResult) {
                echo "Absensi berhasil disimpan.";
            } else {
                echo "Gagal menyimpan absensi.";
            }
        }
    } else {
        echo "Data siswa tidak ditemukan.";
    }
}
?>
