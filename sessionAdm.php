<?php
	if (!isset($_SESSION)){
		session_start();
		session_write_close();
	}
	if (isset($_SESSION["id"]) && !empty($_SESSION["id"]) && $_SESSION['admin']){
		$ids = $_SESSION['id'];
		$nomes = $_SESSION['nome'];
	}
	else{
		header ("Location: index.php");
        echo "<script>window.location.replace('login.php');</script>";
	}
?>