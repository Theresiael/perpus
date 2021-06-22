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
    <title>Perpustakaan Input_Buku</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>

<body>
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                <h1>Selamat Datang di Perpustakaan Online <u><?= $user ?><u></h1>
            </td>
        </tr>
        <tr>
            <td width="100">
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
                <form method="post" action="input_buku.php">
                    <table><br>

                        <div class="form-group row">
                            <label class="control-label col-sm-2" for="judul">Judul Buku :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="judul" placeholder="Masukkan Judul" name="judul">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-2" for="pengarang">Pengarang :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pengarang" placeholder="Masukkan Pengarang" name="pengarang">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-sm-2" for="penerbit">Penerbit Buku:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="penerbit" placeholder="Masukkan Penerbit" name="penerbit">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" name="submit" class="btn btn-primary"><i class="far fa-save"></i> Simpan</button>
                                <button type="reset" name="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Hapus</button>
                                <!--a href="logout.php" class="btn btn-dark"><i class="fas fa-sign-out-alt"></i> Logout</a-->
                            </div>
                        </div><br><br>
                    </table>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    $judul = $_POST['judul'];
                    $pengarang = $_POST['pengarang'];
                    $penerbit = $_POST['penerbit'];

                    $queryinsert = mysqli_query($connect, "INSERT INTO buku VALUES ('', '$judul','$pengarang', '$penerbit')");
                    echo mysqli_error($connect);

                    if ($queryinsert) {
                        echo "<script>alert('Data Buku Berhasil Ditambahkan')</script>";
                        echo "<script>window.location.href='buku.php'</script>";
                    } else {
                        die('Data Gagal Ditambahkan!' . mysqli_error($connect));
                    }
                }
                ?>

            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">PERPUSTAKAAN ONLINE<br></script>
            </td>
        </tr>
    </table>
</body>

</html>