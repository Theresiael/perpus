<?php
    error_reporting(E_ALL ^ E_NOTICE);
    include "koneksi.php";
	session_start();
	$user = $_SESSION['username'];
	$pass = $_SESSION['password'];
	
	if (!isset($user))
	{
		?>
		<script>
			alert('Session Habis');
			document.location='index.php';
		</script>
		<?php
		exit;
	}
?>