<?php
//Inicia a Sessao
session_start();
//Analise se a sessao nao esta nula...
if(!isset($_SESSION["usuarios"]))
{
    header("location:Login Teste.php");
}
$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

$stmt = $conn->prepare("SELECT * FROM filmes WHERE id = ?");
$stmt->execute([$id]);
$filme = $stmt->fetch();

if (!$filme) {
    die("Filme não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filme teste</title>
    <meta name="keywords" content="html, css, js, site">

    <style>
        body
        {
           font-family: arial, Helvetica, sans-serif;
           background-color: white;
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
        #aside-esquerda
        {
            position: absolute;
            top: 20%;
            left: 4%;
        }
        #aside-direita
        {
            position: absolute;
            top: 25%;
            left: 79%;
            right: 4%;
            background-color: #7ebc9e;
            color: white;
        }
        section
        {
            position: absolute;
            top: 20%;
            left: 21%;
            right: 22%;
            text-align: justify;
        }
        #botao-pra-voltar
        {
            position: absolute;
            top: 7.25%;
            left: 4%;
            width: 3%;
        }
    </style>
</head>
<body>
    <header>WORM COFFEE</header>
    <a href="index.php">
        <!-- dps coloca outra imagem --><img src="seta-verde.webp" id="botao-pra-voltar">
    </a>
    <aside id="aside-esquerda">
        <!-- POR FAVOR ARRUMA O TAMANHO DA IMAGEM :( 
        (tira da porcentagem e usa valor fixo tipo cm ou px)-->
        <img src="imagem.php?id=<?= $filme['id'] ?>" style="width: 30%"> <br> <br>
        <p style="font-size: 20px">
            Elenco: <!-- dps eu faço isso -->
        </p>
    </aside>
    <section>
        <div style="font-size: 30px">
            <?=($filme['nome']) ?> <br> <br>
            Nota: <?=($filme['nota']) ?> <!-- Manda as imagens das estrelas q eu do um jeito de deixar bonito -->
        </div>
        <br>
        <!-- Sinopse abaixo -->
        <?=($filme['descricao']) ?>
        <br> <br> <br>
        Tempo de filme:&emsp;&emsp;&emsp;Classificação etária:<br>
        <?=($filme['minutos']) ?> minutos&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?=($filme['idade']) ?> anos
    </section>
    <aside id="aside-direita">
        <img src="imagem_diretor.php?id=<?= $filme['id'] ?>" style="width: 50%"> <?= $filme['diretor'] ?> <!-- preguiça de arrumar, faz a boa ae -->
        <br><br><!-- Descrição do diretor e dnv desculpa mas arruma ae plz, ele n tem mt coisa pra falar --><?= $filme['descricao_diretor'] ?>
    </aside>
</body>
</html>