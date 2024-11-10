<?php
include "koneksi.php";

if (isset($_POST['btnSimpan'])) {
    $nokartu = isset($_POST['nokartu']) ? $_POST['nokartu'] : '';
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $kelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';

    // Sanitasi input (ini contoh sederhana, disarankan menggunakan prepared statements untuk keamanan)
    $nokartu = mysqli_real_escape_string($konek, $nokartu);
    $nama = mysqli_real_escape_string($konek, $nama);
    $kelas = mysqli_real_escape_string($konek, $kelas);

    $simpan = mysqli_query($konek, "INSERT INTO siswa (nokartu, nama, kelas) VALUES ('$nokartu', '$nama', '$kelas')");

    if ($simpan) {
        echo "
            <script>
                alert('Tersimpan');
                window.location.replace('datakaryawan.php');
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal Tersimpan');
                window.location.replace('datakaryawan.php');
            </script>
        ";
    }
}
// kosongkan tabel kartu tmprid 
mysqli_query($konek, "delete from tmprfid");
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "header.php"; ?>
    <title>Tambah Data karyawan</title>

    <script type="text/javascript">
        $(document).ready(function(){
            setInterval(function(){
                $("#norfid").load('nokartu.php');
            }, 0);
        });

    </script>
</head>
<body>
<?php include "menu.php"; ?>
<div class="container-fluid">
    <h3>Tambah Data Siswa</h3>
   <form method="POST" action="simpansiswa.php">
    <div id="norfid"></div> 
    <div class="form-group">
        <label> Nama Siswa</label>
        <input type="text" name="nama" id="nama" placeholder="Nama Siswa" class="form-control" style="width: 400px">
    </div>
    <div class="form-group">
        <label for="kelas">Kelas</label>
        <select id="kelas" name="kelas" class="form-control" style="width: 400px">
            <?php
                $kelas_query = "SELECT kode_kelas, nama_kelas FROM kelas";
                $kelas_result = mysqli_query($konek, $kelas_query);
                while ($kelas = mysqli_fetch_assoc($kelas_result)) {
                echo "<option value=\"" . $kelas['kode_kelas'] . "\">" . $kelas['nama_kelas'] . "</option>";
                }
        ?>
        </select>
    </div>
    <button class="btn btn-primary" name="submit" id="submit">Simpan</button>
</form>


</div>
<?php include "footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>