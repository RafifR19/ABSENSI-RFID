<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <?php include "header.php";?>
  <title>Rekap Absensi</title>
</head>
<body>
  <?php include "menu.php";?>
  <div>
    <h3>Rekap Absensi</h3>
    
    <!-- Formulir untuk memilih kelas dan rentang tanggal -->
    <form method="GET" action="">
      <label for="kelas">Pilih Kelas:</label>
      <select name="kelas" id="kelas">
        <option value="">-- Pilih Kelas --</option>
        <?php
        include "koneksi.php";
        $kelas_query = "SELECT kode_kelas, nama_kelas FROM kelas";
        $kelas_result = mysqli_query($konek, $kelas_query);
        while ($kelas = mysqli_fetch_assoc($kelas_result)) {
          echo "<option value=\"" . $kelas['kode_kelas'] . "\">" . $kelas['nama_kelas'] . "</option>";
        }
        ?>
      </select>
      
      <label for="tanggal_awal">Tanggal Awal:</label>
      <input type="date" id="tanggal_awal" name="tanggal_awal">
      
      <label for="tanggal_akhir">Tanggal Akhir:</label>
      <input type="date" id="tanggal_akhir" name="tanggal_akhir">
      
      <button type="submit">Tampilkan Data</button>
    </form>
    
    <?php
    if (isset($_GET['kelas']) && isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
        $kelas_id = $_GET['kelas'];
        $tanggal_awal = $_GET['tanggal_awal'];
        $tanggal_akhir = $_GET['tanggal_akhir'];

        // Filter absensi berdasarkan kelas dan rentang tanggal
        $sql = "SELECT b.nama, a.tanggal, a.jam_masuk, a.jam_pulang 
                FROM absensi a 
                JOIN siswa b ON a.nokartu = b.no_kartu 
                WHERE b.kelas = '$kelas_id' AND a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";

        // Menjalankan query
        $result = mysqli_query($konek, $sql);

        // Memeriksa apakah query berhasil
        if (!$result) {
            die("Query gagal: " . mysqli_error($konek));
        }
    ?>
    
    <!-- Tabel untuk menampilkan data absensi -->
    <table class="table table-bordered">
      <thead>
        <tr style="background-color: grey; color:white">
          <th style="width: 10px; text-align: center">No.</th>
          <th style="text-align: center">Nama</th>
          <th style="text-align: center">Tanggal</th>
          <th style="text-align: center">Jam Masuk</th>
          <th style="text-align: center">Jam Pulang</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        while ($data = mysqli_fetch_array($result)) {
          $no++; 
        ?>
        <tr>
          <td> <?php echo $no; ?></td>
          <td> <?php echo $data['nama']; ?></td>
          <td> <?php echo $data['tanggal']; ?></td>
          <td> <?php echo $data['jam_masuk']; ?></td>
          <td> <?php echo $data['jam_pulang']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } ?>
  </div>
  <?php include "footer.php";?>
</body>
</html>
