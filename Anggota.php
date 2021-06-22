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
  <title>Perpustakaan Anggota</title>
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
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Id Anggota</th>
              <th>Nama Anggota</th>
              <th>Email</th>
              <th>Telepon</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $queryanggota = mysqli_query($connect, "SELECT * FROM table_detail_login order by id_login");
            $jumanggota = mysqli_num_rows($queryanggota);
            if ($jumanggota == 0) {
            ?>
              <tr>
                <td colspan="12" class="danger">Data Anggota Masih Kosong</td>
              </tr>
              <?php
            } else {
              while ($anggota = mysqli_fetch_array($queryanggota)) {
              ?>
                <tr>
                  <td><?= $anggota['id_login'] ?></td>
                  <td><?= $anggota['nama_depan'] . ' ' . $anggota['nama_belakang'] ?></td>
                  <td><?= $anggota['email'] ?></td>
                  <td><?= $anggota['telepon'] ?></td>
                  <td class="center"><a href="Anggota.php?hapus=ok&id_login=<?= $anggota['id_login'] ?>"><button type="button" class="btn btn-sm btn-danger"><i class="las la-trash-alt"></i> Hapus</button></a></td>
                </tr>
            <?php
              }
            }
            if (isset($_GET['hapus'])) {
              $id_login = $_GET['id_login'];
              $queryDelLogin = mysqli_query($connect, "DELETE FROM table_login WHERE id_login='$id_login'");

              if ($queryDelLogin) {
                $queryDelLevel = mysqli_query($connect, "DELETE FROM table_level WHERE id_login='$id_login'");
                if ($queryDelLevel) {
                  $queryDelAnggota = mysqli_query($connect, "DELETE FROM table_detail_login WHERE id_login='$id_login'");
                  if ($queryDelAnggota) {
                    echo "<script>alert('Data Anggota Berhasil Dihapus')</script>";
                    echo "<script>window.location.href='Anggota.php';</script>";
                  } else {
                    die('Sayang sekali tapi gagal saudara-saudara!!!' . mysqli_error($connect));
                  }
                } else {
                  die('Sayang sekali tapi gagal saudara-saudara!!!' . mysqli_error($connect));
                }
              } else {
                die('Sayang sekali tapi gagal saudara-saudara!!!' . mysqli_error($connect));
              }
              echo mysqli_error($connect);
            }
            ?>

          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">PERPUSTAKAAN ONLINE<br></td>
    </tr>
  </table>
</body>

</html>