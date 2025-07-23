<html>
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

    <div>
        <form action="Login Teste.php" method="post">
            <h1>Login de Acesso</h1>
            <label for="text">Nome</label><br>
            <input type="text" id="usuarios" name="usuarios" placeholder="nome">
            <br><br>
            <label for="senha">Senha</label><br>
            <input type="password" id="senha" name="senha" placeholder="senha">
            <br><br>
            <button>Enviar</button>
        </form>
        <br><br>
        <a href="Cadastro.html" 
        style="background-color: dodgerblue; 
        padding-top: 15px;
        padding-bottom: 15px;
        padding-left: 97px;
        padding-right: 97px;
        text-align: center;
        border-radius: 15px;
        color: white;
        font-size: 15px;
        cursor: pointer;">Cadastro</a>
    </div>

    <img src="PoderosoChefao.png">
    
    
</body>
</html>

<?php
    include 'Login.php';
?>

