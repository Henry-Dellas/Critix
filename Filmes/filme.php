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

$stmt2 = $conn->prepare("SELECT usuario, texto, data_hora FROM comentarios WHERE filme_id = ? ORDER BY data_hora DESC");
$stmt2->execute([$id]);
$comentarios = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
        #comentarios {
            position: absolute;
            top: 90%;
            left: 21%;
            right: 22%;
            background-color: #f4f4f4;
            border-radius: 10px;
            padding: 15px;
            margin-top: 30px;
        }
        .comentario {
            background-color: #e9e9e9;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>WORM COFFEE</header>
    <a href="index.php">
        <!-- dps coloca outra imagem --><img src="seta-verde.webp" id="botao-pra-voltar">
    </a>
    <aside id="aside-esquerda">
        <img src="imagem.php?id=<?= $filme['id'] ?>" style="width: 200px"> <br> <br>
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
    <!-- Seção de comentários -->
    <div id="comentarios">
        <h2>Comentários</h2>

        <?php if ($comentarios): ?>
            <?php foreach ($comentarios as $c): ?>
                <div class="comentario">
                    <strong><?= htmlspecialchars($c['usuario']) ?></strong> — <?= date('d/m/Y H:i', strtotime($c['data_hora'])) ?><br>
                    <?= nl2br(htmlspecialchars($c['texto'])) ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Seja o primeiro a comentar!</p>
        <?php endif; ?>

        <form action="comentario.php" method="post">
            <input type="hidden" name="filme_id" value="<?= htmlspecialchars($id) ?>">
            <textarea name="texto" rows="4" placeholder="Escreva seu comentário..." required></textarea><br><br>
            <button type="submit">Enviar comentário</button>
        </form>
    </div>
</body>
</html>