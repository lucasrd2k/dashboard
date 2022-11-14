<?php
	$servidor = "localhost";
	// $usuario = "hellmann";
	$usuario = "root";
	// $senha = "VPSHellmann123@";
	$senha = "";
	$dbname = "coacher";
	
	//Criar a conexao
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

?>