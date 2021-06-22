<?php
	session_start();
	session_destroy();
	//session_unregister("username");
	//session_unregister("password");
	header("Location: index.php");
?>