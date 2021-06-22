<?php
error_reporting(E_ALL ^ E_NOTICE);
include "koneksi.php";
include "cekSession.php";

$cekid_login = mysqli_query($connect, "SELECT id_login FROM table_login WHERE username='$user'");
$infoLog = mysqli_fetch_array($cekid_login);
$id_login = $infoLog['id_login'];

$cekId = mysqli_query($connect, "SELECT nama_depan , nama_belakang FROM table_detail_login WHERE id_login='$id_login'");
$info = mysqli_fetch_array($cekId);
$nama_depan = $info['nama_depan'];
$nama_belakang = $info['nama_belakang'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan Pinjam</title>
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
</head>

<body>

  <table class="table table-bordered">
    <tr>
      <td colspan="2">
        <h1>Sistem Informasi Perpustakaan <u><?= $user ?><u></h1>
      </td>
    </tr>
    <tr>
      <td width="200">
        <ul>
          <?php
          $cekid_login = mysqli_query($connect, "SELECT id_login FROM table_login WHERE username='$user'");
          $infoLog = mysqli_fetch_array($cekid_login);
          $id_login = $infoLog['id_login'];

          $cekLevel = mysqli_query($connect, "SELECT * FROM table_level WHERE id_login='$id_login' AND level='admin'");
          // menghitung jumlah data yang ditemukan
          $cek = mysqli_num_rows($cekLevel);
          $info = mysqli_fetch_array($cekLevel);

          if ($cek) {
          ?>
            <li><a href="dashboard.php" class="las la-igloo">Dashboard</a></li>
            <li><a href="anggota.php" class="las la-users">Anggota</a></li>
            <li><a href="buku.php" class="las la-book">Buku</a></li>
            <li><a href="pinjam.php" class="las la-clipboard-list">Pinjam</a></li>
          <?php
          } else {
          ?>
            <li><a href="dashboard.php" class="las la-igloo">Dashboard</a></li>
            <li><a href="pinjam.php" class="las la-clipboard-list">Pinjam</a></li>
          <?php
          }
          ?>
          <ul>
      </td>
      <td width="500">
        <a href="pinjam_buku.php" class="las la-file">Pinjam buku</a>
        <p style='color: #DD2F6E;'><b>Buku yang Sedang Dipinjam </b> </p>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Tanggal & Waktu Peminjaman</th>
              <th>Nama Peminjam</th>
              <th>Buku</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $cekid_login = mysqli_query($connect, "SELECT id_login FROM table_login WHERE username='$user'");
            $infoLog = mysqli_fetch_array($cekid_login);
            $id_login = $infoLog['id_login'];

            $queryinfo = mysqli_query($connect, "SELECT * FROM table_detail_pinjam, buku, table_detail_login, table_pinjam WHERE table_detail_login.id_login = table_pinjam.id_login AND buku.kd_buku = table_pinjam.kd_buku AND table_detail_pinjam.id_pinjam = table_pinjam.id_pinjam AND table_detail_login.id_login = '$id_login' AND table_detail_pinjam.tgl_kembali = '000-00-00 00:00:00'");
            /*$no = 1;*/
            while ($pinjam = mysqli_fetch_array($queryinfo)) {
            ?>
              <tr>
                <td><?= $pinjam['tgl_pinjam'] ?></td>
                <td><?= $pinjam['nama_depan'] ?> <?= $pinjam['nama_belakang'] ?></td>
                <td class="center"><?= $pinjam['judul_buku'] ?></td>

                <form method="POST" action="kembali_buku.php">
                  <input type="hidden" name="id_pinjam" value=<?= $pinjam['id_pinjam']; ?> />
                  <td><button type="submit" name="kembali" class="btn btn-warning"><a href="kembali_buku.php?id_pinjam=<?= $pinjam['id_pinjam']; ?>"><i class="las la-reply"></i> Kembali </a></button></td>
                </form>
              </tr>

            <?php /*$no++;*/
            }
            ?>
          </tbody>
        </table><br>

        <?php
        if (isset($_GET['hapus'])) {
          $id_pinjam = $_GET['id_pinjam'];
          $querydelete = mysqli_query($connect, "DELETE FROM table_pinjam WHERE id_pinjam='$id_pinjam'");

          if ($querydelete) {
            $queryDeletePinjam = mysqli_query($connect, "DELETE FROM table_detail_pinjam WHERE id_pinjam='$id_pinjam'");
            if ($queryDeletePinjam) {
              echo "<script>alert('Peminjaman Berhasil dihapus.')</script>";
              echo "<script>window.location.href='pinjam.php';</script>";
            } else {
              die('Sayang sekali tapi gagal saudara-saudara!!!' . mysqli_error($connect));
            }
          } else {
            die('Sayang sekali tapi gagal saudara-saudara!!!' . mysqli_error($connect));
          }
        }
        ?>

        <p style='color: #DD2F6E;'><b>Buku yang Sudah Dikembalikan</b></p>
        <table class="table table-hover">
          <thead>

            <tr>
              <th>Tanggal & Waktu Kembali</th>
              <th>Nama Peminjam</th>
              <th>Buku</th>
            </tr>
          </thead>

          <tbody>

            <?php
            $cekid_login = mysqli_query($connect, "SELECT id_login FROM table_login WHERE username='$user'");
            $infoLog = mysqli_fetch_array($cekid_login);
            $id_login = $infoLog['id_login'];

            $queryinfo = mysqli_query($connect, "SELECT * FROM table_detail_pinjam, buku, table_detail_login, table_pinjam WHERE table_detail_login.id_login = table_pinjam.id_login AND buku.kd_buku = table_pinjam.kd_buku AND table_detail_pinjam.id_pinjam = table_pinjam.id_pinjam AND table_detail_login.id_login = '$id_login' AND table_detail_pinjam.tgl_kembali != '000-00-00 00:00:00'");
            /*$no = 1;*/
            while ($pinjam = mysqli_fetch_array($queryinfo)) {
            ?>
              <tr>
                <td><?= $pinjam['tgl_pinjam'] ?></td>
                <td><?= $pinjam['nama_depan'] ?> <?= $pinjam['nama_belakang'] ?></td>
                <td class="center"><?= $pinjam['judul_buku'] ?></td>
                <td class="center"><a href="pinjam.php?hapus=ok&id_pinjam=<?= $pinjam['id_pinjam'] ?>"><button type="button" class="btn btn-sm btn-danger"><i class="las la-trash-alt"></i> Hapus</button></a></td>
              </tr>

            <?php
            }
            ?>
          </tbody>
        </table>

      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">PERPUSTAKAAN ONLINE<br>
        </script>
      </td>
    </tr>
  </table>
</body>

</html>