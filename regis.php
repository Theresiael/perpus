<?php
    error_reporting(E_ALL ^ E_NOTICE);
    include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Perpustakaan</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>
<body>
    <h1><b>WEBSITE PERPUSTAKAAN <br/> UNIVERSITAS ATMA JAYA MAKASSAR</b></h1>
    <div class="panel_login container">
    <h2 class="tulisan_atas">SILAHKAN REGISTRASI</h2>

    <form action="regis.php" method="post">
        <div class="form-group row">
            <label for="nama_depan" class="col-md-2">Nama Depan :</label>
            <input type="text" name="nama_depan" class="form_login col-md-2" placeholder="Nama Depan" required="required">
        </div>

        <div class="form-group row">
            <label for="nama_belakang" class="col-md-2">Nama Belakang :</label>
            <input type="text" name="nama_belakang" class="form_login col-md-2" placeholder="Nama Belakang" required="required">
        </div>
        
        <div class="form-group row">
            <label for="email" class="col-md-2">Email :</label>
            <input type="text" name="email" class="form_login col-md-2" placeholder="Email" required="required">
        </div>

        <div class="form-group row">
            <label for="telepon" class="col-md-2">Telepon :</label>
            <input type="telepon" name="telepon" class="form_login col-md-2" placeholder="Telepon" required="required">
        </div>

        <div class="form-group row">
            <label for="username" class="col-md-2">Username :</label>
            <input type="text" name="username" class="form_login col-md-2" placeholder="Username" required="required">
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-2">Password :</label>
            <input type="password" name="password" class="form_login col-md-2" placeholder="Password" required="required">
        </div>

        <button type="submit" name="regis" class="btn btn-info log tombol_login" value="REGIS"><i class="las la-sign-in-alt"></i> REGIS</button>
    </form>
    
    <?php
        if (isset($_POST['regis'])){
            $nd = $_POST['nama_depan'];
            $nb  = $_POST['nama_belakang'];
            $email = $_POST['email'];
            $telepon  = $_POST['telepon'];
            $user = $_POST['username'];
            $pass  = $_POST['password'];

            $queryinsert = mysqli_query($connect, "INSERT INTO table_detail_login VALUES ('', '$nd','$nb','$email', '$telepon')");
            if($queryinsert){
                //Mengambil id_login
                $cekId = mysqli_query($connect, "SELECT id_login FROM table_detail_login WHERE nama_depan='$nd'AND nama_belakang='$nb' AND email='$email' AND telepon='$telepon'");
                $info = mysqli_fetch_array($cekId);
                $id_login = $info['id_login'];

                $queryLogin = mysqli_query($connect, "INSERT INTO table_login (id_login, username, password) VALUES ('$id_login', '$user','$pass')");
                if($queryLogin){
                    //Mengambil id_login
                    $cekId2 = mysqli_query($connect, "SELECT id_login FROM table_detail_login WHERE nama_depan='$nd' AND nama_belakang='$nb' AND email='$email' AND telepon='$telepon'");
                    $info2 = mysqli_fetch_array($cekId2);
                    $id_login = $info2['id_login'];
                    
                    $queryLevel = mysqli_query($connect, "INSERT INTO table_level (id_login,level) VALUES ('$id_login','user')");
                    if($queryLevel){
                        echo "<script>alert('Akun Berhasil dibuat. Silahkan Login')</script>";
                        echo "<script>window.location.href='index.php'</script>";
                    }else{
                        die('Level Gagal Dibuat!'.mysqli_error($connect));
                    }
                }else{
                    die('Login Gagal Dibuat!'.mysqli_error($connect));
                }
            }
            else{
                die('Akun Gagal Dibuat!' .mysqli_error($connect));
            }
            echo mysqli_error($connect);
        }
    ?>
    </div>
</body>
</html>