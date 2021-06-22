<?php
    include "koneksi.php";
    include "cekSession.php";

    date_default_timezone_set('Asia/Makassar');
    $tanggal = date("Y-m-d H:i:sa");

    $id_pinjam = $_GET['id_pinjam'];

    $queryup = mysqli_query($connect, "UPDATE table_detail_pinjam SET tgl_kembali='$tanggal' WHERE id_pinjam='$id_pinjam'");
    if ($queryup){
        echo "<script>alert('Buku Berhasil dikembalikan.')</script>";
        echo "<script>window.location.href='pinjam.php';</script>";
    } else {
        echo "<script>alert('Gagal dikembalikan.')</script>";
        echo "<script>window.location.href='pinjam.php';</script>";
    }
?>