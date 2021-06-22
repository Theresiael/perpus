<?php
error_reporting(E_ALL ^ E_NOTICE);
include "koneksi.php";
include "cekSession.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan Buku</title>
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
      </td>
      <td width="500">
        <a href="input_buku.php"><i class="las la-file"></i>Input buku</a>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Kode Buku </th>
              <th>Judul Buku </th>
              <th>Pengarang </th>
              <th>Penerbit</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $querybuku = mysqli_query($connect, "SELECT * FROM buku order by kd_buku");
            $jumbuku = mysqli_num_rows($querybuku);
            if ($jumbuku == 0) {
            ?>
              <tr>
                <td colspan="12" class="danger">Data Buku Masih Kosong</td>
              </tr>
              <?php
            } else {
              while ($buku = mysqli_fetch_array($querybuku)) {
              ?>
                <tr>
                  <td><?= $buku['kd_buku'] ?></td>
                  <td><?= $buku['judul_buku'] ?></td>
                  <td><?= $buku['pengarang'] ?></td>
                  <td><?= $buku['penerbit'] ?></td>
                  <td><a href="editBuku.php?kd_buku=<?= $buku['kd_buku'] ?>"><button type="button" class="btn btn-sm btn-info"><i class="las la-pen-fancy"></i> Edit</button></a></td>
                  <td><a href="buku.php?hapus=ok&kd_buku=<?= $buku['kd_buku'] ?>"><button type="button" class="btn btn-sm btn-danger"><i class="las la-trash-alt"></i> Hapus</button></a></td>
                </tr>

            <?php
              }
            }
            if (isset($_GET['hapus'])) {
              $kd_buku = $_GET['kd_buku'];
              $querydelete = mysqli_query($connect, "DELETE FROM buku WHERE kd_buku='$kd_buku'");
              if ($querydelete) {
                echo "<script>alert('Data Buku Berhasil Dihapus')</script>";
                echo "<script>window.location.href='buku.php'</script>";
              } else {
                die('Data Gagal Dihapus!' . mysqli_error($connect));
              }
            }
            ?>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">PERPUSTAKAAN ONLINE<br></script>
      </td>
    </tr>
  </table>
</body>

</html>