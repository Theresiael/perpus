<?php
error_reporting(E_ALL ^ E_NOTICE);
    // buka koneksi ke database server
    // sesuaikan dengan database sendiri
    $hostname="localhost"; // sesuaikan
    $username="root"; // sesuaikan
    $password=""; //sesuaikan
    $database="perpus";

    $connect = mysqli_connect($hostname, $username, $password, $database);

    if (mysqli_connect_errno()){
        echo "Koneksi database gagal : " . mysqli_connect_error();
    }
?>