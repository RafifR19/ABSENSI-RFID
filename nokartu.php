<?php
include "koneksi.php";

// Baca isi tabel tmprfid
$sql = mysqli_query($konek, "SELECT * FROM tmprfid");

// Ambil data dari query sebagai array asosiatif
$data = mysqli_fetch_assoc($sql);

// Baca nokartu dari data
$nokartu = isset($data['no_kartu']) ? $data['no_kartu'] : ''; // Pastikan kolomnya ada dan nilai tidak null
?>

<div class="form-group">
    <label> No.Kartu</label>
    <input type="text" name="nokartu" id="nokartu" placeholder="tempelkan kartu rfid anda" class="form-control" style="width: 200px" value="<?php echo htmlspecialchars($nokartu); ?>">
</div>

