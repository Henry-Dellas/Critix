<?php
//Inicia a Sessao
session_start();
//Analisando se a variável é considerada definida, isto é,
//está declarada e é diferente de null
if(isset($_SESSION["usuarios"]))
{
    header("location: index.php");
}
if(!empty($_POST["usuarios"]) and !empty($_POST["senha"]))
{
    //string de conexão
    $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
    //string SQL
    $sql = "SELECT * FROM usuarios where nome ='".$_POST['usuarios']."' and senha ='".$_POST['senha']. "'";
    //Executando SQL com a conexão, guardando na string
    $result = $conn->query($sql);
    //PDO(PHP Data Object), classe que representa a connection entre PHP e o database server
    $Usuários = $result->fetch(PDO::FETCH_ASSOC);
    if(!empty($Usuários))
    {
        $_SESSION["usuarios"] = $Usuários["nome"];
        $_SESSION["senha"] = $Usuários["senha"];
        header("location: index.php");
    }
}
?>