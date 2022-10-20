<?php
    include_once "conexao.php";
    if (isset($_GET['cod'], $_GET['id'])){
        $id = $_GET['id'];
        $cod = $_GET['cod'];
        $sql = "DELETE FROM ";
        switch ($cod){
            case 1:
                $sql .= "categoria ";
                $page = "categorias.php";
                break;
            case 2:
                    $sql .= "carta ";
                    $page = "cartas.php";
                break;
            case 3:
                $sql .= "material ";
                $page = "materiais.php";
                break;
            case 4:
                $sql .= "calendario ";
                $page = "calendario.php";
                break;
        }
        $sql .= "WHERE id = $id";
        mysqli_query($conn, $sql);
        echo "<script>window.location.replace('$page');</script>";

    }
