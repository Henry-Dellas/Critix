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
        body
        {
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
        img
        {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10%;
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
           top: 89.6%;
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
            <p>
                <a href="logout.php" id="button">Sair da conta</a>
            </p>   
        </div>
        <!-- Peço pra tu dar um jeito de separar as imagens, tem 2 filmes mas só aparece o segundo -->
        <?php foreach ($filmes as $filme): ?>
            <a href="filme.php?id=<?= $filme['id'] ?>"><img src="imagem.php?id=<?= $filme['id'] ?>"></a>  
        <?php endforeach; ?>
    </main>
    
  
    
</body>
</html>