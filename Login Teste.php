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
    $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "amogus");
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

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Acesso</title>
    <meta name="keywords" content="html, css, js, site">

    <style>
        body
        {
           font-family: arial, Helvetica, sans-serif;
           background-image: linear-gradient(45deg, black,purple);
        }
        div
        {
           background-color: rgba(0, 0, 0, 0.9);
           position: absolute;
           top: 50%;
           left: 20%;
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
        img
        {
            position: absolute;
            top: 45%;
            left: 70%;
            transform: translate(-50%, -50%);
            width: 40%;
        }
    </style>
</head>
<body>

    <form action="Login Teste.php" method="post">
    <div>
        <h1>Login de Acesso</h1>
        <label for="text">Nome</label><br>
        <input type="text" id="usuarios" name="usuarios" placeholder="nome">
        <br><br>
        <label for="senha">Senha</label><br>
        <input type="password" id="senha" name="senha" placeholder="senha">
        <br><br>
        <button>
        <a href="Cadastro.html" class="btn btn-danger ml-3">Cadastrar Usuários</a>
        </button>
        <br><br>
        <button>Enviar</button>
    </div>
    </form>

    <img src="PoderosoChefao.png">
    
    
</body>
</html>