<?php
session_start();
if(isset($_SESSION["usuario"]))
{
    header("location: ../Filmes/index.php");
}
if(!empty($_POST["usuario"]) and !empty($_POST["senha"]))
{
    $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "amogus");
    $sql = "SELECT * FROM usuarios where nome = '".$_POST['usuario']."' and senha = '".$_POST['senha']. "'";
    $result = $conn->query($sql);
    $usuario = $result->fetch(PDO::FETCH_ASSOC);

    if(!empty($usuario))
    {
        $_SESSION["usuario"] = $usuario["nome"];
        $_SESSION["email"] = $usuario["email"];
        header("location: ../Filmes/index.php");
    }
}
?>