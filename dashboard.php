<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include "koneksi.php";
include "cekSession.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" href="index2.css">
</head>

<body>

    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span> <span>Perpustakaan </span></h2>
        </div>

        <div class="sidebar-menu">
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
                    <li>
                        <a href="dashboard.php" class="active"><span class="las la-igloo"></span>
                            <span>Dashboard</span></a>
                    </li>

                    <li>
                        <a href="anggota.php"><span class="las la-users"></span>
                            <span>Anggota</span></a>
                    </li>

                    <li>
                        <a href="buku.php"><span class="las la-book"></span>
                            <span>Buku</span></a>
                    </li>

                    <li>
                        <a href="pinjam.php"><span class="las la-clipboard-list"></span>
                            <span>Pinjaman dan Pengembalian Buku</span></a>
                    </li>
                <?php
                } else {
                ?>
                    <li>
                        <a href="dashboard.php" class="active"><span class="las la-igloo"></span>
                            <span>Dashboard</span></a>
                    </li>

                    <li>
                        <a href="pinjam.php"><span class="las la-clipboard-list"></span>
                            <span>Pinjaman dan Pengembalian Buku</span></a>
                    </li>
                <?php
                }
                ?>

            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Dashboard
            </h2>

            <!--div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Cari disini" />
            </div>

            <div class="user-wrapper">
                <img src="images/1.jpg" width="40px" height="40px" alt="">
                <div>
                    <h4>Agat Elsa</h4>
                    <small>Super Admin</small>
                </div>
            </div-->

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right navbar-user">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php
                            echo $_SESSION['username'];
                            ?>
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php" onclick="return confirm('Apakah anda akan keluar?');"><i class="fa fa-power-off"></i> Keluar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </header>

        <main>

            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Data Transaksi</h3>

                            <button>Lihat Semua <span class="las la-arrow-right"></span></button>
                        </div>
                        <div class="card-body">
                            <table width="100%">
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
                                                <!--td></*?php echo $no?>*/</td-->
                                                <td><?= $pinjam['tgl_pinjam'] ?></td>
                                                <td><?= $pinjam['nama_depan'] ?> <?= $pinjam['nama_belakang'] ?></td>
                                                <td class="center"><?= $pinjam['judul_buku'] ?></td>
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
                                        $queryDeletePinjam = mysqli_query($conncet, "DELETE FROM table_detail_pinjam WHERE id_pinjam='$id_pinjam'");
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
                                            </tr>

                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>

</html>