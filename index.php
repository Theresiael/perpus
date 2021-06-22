<style>
        body {
                font-family: sans-serif;
                /*background: #ebf9fb;*/
                position: fixed;
                top: 0;
                left: 0;
                content: '';
                width: 100%;
                height: 100%;

                background-image: url('images/img.jpg');
                background-position-y: top;
                background-color: pink;
                -webkit-background-size: cover;
                background-size: cover;
                z-index: -1;

        }

        h1 {
                text-align: center;
                /*ketebalan font*/
                font-weight: 1000;
                color: #FF1493;
        }

        .tulisan_atas {
                text-align: center;
                /*membuat semua huruf menjadi kapital*/
                text-transform: uppercase;
        }

        .panel_login {
                width: 350px;
                background: white;
                /*meletakkan form ke tengah*/
                margin: 80px auto;
                padding: 30px 20px;
                box-shadow: 0px 0px 100px 4px #d6d6d6;
        }

        label {
                font-size: 11pt;
        }

        .form_login {
                /*membuat lebar form penuh*/
                box-sizing: border-box;
                width: 100%;
                padding: 10px;
                font-size: 11pt;
                margin-bottom: 20px;
        }

        .tombol_login {
                background: #FF1493;
                color: white;
                font-size: 11pt;
                width: 100%;
                border: none;
                border-radius: 3px;
                padding: 10px 20px;
        }

        .link {
                color: #232323;
                text-decoration: none;
                font-size: 10pt;
        }

        .alert {
                background: #e44e4e;
                color: white;
                padding: 10px;
                text-align: center;
                border: 1px solid #b32929;
        }

        a {
                background: white;
                color: #FF1493;
                font-size: 11pt;
                width: 100%;
                border: none;
                border-radius: 3px;
                padding: 10px 20px;
                margin-left: 100px;
        }
</style>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include 'koneksi.php';
session_start();
if (isset($_POST['login'])) {
        $user = mysqli_real_escape_string($connect, trim(strip_tags(@$_POST['username'])));// utk menghalangi 'OR 1=1--
        $pass = mysqli_real_escape_string($connect, trim(strip_tags(@$_POST['password'])));
        $login = mysqli_query($connect, "SELECT * FROM table_login WHERE username='$user' and password='$pass'");
        //menghitung jumlah data yang ditemukan
        $cek = mysqli_num_rows($login);
        $info = mysqli_fetch_array($login);
        $id_login = $info['id_login'];

        if ($cek > 0) {
                //dicek antara Admin atau User
                $cekAdmin = mysqli_query($connect, "SELECT * FROM table_level WHERE id_login='$id_login' AND level='admin'");
                $cekLevel = mysqli_num_rows($cekAdmin);

                if ($cekLevel > 0) {
                        $_SESSION['username'] = $user;
                        header("Location: dashboard.php");
                } else {
                        $_SESSION['username'] = $user;
                        header("Location:dashboard.php");
                }
        } else {
                echo "<script>alert('Username atau Password Salah!!!')</script>";
                echo "<script>window.location.href='index.php'</script>";
        }
}
?>
<!DOCTYPE html>
<html>
<head>
        <title>LOGIN</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>

        <h1>WEBSITE PERPUSTAKAAN <br /> UNIVERSITAS ATMA JAYA MAKASSAR</h1>

        <div class="panel_login">
                <p class="tulisan_atas">SILAHKAN MASUK</p>

                <form action="index.php" method="post">
                        <label>Username</label>
                        <input type="text" name="username" class="form_login" placeholder="Username" required="required">

                        <label>Password</label>
                        <input type="password" name="password" class="form_login" placeholder="Password" required="required">

                        <button type="submit" name="login" class="btn btn-info log tombol_login" value="LOGIN"><i class="las la-sign-in-alt"></i> LOGIN</button>
                        <hr><br>
                        <a href="regis.php" class="btn btn-primary btn-block"><i class="las la-plus"></i> Create Account</a>
                </form>

        </div>

</body>
</html>