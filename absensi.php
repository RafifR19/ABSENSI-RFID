<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <?php include "header.php"; ?>
  <title>Rekap Absensi</title>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Menambahkan script untuk membaca kartu RFID secara diam-diam -->
  <script type="text/javascript">
    $(document).ready(function() {
      setInterval(function() {
        // Mengambil data kartu yang terbaca, namun tidak menampilkannya di halaman
        $.ajax({
          url: 'bacakartu.php',
          success: function(data) {
            if (data) {
              $.ajax({
                url: 'proses_absensi.php',
                method: 'POST',
                data: { kartu: data },
                success: function(response) {
                  console.log(response);
                }
              });
            }
          }
        });
      }, 1000); // Setiap 1 detik, ambil data kartu

      // Muat ulang tabel absensi setiap 5 detik
      setInterval(function() {
        $("#tabel-absensi").load("load_absensi.php");
      }, 5000); // 5000 ms = 5 detik
    });
  </script>
</head>
<body>
  <?php include "menu.php"; ?>

  <div>
    <h3>Rekap Absensi</h3>
    <p>Tanggal hari ini adalah: <?php echo date('Y-m-d'); ?></p>
    <table class="table table-bordered">
      <thead>
        <tr style="background-color: grey; color: white">
          <th style="width: 10px; text-align: center">No.</th>
          <th style="text-align: center">Nama</th>
          <th style="text-align: center">Kelas</th>
          <th style="text-align: center">Tanggal</th>
          <th style="text-align: center">Jam Masuk</th>
          <th style="text-align: center">Jam Pulang</th>
        </tr>
      </thead>
      <tbody id="tabel-absensi">
        <!-- Data tabel absensi akan dimuat di sini dari file load_absensi.php -->
        <?php include "load_absensi.php"; ?>
      </tbody>
    </table>
  </div>

  <?php include "footer.php"; ?>
</body>
</html>
