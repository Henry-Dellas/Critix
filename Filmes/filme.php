<?php
session_start();
if(!isset($_SESSION["usuarios"])) {
    header("location:Login Teste.php");
    exit;
}
$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
$apikeyTMDB = "7a4a474069f49e3f759f137ccfa33365";
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

// 🔍 Busca informações do filme na API TMDb
$tipo = "movie";
$baseUrl = "https://api.themoviedb.org/3/movie/$id?api_key=$apikeyTMDB&language=pt-BR";
$creditUrl = "https://api.themoviedb.org/3/movie/$id/credits?api_key=$apikeyTMDB&language=pt-BR";

$filmeData = json_decode(file_get_contents($baseUrl), true);
$creditData = json_decode(file_get_contents($creditUrl), true);

if (!$filmeData || isset($filmeData["success"]) && $filmeData["success"] === false) {
    die("Filme não encontrado.");
}

// 🎥 Informações principais
$titulo = $filmeData["title"] ?? "Título indisponível";
$sinopse = $filmeData["overview"] ?: "Sem descrição disponível.";
$nota = $filmeData["vote_average"] ? number_format($filmeData["vote_average"], 1) : "-";
$duracao = $filmeData["runtime"] ? $filmeData["runtime"] . " min" : "Duração não informada";
$lancamento = $filmeData["release_date"] ?? "Desconhecida";
$generos = array_column($filmeData["genres"], "name");
$poster = $filmeData["poster_path"]
    ? "https://image.tmdb.org/t/p/w500" . $filmeData["poster_path"]
    : "https://via.placeholder.com/300x450?text=Sem+Imagem";
$backdrop = $filmeData["backdrop_path"]
    ? "https://image.tmdb.org/t/p/original" . $filmeData["backdrop_path"]
    : "https://via.placeholder.com/1200x600?text=Sem+Fundo";

// 🎬 Elenco e diretor
$elenco = array_slice(array_column($creditData["cast"], "name"), 0, 5);
$diretor = "";
foreach ($creditData["crew"] as $membro) {
    if ($membro["job"] === "Director") {
        $diretor = $membro["name"];
        break;
    }
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

<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
:root {
    --branco-gelo: #F8F9FA;
    --cinza-escuro: #343A40;
    --azul-petroleo: #007B83;
    --coral: #FF6B6B;
     --cinza: #1e1e2f;
    --cinza-claro: #2a2a40;
    --texto: #f5f5f5;
    --cinza-div: #343A40;
    --cinza-diretor: rgba(30,30,40,0.95);
    --estrela-cheia: #FFD700;
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
    justify-content: flex-start;
    padding: 20px;
    color: var(--texto);
    background: linear-gradient(135deg, var(--cinza), #007B83);
    background-size: 800% 800%;
    animation: gradientMove 120s ease infinite;
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
    font-size: 70px;
    text-align: center;
    color: var(--coral);
    text-shadow: 0 0 25px rgba(255,107,107,0.7);
    margin-bottom: 30px;
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
    width: 32px;     
    height: 32px;     
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

.card {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: center;
    gap: 20px;
    width: 90%;
    max-width: 1200px;
    padding: 25px;
    z-index: 2;
    background: #343A40;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.5);
    color: var(--texto);
}

section { flex: 1; min-width: 300px; }

section h1 { color: var(--coral); font-size: 28px; margin-bottom: 10px; }

section p { margin-bottom: 8px; font-size: 15px; line-height: 1.5; }

#form-comentario {
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

#form-comentario:hover { background: rgba(255,255,255,0.1); }

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
#comentarios-e-avaliacao {
    display: flex;
    gap: 30px;
    width: 100%;
    max-width: 250px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    justify-content: flex-start;
    align-items: flex-start;
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

<header>Critix</header>
<a href="index.php" id="botao-voltar"></a>

<div class="container">
    <aside id="aside-esquerda">
        <img src="<?= $poster ?>" alt="<?= htmlspecialchars($titulo) ?>">
        <p><strong>Lançamento:</strong> <?= date("d/m/Y", strtotime($lancamento)) ?></p>
    </aside>

    <section>
        <h1><?= htmlspecialchars($titulo) ?></h1>
        <p><strong>Média dos usuários:</strong> <?= $media ? $media : "Sem avaliações ainda" ?></p>
        <p><strong>Nota TMDb:</strong> <?= $nota ?></p>
        <p><strong>Duração:</strong> <?= $duracao ?></p>
        <p><strong>Gêneros:</strong> <?= htmlspecialchars(implode(', ', $generos)) ?></p>
        <p><?= nl2br(htmlspecialchars($sinopse)) ?></p>
    </section>

    <aside id="aside-direita">
        <h3>Direção</h3>
        <p><strong><?= htmlspecialchars($diretor ?: "Não informado") ?></strong></p>
    </aside>

    <!-- Seção de comentários -->
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
            </div>
            <<textarea name="texto" placeholder="Escreva seu comentário..." required></textarea>
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
cconst emojis = ['🎬','🍿','📚','🎥','😄','🤩','⭐','🎶','📖','🎭','😎','🥳','🍿','🎉'];
const emojiContainer = document.getElementById('emoji-bg');

for(let i=0; i<25; i++){
    const span = document.createElement('span');
    span.classList.add('emoji');
    span.textContent = emojis[Math.floor(Math.random()*emojis.length)];
    span.style.left = Math.random()*100 + 'vw';
    span.style.fontSize = 16 + Math.random()*28 + 'px';
    span.style.animationDuration = 6 + Math.random()*8 + 's';
    span.style.opacity = 0.6 + Math.random()*0.4;
    emojiContainer.appendChild(span);
}
</script>

</body>
</html>