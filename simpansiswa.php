<?php
include "koneksi.php";

// Proses form submission atau operasi lainnya
if (isset($_POST['submit'])) {
    // Operasi database
    $no_kartu = $_POST['nokartu'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    
    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $konek->prepare("INSERT INTO siswa (no_kartu, nama, kelas) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare statement failed: " . $konek->error);
    }
    
    // Bind parameters. 'sss' berarti tiga string
    $stmt->bind_param("sss", $no_kartu, $nama, $kelas);
    
    // Execute statement
    if ($stmt->execute()) {
        $stmt->close();
        
        // Hapus data dari tmprfid
        mysqli_query($konek, "DELETE FROM tmprfid");
        
        // Redirect dengan query string
        header("Location: datakaryawan.php?status=success&nama=" . urlencode($nama));
        exit();
    } else {
        echo "Error executing query: " . $stmt->error;
    }
}
?>
