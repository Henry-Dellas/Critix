<?php
session_start();
if (!isset($_SESSION["usuarios"])) {
    header("location:Login Teste.php");
    exit;
}

$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

// Busca dados do filme
$stmt = $conn->prepare("SELECT * FROM filmes WHERE id = ?");
$stmt->execute([$id]);
$filme = $stmt->fetch();
if (!$filme) {
    die("Filme não encontrado.");
}

// Busca comentários
$stmt2 = $conn->prepare("SELECT usuario, texto, data_hora, nota FROM comentarios WHERE filme_id = ? ORDER BY data_hora ASC");
$stmt2->execute([$id]);
$comentarios = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Critix</title>
<link rel="shortcut icon" href="Adobe_Express_-_file40px.png" type="image/x-icon">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
:root {
    --coral: #FF6B6B;
    --cinza: #1e1e2f;
    --cinza-claro: #2a2a40;
    --texto: #f5f5f5;
    --cinza-div: #343A40;
    --cinza-diretor: rgba(30,30,40,0.95);
    --estrela-cheia: #FFD700;
}

* { margin:0; padding:0; box-sizing:border-box; font-family: "Poppins", sans-serif; }
html, body { width:100vw; min-height:100vh; overflow-x: hidden; }

body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 20px;
    color: var(--texto);
    background: linear-gradient(135deg, var(--cinza), #007B83);
    background-size: 800% 800%;
    animation: gradientMove 120s ease infinite;
}
@keyframes gradientMove { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

header {
    font-family: "Cinzel", serif;
    font-size: 70px;
    color: var(--coral);
    text-shadow: 0 0 25px rgba(255,107,107,0.7);
    margin-bottom: 30px;
    text-align: center;
    z-index: 2;
}

#botao-voltar {
    position: absolute;
    top: 20px;
    left: 25px;
    width: 32px;
    height: 32px;
    border-left: 3px solid var(--coral);
    border-bottom: 3px solid var(--coral);
    transform: rotate(45deg);
    cursor: pointer;
    transition: transform 0.2s;
}
#botao-voltar:hover { transform: rotate(45deg) scale(1.2); }

/* CARD OPACO */
.card {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    width: 90%;
    max-width: 1200px;
    background: #343A40;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.5);
    gap: 20px;
    color: var(--texto);
}

#filme-img {
    width: 260px;
    border-radius: 16px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.5);
}

section { flex: 1; min-width: 300px; }
section h1 { color: var(--coral); font-size: 28px; margin-bottom: 10px; }
section p { margin-bottom: 8px; font-size: 15px; line-height: 1.5; }

#diretor {
    text-align: center;
    background: var(--cinza-diretor);
    border-radius: 15px;
    padding: 15px;
    width: 260px; 
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}
#diretor img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 5px; }
#diretor p { font-size: 14px; line-height: 1.3; margin: 0; }

#comentarios-e-avaliacao {
    display: flex;
    gap: 30px;
    width: 100%;
    justify-content: flex-start;
    align-items: flex-start;
}

/* FORMULÁRIO MELHORADO */
#form-comentario {
    width: 100%;
    max-width: 450px;
    background: rgba(255,255,255,0.07);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    display: flex;
    flex-direction: column;
    gap: 15px;
    transition: all 0.3s ease;
}
#form-comentario:hover { background: rgba(255,255,255,0.1); }

.nota-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: flex-start;
}
.nota-label { font-weight: 600; font-size: 16px; color: #f5f5f5; }
.estrelas {
    display: flex;
    gap: 6px;
    flex-direction: row-reverse;
    justify-content: flex-start;
    margin-top: 5px;
}
.estrelas input { display: none; }
.estrelas label {
    font-size: 26px;
    color: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: 0.2s;
}
.estrelas input:checked ~ label,
.estrelas label:hover,
.estrelas label:hover ~ label {
    color: #FFD700;
    transform: scale(1.3);
}

#form-comentario textarea {
    width: 100%;
    height: 110px;
    padding: 12px;
    font-size: 14px;
    border-radius: 12px;
    border: none;
    resize: none;
    background: rgba(255,255,255,0.12);
    color: #f5f5f5;
    transition: 0.3s;
}
#form-comentario textarea:focus {
    outline: none;
    background: rgba(255,255,255,0.2);
    box-shadow: 0 0 10px rgba(255,255,255,0.4);
}

#form-comentario button {
    background: linear-gradient(135deg, #FF6B6B, #007B83);
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}
#form-comentario button:hover {
    transform: scale(1.05);
    background: linear-gradient(135deg, #FF8787, #00A8A8);
}

