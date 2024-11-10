<?php
 include "koneksi.php";

 //baca nomor kartu dari NodeMCU
 $nokartu = $_GET['nokartu'];
 //kosongkan tabel tmprid 
 mysqli_query($konek, "delete from tmprfid");

 //simpan nomor kartu yang baru ke tabel tmprfid 
 $simpan = mysqli_query($konek, "insert into tmprfid(no_kartu)values('$nokartu')");
  if($simpan)
       echo "Berhasil";
    else
       echo "Gagal";
?>