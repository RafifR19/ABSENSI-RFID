<?php
$konek = mysqli_connect("localhost", "root", "", "absensirfid");
if (!$konek) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>