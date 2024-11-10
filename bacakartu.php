<?php
include "koneksi.php";

// Baca tabel untuk mode absensi
$sql = mysqli_query($konek, "SELECT * FROM status");
if (!$sql) {
    die("Query failed: " . mysqli_error($konek));
}

// Periksa apakah ada data untuk mode absensi
$data = mysqli_fetch_array($sql);
if ($data) {
    $mode_absen = $data['mode'];
} else {
    die("Tidak ada data mode absensi.");
}

// Uji mode absen
$mode = "";
switch ($mode_absen) {
    case 1:
        $mode = "Masuk";
        break;
    case 2:
        $mode = "Pulang";
        break;
    default:
        $mode = "Mode tidak dikenali";
}

// Baca tabel tmprfid
$baca_kartu = mysqli_query($konek, "SELECT * FROM tmprfid");
if (!$baca_kartu) {
    die("Query failed: " . mysqli_error($konek));
}

// Periksa apakah ada data kartu
$data_kartu = mysqli_fetch_array($baca_kartu);
if ($data_kartu) {
    $nokartu = $data_kartu['no_kartu'];
} else {
    $nokartu = "";
}
?>

<div class="container-fluid" style="text-align: center;">
  <?php if ($nokartu == "") { ?>
    <h3>Absen: <?php echo htmlspecialchars($mode); ?></h3>
    <h3>Silakan Tempelkan Kartu RFID Anda</h3>
    <img src="images/rfid.png" style="width: 200px;"> <br>
    <img src="images/animasi2.gif">
  <?php } else {
        // Cek nomor kartu RFID apakah terdaftar di tabel karyawan
        $stmt = $konek->prepare("SELECT * FROM siswa WHERE no_kartu = ?");
        $stmt->bind_param("s", $nokartu);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo "<h1>Maaf! Kartu Tidak Dikenali</h1>";
        } else {
            // Ambil nama karyawan
            $data_karyawan = $result->fetch_assoc();
            $nama = $data_karyawan['nama'];
            $kelas = $data_karyawan['kelas'];

            // Tanggal dan jam hari ini
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d');
            $jam = date('H:i:s');

            // Cek di tabel absensi apakah nomor kartu tersebut sudah ada sesuai tanggal saat ini
            $stmt = $konek->prepare("SELECT * FROM absensi WHERE nokartu = ? AND tanggal = ?");
            $stmt->bind_param("ss", $nokartu, $tanggal);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Jika mode absensi adalah "Masuk" dan sudah ada jam_masuk, atau jika mode "Pulang" dan sudah ada jam_pulang
                $data_absensi = $result->fetch_assoc();
                
                if ($mode_absen == 1 && !empty($data_absensi['jam_masuk'])) {
                    echo "<h1>Data Masuk Sudah Tercatat Hari Ini untuk <br> $nama</h1>";
                } elseif ($mode_absen == 2 && !empty($data_absensi['jam_pulang'])) {
                    echo "<h1>Data Pulang Sudah Tercatat Hari Ini untuk <br> $nama</h1>";
                } else {
                    // Update sesuai pilihan mode absen
                    if ($mode_absen == 1) {
                        echo "<h1>Selamat Datang <br> $nama</h1>";
                        $stmt = $konek->prepare("UPDATE absensi SET jam_masuk = ? WHERE nokartu = ? AND tanggal = ?");
                        $stmt->bind_param("sss", $jam, $nokartu, $tanggal);
                    } elseif ($mode_absen == 2) {
                        echo "<h1>Selamat Pulang <br> $nama</h1>";
                        $stmt = $konek->prepare("UPDATE absensi SET jam_pulang = ? WHERE nokartu = ? AND tanggal = ?");
                        $stmt->bind_param("sss", $jam, $nokartu, $tanggal);
                    }
                    if (!$stmt->execute()) {
                        die("Query failed: " . $stmt->error);
                    }
                }
            } else {
                // Jika data absensi belum ada untuk tanggal ini, insert data baru
                if ($mode_absen == 1) {
                    echo "<h1>Selamat Datang <br> $nama</h1>";
                    $stmt = $konek->prepare("INSERT INTO absensi (nokartu, kelas, tanggal, jam_masuk) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $nokartu, $kelas, $tanggal, $jam);
                } elseif ($mode_absen == 2) {
                    echo "<h1>Selamat Pulang <br> $nama</h1>";
                    $stmt = $konek->prepare("INSERT INTO absensi (nokartu, kelas, tanggal, jam_pulang) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $nokartu, $kelas, $tanggal, $jam);
                }
                if (!$stmt->execute()) {
                    die("Query failed: " . $stmt->error);
                }
            }
        }
        // Kosongkan tabel tmprfid
        mysqli_query($konek, "DELETE FROM tmprfid"); ?>
</div>

<?php
// Tutup koneksi
mysqli_close($konek);
?>
