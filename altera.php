<?php
    include_once "conexao.php";
    $id = $_GET['id'];
    $nivel = $_GET['nivel'];
    $nivel = $nivel ? 0 : 1;
    if (mysqli_query($conn, "UPDATE cliente SET nivel = $nivel WHERE id = $id")){
        header ("Location: dashboard.php");
    }
?>