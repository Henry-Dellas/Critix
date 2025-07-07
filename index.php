<?php
//Inicia a Sessao
session_start();
//Analise se a sessao nao esta nula...
if(!isset($_SESSION["usuarios"]))
{
    header("location:Login Teste.php");
}
?>
<!DOCTYPE html>
<html lang="en">
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
        #div-bemvindo
        {
           background-color: rgba(0, 0, 0, 0.9);
           position: absolute;
           top: 50%;
           left: 20%;
           transform: translate(-50%, -50%);
           padding: 100px;
           border-radius: 15px;
           color: white;
           text-align: center;
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
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40%;
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
            background: black;
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
    <main>
    <div id="div-bemvindo">
        <h1>Bem-Vindo. <?php echo $_SESSION["usuarios"]?></h1>
        <p>Bom dia <?php echo $_SESSION["usuarios"]?>, a sua senha é <?php echo $_SESSION ["senha"]?></p>
        <p>
            <a href="logout.php" class="btn btn-danger ml-3">Sair da conta</a>
        </p>   
    </div>
    
    </main>
    
  
    
</body>
</html>