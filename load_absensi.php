<?php
include "koneksi.php";

// Membaca tanggal hari ini
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');

// Query absensi berdasarkan tanggal hari ini
$sql = "SELECT b.nama, a.kelas, a.tanggal, a.jam_masuk, a.jam_pulang 
        FROM absensi a 
        JOIN siswa b ON a.nokartu = b.no_kartu 
        WHERE a.tanggal = '$tanggal'";
        
$result = mysqli_query($konek, $sql);
$no = 0;

while ($data = mysqli_fetch_array($result)) {
    $no++;
    echo "<tr>
            <td style='text-align: center'>$no</td>
            <td>{$data['nama']}</td>
            <td>{$data['kelas']}</td>
            <td>{$data['tanggal']}</td>
            <td>{$data['jam_masuk']}</td>
            <td>{$data['jam_pulang']}</td>
          </tr>";
}
?>
