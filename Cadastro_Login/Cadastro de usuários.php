<?php
//Iniciando a Sessão
session_start();
//Analisando se a variável é considerada definida, isto é, está declarada e é diferente de null
if(isset($_SESSION["usuario"]))
{
    header("location: ../Filmes/index.php");
}
if(!empty($_POST["usuario"]) and !empty($_POST["senha"]))
{
    //string de conexão
    $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
    //String SQL
    $sql = "SELECT * FROM usuarios where nome = '".$_POST['usuario']."' and senha = '".$_POST['senha']. "'";

    //Executando SQL com a conexão, guardando na string $result
    $result = $conn->query($sql);

    //PDO (PHP Data Object), classe que representa a connection entre PHP e o database server.
    $usuario = $result->fetch(PDO::FETCH_ASSOC);

    if(!empty($usuario))
    {
        $_SESSION["usuario"] = $usuario["nome"];
        $_SESSION["email"] = $usuario["email"];
        header("location: ../Filmes/index.php");
    }
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <meta name="keywords" content="html, css, js, site">

    <style>
        body
        {
           font-family: arial, Helvetica, sans-serif;
           background-image: linear-gradient(45deg, black,purple);
        }
        div
        {
            background-color: rgba(0,0,0,0.9);
           position: absolute;
           top: 50%;
           left: 50%;
           transform: translate(-50%, -50%);
           padding: 70px;
           border-radius: 15px;
           color: white;
        }
        input
        {
           padding: 15px;
           border: none;
           outline: none;
           font-size: 15px;
        }
        button
        {
           background-color:crimson;
           border: none;
           padding: 15px;
           width: 100%;
           border-radius: 15px;
           color: white;
           font-size: 15px;
           cursor: pointer;
        }
        button:hover
        {
            background-color:lightskyblue;
        }
    </style>
</head>
<body>

    <form action="Login Teste.php" method="post">
    <div>
        <h1>Login</h1>
        <input type="text" id="Usuarios" name="Usuarios" placeholder="nome">
        <br><br>
        <label for="senha">Senha</label><br>
        <input type="password" id="senha" name="senha" placeholder="senha">
        <br><br>
        <button>Enviar</button>
    </div>
    </form>
       
</body>
</html>