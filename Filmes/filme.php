<?php
session_start();
if(!isset($_SESSION["usuarios"])) {
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

$stmt2 = $conn->prepare("SELECT usuario, texto, data_hora, nota FROM comentarios WHERE filme_id = ? ORDER BY data_hora ASC");
$stmt2->execute([$id]);
$comentarios = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$mediaStmt = $conn->prepare("SELECT ROUND(AVG(nota), 1) AS media FROM comentarios WHERE filme_id = ?");
$mediaStmt->execute([$id]);
$media = $mediaStmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Critix</title>
<link rel="shortcut icon" href="Adobe_Express_-_file40px.png" type="image/x-icon">

<style>
:root {
    --branco-gelo: #F8F9FA;
    --cinza-escuro: #343A40;
    --azul-petroleo: #007B83;
    --coral: #FF6B6B;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Poppins", Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #1e1e2f, #007B83);
    background-size: 800% 800%;
    animation: gradientMove 120s ease infinite;
    color: var(--branco-gelo);
    height: 100vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

#emoji-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
}
.emoji {
    position: absolute;
    font-size: 24px;
    animation: float 10s linear infinite;
    opacity: 0.5 + Math.random()*0.5;
}
@keyframes float {
    0% { transform: translateY(100vh) rotate(0deg); }
    100% { transform: translateY(-10vh) rotate(360deg); }
}

header {
    font-family: "Cinzel", serif;
    font-size: 65px;
    text-align: center;
    color: var(--coral);
    text-shadow: 0 0 20px rgba(255,107,107,0.7);
    margin: 15px 0;
    letter-spacing: 2px;
    z-index: 2;
}

#botao-voltar {
    position: absolute;
    top: 20px;
    left: 25px;
    width: 30px;     
    height: 30px;     
    border-left: 3px solid var(--coral);
    border-bottom: 3px solid var(--coral);
    transform: rotate(45deg);
    cursor: pointer;
    transition: transform 0.2s;
    z-index: 2;
}
#botao-voltar:hover {
    transform: rotate(45deg) scale(1.2);
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 25px;
    width: 95%;
    max-width: 1200px;
    height: 78vh;
    padding: 10px;
    z-index: 2;
}

#aside-esquerda {
    flex: 1 1 240px;
    text-align: center;
}
#aside-esquerda img {
    width: 100%;
    max-width: 250px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
}
#aside-esquerda p { margin-top: 12px; font-size: 16px; }

section {
    flex: 2 1 500px;
    background-color: #343A40; 
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    text-align: justify;
    overflow-y: auto;
    max-height: 72vh;
    scrollbar-width: thin;
    scrollbar-color: var(--coral) transparent;
}
section::-webkit-scrollbar { width: 6px; }
section::-webkit-scrollbar-thumb { background: var(--coral); border-radius: 10px; }

section h1 {
    font-size: 26px;
    color: var(--coral);
    margin-bottom: 12px;
}
section p {
    font-size: 16.5px;
    margin-bottom: 10px;
    line-height: 1.6;
}
section p strong {
    color: var(--coral);
}

#aside-direita {
    flex: 1 1 240px;
    background-color: #343A40; 
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    text-align: center;
}
#aside-direita img {
    width: 80%;
    max-width: 110px;
    border-radius: 50%;
    margin-bottom: 10px;
}
#aside-direita p { font-size: 15.5px; margin-bottom: 8px; }

@media(max-width: 900px){
    .container {
        flex-direction: column;
        height: auto;
        overflow-y: auto;
        padding-bottom: 40px;
    }
    header { font-size: 42px; }
    section { max-height: none; }
}
</style>
</head>
<body>

<div id="emoji-bg"></div>

<header>Critix</header>
<a href="index.php" id="botao-voltar"></a>

<div class="container">
    <aside id="aside-esquerda">
        <img src="imagem.php?id=<?= $filme['id'] ?>" alt="<?= htmlspecialchars($filme['nome']) ?>">
        <p><strong>Elenco:</strong> <!-- preencher depois --></p>
    </aside>

    <section>
        <h1><?= htmlspecialchars($filme['nome']) ?></h1>
        <p><strong>Nota:</strong> <?= htmlspecialchars($filme['nota']) ?></p>
        <p><?= nl2br(htmlspecialchars($filme['descricao'])) ?></p>
        <p><strong>Duração:</strong> <?= htmlspecialchars($filme['minutos']) ?> minutos</p>
        <p><strong>Classificação etária:</strong> <?= htmlspecialchars($filme['idade']) ?> anos</p>
    </section>

    <aside id="aside-direita">
        <img src="imagem_diretor.php?id=<?= $filme['id'] ?>" alt="<?= htmlspecialchars($filme['diretor']) ?>">
        <p><strong><?= htmlspecialchars($filme['diretor']) ?></strong></p>
        <p><?= nl2br(htmlspecialchars($filme['descricao_diretor'])) ?></p>
    </aside>
    <!-- Seção de comentários -->
    <div id="comentarios">
        <h2>Comentários</h2>

        <form action="comentario.php" method="post">
            <input type="hidden" name="filme_id" value="<?= htmlspecialchars($id) ?>">
            <label>Avaliação (0 a 10):</label><br>
            <div class="notas">
                <?php for ($i = 10; $i >= 0; $i--): ?>
                <input type="radio" id="nota<?= $i ?>" name="nota" value="<?= $i ?>" required>
                <label for="nota<?= $i ?>"><?= $i ?></label>
                <?php endfor; ?>
            </div>
            <textarea name="texto" rows="4" placeholder="Escreva seu comentário..." required></textarea> <br>
            <input type="checkbox" id="spoiler" name="spoiler" value=true>
            <label for="spoiler"> Comentário com spoiler?</label><br><br>
            <button type="submit">Enviar comentário</button>
        </form>
        <hr>
        <?php if ($comentarios): ?>
            <?php foreach ($comentarios as $c): ?>
                <div class="comentario">
                    <strong><?= htmlspecialchars($c['usuario']) ?></strong> — <?= htmlspecialchars($c['nota']) ?> — <?= date('d/m/Y H:i', strtotime($c['data_hora'])) ?><br>
                    <?= nl2br(htmlspecialchars($c['texto'])) ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Seja o primeiro a comentar!</p>
        <?php endif; ?>
    </div>
</div>

<script>
const emojis = ['🎬','🍿','🎥','⭐','🎭','🎟️','📽️','🎫','🎞️','👏'];
const emojiContainer = document.getElementById('emoji-bg');

for(let i=0; i<30; i++){
    const span = document.createElement('span');
    span.classList.add('emoji');
    span.textContent = emojis[Math.floor(Math.random()*emojis.length)];
    span.style.left = Math.random()*100 + 'vw';
    span.style.fontSize = 16 + Math.random()*28 + 'px';
    span.style.animationDuration = 6 + Math.random()*8 + 's';
    span.style.opacity = 0.5 + Math.random()*0.5;
    emojiContainer.appendChild(span);
}
</script>

</body>
</html>