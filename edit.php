<?php
include "koneksi.php";

// Periksa apakah 'id' ada dalam $_POST
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $cari = mysqli_query($konek, "SELECT * FROM karyawan WHERE id='$id'");
    $hasil = mysqli_fetch_array($cari);

    if (isset($_POST['btnSimpan'])) {
        $nokartu = $_POST['nokartu']; // Perbaiki nama input sesuai dengan HTML
        $nama = $_POST['nama'];       // Perbaiki nama input sesuai dengan HTML
        $alamat = $_POST['kelas'];

        $simpan = mysqli_query($konek, "UPDATE karyawan SET no_kartu='$nokartu', Nama='$nama', Alamat='$alamat' WHERE id='$id'");

        if ($simpan) {
            echo "
                <script>
                    alert('Tersimpan');
                    location.replace('datakaryawan.php');
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Gagal Tersimpan " . mysqli_error($konek) . "');
                    location.replace('datakaryawan.php');
                </script>
            ";
        }
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "header.php"; ?>
    <title>Edit Data Karyawan</title>
</head>
<body>
<?php include "menu.php"; ?>
<div class="container-fluid">
    <h3>Edit Data Karyawan</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Tambahkan field id yang hidden -->
        <div class="form-group">
            <label>No.Kartu</label>
            <input type="text" name="nokartu" id="nokartu" placeholder="nomor kartu RFID" class="form-control" style="width: 200px" value="<?php echo $hasil['no_kartu']; ?>">
        </div>
        <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" name="nama" id="nama" placeholder="nama siswa" class="form-control" style="width: 400px" value="<?php echo $hasil['Nama']; ?>">
        </div>
        <div class="form-group">
        <label for="kelas">Kelas</label>
        <select id="kelas" name="kelas" class="form-control" style="width: 400px">
            <option value="x-tjkt">X-TJKT</option>
            <option value="xi-tjkt">XI-TJKT</option>
            <option value="xii-tjkt">XII-TJKT</option>
        </select>
    </div>

        <button class="btn btn-primary" name="btnSimpan" id="btnSimpan">Simpan</button>
    </form>
</div>
<?php include "footer.php"; ?>
</body>
</html>
