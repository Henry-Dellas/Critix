<?php
//Inicia a Sessao
session_start();
//Analise se a sessao nao esta nula...
if(!isset($_SESSION["usuarios"]))
{
    header("location:Login Teste.php");
}
$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
$stmt = $conn->query("SELECT id, nome, imagem FROM filmes");
$filmes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página dos filmes</title>
    <meta name="keywords" content="html, css, js, site">

    <style>
        *{padding:0;margin:0;
        vertical-align:baseline;
        list-style:none;border:0
        }
        html, body 
        {
            margin: 0;
            padding: 0; 
        }
        body 
        {
            width: 100vw; 
            height: 100vh;
            box-sizing: border-box; 
            font-family: arial, Helvetica, sans-serif;
            background-image: white;
        }
        #div-bemvindo
        {
            background-color: #7ebc9e;
            position: absolute;
            top: 60%;
            left: 20%;
            transform: translate(-50%, -50%);
            padding: 100px;
            border-radius: 15px;
            color: white;
            text-align: center;
        }
        #div-faixa
        {
            background-color: white;
            position: absolute;
            top: 14.8%;
            left: 0%;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 38.36%;
            padding-right: 38.36%;
        }
        input
        {
            padding: 15px;
            border: none;
            outline: none;
            font-size: 15px;
        }
        #button
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
        #div-img
        {
            position: relative;
            top: 300px;
            left: 1200px;
            transform: translate(-50%, -50%);
        }
        header
        {
            color: white;
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            font-family: fantasy;
            background: #7ebc9e;
            width: 100%;
            text-align: center;
                      
        }
        #div-filmes
        {
            background-color: rgba(0, 0, 0, 0.9);
            position: absolute;
            top: 1000px;
            left: 70%;
            transform: translate(-50%, -50%);
            padding: 130px;
            border-radius: 15px;
            color: white;
            height: 700px;
            width: 600px;
           
        }
    </style>
</head>
<body>

    <header>WORM COFFEE</header>
    <div id="div-faixa">
        <p>
            <h1>Bem-Vindo, <?php echo $_SESSION["usuarios"]?>.</h1>
        </p>
    </div>
    <main>
        <div id="div-bemvindo">
            <p>Bom dia <?php echo $_SESSION["usuarios"]?>, a sua senha é <?php echo $_SESSION ["senha"]?></p>
            <br>
            <p>
                <a href="../Cadastro_Login/logout.php" id="button">Sair da conta</a>
            </p>   
        </div>
        <div id="div-img">
            <?php foreach ($filmes as $filme): ?>
                <a href="filme.php?id=<?= $filme['id'] ?>"><img src="imagem.php?id=<?= $filme['id'] ?>" style="width: 150px"></a>  
            <?php endforeach; ?>
        </div>
    </main>
    
  
    
</body>
</html>