#comentarios {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    flex: 1;
}
.comentario {
    display: flex;
    flex-direction: column;
    background: rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 16px;
    min-width: 220px;
    max-width: 280px;
    font-size: 14px;
    transition: transform 0.3s, box-shadow 0.3s;
    backdrop-filter: blur(5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}
.comentario:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.6); }
.comentario-header { font-size: 13px; color: var(--texto); opacity: 0.9; margin-bottom: 8px; }
.comentario-texto { font-size: 14px; line-height: 1.5; word-break: break-word; color: #f0f0f0; }
.comentario strong { color: var(--coral); }

#emoji-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1; }
.emoji { position: absolute; font-size: 24px; animation: float 15s linear infinite; opacity: 0.2; }
@keyframes float { 0% { transform: translateY(100vh) rotate(0deg); } 100% { transform: translateY(-10vh) rotate(360deg); } }

@media(max-width:900px){
    .card { flex-direction: column; align-items: center; }
    #filme-img, #diretor { width: 80%; max-width: 260px; }
    section { width: 90%; }
    #comentarios-e-avaliacao { flex-direction: column; gap: 20px; }
    #form-comentario { width: 100%; max-width: 100%; padding: 20px; }
    .estrelas label { font-size: 24px; }
    #comentarios { width: 100%; justify-content: center; }
}
</style>
</head>
<body>

<div id="emoji-bg"></div>
<a href="index.php" id="botao-voltar"></a>

<header>Critix</header>

<div class="card">
    <img id="filme-img" src="imagem.php?id=<?= $filme['id'] ?>" alt="<?= htmlspecialchars($filme['nome']) ?>">

    <section>
        <h1><?= htmlspecialchars($filme['nome']) ?></h1>
        <p><strong>Nota:</strong> <?= htmlspecialchars($filme['nota']) ?></p>
        <p><?= nl2br(htmlspecialchars($filme['descricao'])) ?></p>
        <p><strong>Duração:</strong> <?= htmlspecialchars($filme['minutos']) ?> minutos</p>
        <p><strong>Classificação:</strong> <?= htmlspecialchars($filme['idade']) ?> anos</p>
    </section>

    <div id="diretor">
        <img src="imagem_diretor.php?id=<?= $filme['id'] ?>" alt="<?= htmlspecialchars($filme['diretor']) ?>">
        <p><strong><?= htmlspecialchars($filme['diretor']) ?></strong></p>
        <p><?= nl2br(htmlspecialchars($filme['descricao_diretor'])) ?></p>
    </div>

    <div id="comentarios-e-avaliacao">
        <div id="form-comentario">
            <form action="comentario.php" method="post">
                <input type="hidden" name="filme_id" value="<?= htmlspecialchars($id) ?>">
                <div class="nota-container">
                    <label class="nota-label">Avaliação:</label>
                    <div class="estrelas">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <input type="radio" id="nota<?= $i ?>" name="nota" value="<?= $i ?>" required>
                            <label for="nota<?= $i ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>
                <textarea name="texto" placeholder="Escreva seu comentário..." required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>

        <div id="comentarios">
            <?php if ($comentarios): ?>
                <?php foreach ($comentarios as $c): ?>
                    <div class="comentario">
                        <div class="comentario-header">
                            <strong><?= htmlspecialchars($c['usuario']) ?></strong>
                            <span>— <?= htmlspecialchars($c['nota']) ?>★ —</span>
                            <span><?= date('d/m/Y H:i', strtotime($c['data_hora'])) ?></span>
                        </div>
                        <div class="comentario-texto">
                            <?= nl2br(htmlspecialchars($c['texto'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; opacity:0.7;">Ainda não há comentários.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
const emojis = ['🎬','🍿','📚','🎥','😄','🤩','⭐','🎶','📖','🎭','😎','🥳','🍿','🎉'];
const emojiContainer = document.getElementById('emoji-bg');
for(let i=0; i<25; i++){
    const span = document.createElement('span');
    span.classList.add('emoji');
    span.textContent = emojis[Math.floor(Math.random()*emojis.length)];
    span.style.left = Math.random()*100 + 'vw';
    span.style.fontSize = 16 + Math.random()*24 + 'px';
    span.style.animationDuration = 12 + Math.random()*8 + 's';
    span.style.opacity = 0.6 + Math.random()*0.4;
    emojiContainer.appendChild(span);
}
</script>

</body>
</html>
