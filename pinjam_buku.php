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
    <title>Perpustakaan Pinjam_Buku</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>
<?php
$cekIDL = mysqli_query($connect, "SELECT id_login FROM table_login WHERE username='$user'");
$infoL = mysqli_fetch_array($cekIDL);
$id_login = $infoL['id_login'];

$cekId = mysqli_query($connect, "SELECT nama_depan, nama_belakang FROM table_detail_login WHERE id_login='$id_login'");
$info = mysqli_fetch_array($cekId);
$nama_depan = $info['nama_depan'];
$nama_belakang = $info['nama_belakang'];
?>

<body>
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                <h1>Selamat Datang Peminjaman Perpustakaan <u><?= $user ?><u></h1>
            </td>
        </tr>
        <tr>
            <td width=" 200">
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
                <form method="post" action="pinjam_buku.php">
                    <table class="table table-bordered">
                        <div class="form-group row">
                            <label class="control-label col-sm-2" for="np">Nama Peminjam :</label>
                            <div class="col-sm-4">
                                <input type="text" id="np" value="<?php echo $nama_depan . ' ' . $nama_belakang; ?>" name="np" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-2" for="jb">Judul Buku :</label>
                            <div class="col-sm-4">
                                <?php
                                $sql_buku = mysqli_query($connect, "SELECT * FROM buku ORDER BY kd_buku");
                                $kueri_buku = ($sql_buku) or die(mysqli_error($connect));
                                ?>
                                <select name="buku">
                                    <?php
                                    while (list($kode, $nama_status) = mysqli_fetch_array($kueri_buku)) {
                                    ?>
                                        <option value="<?= $kode ?>"><?= $nama_status ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" name="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                                <!--button type="reset" name="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Hapus</button>
                                <a href="logout.php" class="btn btn-dark"><i class="fas fa-sign-out-alt"></i> Logout</a-->
                            </div>
                        </div><br><br>
                    </table>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    $buku  = $_POST['buku'];

                    date_default_timezone_set('Asia/Makassar');
                    $tgl = date("Y-m-d H:i:sa");

                    $queryirt = mysqli_query($connect, "INSERT INTO table_detail_pinjam (tgl_pinjam) VALUES ('$tgl')");
                    echo mysqli_error($connect);

                    if ($queryirt) {
                        $cekPinjam = mysqli_query($connect, "SELECT id_pinjam FROM table_detail_pinjam WHERE tgl_pinjam='$tgl'");
                        $infoPinjam = mysqli_fetch_array($cekPinjam);
                        $id_pinjam = $infoPinjam['id_pinjam'];

                        $queryPinjam = mysqli_query($connect, "INSERT INTO table_pinjam (id_pinjam, id_login, kd_buku) VALUES ('$id_pinjam', '$id_login', '$buku')");
                        if ($queryPinjam) {
                            echo "<script>alert('Buku Berhasil dipinjam.')</script>";
                            echo "<script>window.location.href='pinjam.php';</script>";
                        } else {
                            echo "<script>alert('Sayang Sekali Gagal dipinjam Saudara-saudara!!!')</script>";
                            echo "<script>window.location.href='pinjam_buku.php';</script>";
                        }
                    } else {
                        die('Sayang Sekali Gagal Saudara-saudara!!!' . mysqli_error($connect));
                    }
                }
                ?>

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