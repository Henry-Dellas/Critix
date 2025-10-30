<?php
session_start();
if (!isset($_SESSION["usuarios"])) {
    header("Location: Login Teste.php");
    exit;
}

$usuario = $_SESSION["usuarios"];
function traduzirTexto($texto) {
    if (empty($texto)) return "Sem descrição disponível.";

    $texto = strip_tags($texto); // remove HTML, se houver
    $partes = str_split($texto, 480); // divide o texto em blocos de 480 caracteres
    $traducaoFinal = "";

    foreach ($partes as $parte) {
        $parteCodificada = urlencode($parte);
        $url = "https://api.mymemory.translated.net/get?q={$parteCodificada}&langpair=en|pt";

        $response = @file_get_contents($url);

        if ($response !== FALSE) {
            $result = json_decode($response, true);
            if (isset($result['responseData']['translatedText'])) {
                $traducaoFinal .= $result['responseData']['translatedText'] . " ";
            } else {
                $traducaoFinal .= $parte . " "; // fallback
            }
        } else {
            $traducaoFinal .= $parte . " "; // fallback se falhar a requisição
        }

        // Evita limite de requisições (API gratuita)
        usleep(300000); // 0.3 segundos entre cada requisição
    }

    return trim($traducaoFinal);
}

$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");

try {
    $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erro na conexão: " . htmlspecialchars($e->getMessage()));
}

$id = $_GET['id'] ?? null;
if (!$id) die("ID do livro não informado.");

$baseUrl = "https://www.googleapis.com/books/v1/volumes/" . urlencode($id);
$livroJson = @file_get_contents($baseUrl);
$livroData = $livroJson ? json_decode($livroJson, true) : null;

if (!$livroData || isset($livroData["error"])) {
    die("Livro não encontrado.");
}

$info = $livroData["volumeInfo"] ?? [];
$webReaderLink = $livroData["accessInfo"]["webReaderLink"] 
                 ?? $info["volumeInfo"]["previewLink"] 
                 ?? "";

$titulo = $info["title"] ?? "Título indisponível";
$autores = isset($info["authors"]) ? implode(", ", $info["authors"]) : "Autor não informado";
$descricaoOriginal = $info["description"] ?? "Sem descrição disponível";
$descricaoTraduzida = traduzirTexto($descricaoOriginal);
$nota = isset($info["averageRating"]) ? number_format($info["averageRating"], 1) : "-";
$lancamento = $info["publishedDate"] ?? "Desconhecida";
$categorias = isset($info["categories"]) ? implode(", ", $info["categories"]) : "Sem categorias";

$poster = $info["imageLinks"]["thumbnail"] ?? "https://via.placeholder.com/300x450?text=Sem+Imagem";

$stmt2 = $conn->prepare("SELECT usuario, texto, data_hora, nota FROM comentarioslivro WHERE livro_id = ? ORDER BY data_hora DESC");
$stmt2->execute([$id]);
$comentarios = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$mediaStmt = $conn->prepare("SELECT ROUND(AVG(nota), 1) AS media FROM comentarioslivro WHERE livro_id = ?");
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
    --transparente-preto: rgba(52, 58, 64, 0.9);
}

* { margin:0; padding:0; box-sizing:border-box; font-family:"Poppins", sans-serif; }
html, body { width:100vw; min-height:100vh; overflow-x:hidden; }

body {
    background: linear-gradient(135deg, #1e1e2f, #007B83);
    background-size: 800% 800%;
    animation: gradientMove 120s ease infinite;
    color: var(--branco-gelo);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
}
@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

#emoji-bg {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    overflow: hidden;
    pointer-events: none;
    z-index: 0;
}
.emoji {
    position: absolute;
    animation: float linear infinite;
    opacity: 0.25;
    filter: blur(0.5px);
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
    text-shadow: 0 0 20px rgba(255,107,107,0.6);
    margin: 20px 0;
    z-index: 1;
}

#botao-voltar {
    position: absolute;
    top: 20px; left: 25px;
    width: 32px; height: 32px;
    border-left: 3px solid var(--coral);
    border-bottom: 3px solid var(--coral);
    transform: rotate(45deg);
    cursor: pointer;
    transition: transform 0.2s;
    z-index: 2;
}
#botao-voltar:hover { transform: rotate(45deg) scale(1.2); }

.card, #form-comentario, .comentario {
    position: relative;
    z-index: 1;
    background-color: var(--transparente-preto);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    border-radius: 25px;
    transition: all 0.3s ease;
}
.card:hover, #form-comentario:hover, .comentario:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.7);
}

.card {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 25px;
    width: 95%;
    max-width: 1100px;
    padding: 25px;
}

#filme-img {
    width: 260px;
    border-radius: 16px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.5);
}

section {
    flex: 1;
    min-width: 280px;
    padding: 28px;
    overflow-y: auto;
    max-height: 72vh;
    text-align: justify;
}
section h1 { font-size: 26px; color: var(--coral); margin-bottom: 12px; }
section p { font-size: 16.5px; margin-bottom: 10px; line-height: 1.6; }
section p strong { color: var(--coral); }

#comentarios-e-avaliacao {
    display: flex;
    width: 95%;
    max-width: 1100px;
    margin-top: 30px;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    flex-wrap: wrap;
}

#form-comentario {
    flex: 0 0 48%;
    padding: 25px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

#comentarios-container {
    flex: 1;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 18px;
}

.comentario {
    padding: 16px 20px;
    font-size: 14px;
    width: calc(50% - 10px);
    min-width: 260px;
}
.comentario strong { color: var(--coral); }

.estrelas {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 6px;
}
.estrelas input { display: none; }
.estrelas label {
    font-size: 26px;
    color: rgba(255,255,255,0.4);
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
    background: rgba(255,255,255,0.1);
    color: var(--branco-gelo);
}
#form-comentario button {
    background: linear-gradient(135deg, var(--azul-petroleo), var(--coral));
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
    box-shadow: 0 0 20px var(--coral);
}

@media(max-width:900px){
    #comentarios-e-avaliacao { flex-direction: column; }
    #form-comentario, #comentarios-container { flex: 1 1 100%; }
    .comentario { width: 100%; }
    .card { flex-direction: column; align-items: center; }
}
</style>
</head>
<body>
<div id="emoji-bg"></div>
<a href="index.php" id="botao-voltar"></a>
<header>Critix</header>

<div class="container">
    <aside id="aside-esquerda">
        <img src="<?= $poster ?>" alt="<?= htmlspecialchars($titulo) ?>">
        <p><strong>Publicado:</strong> <?= htmlspecialchars($lancamento) ?></p>
    </aside>

    <section style="color:white; padding:20px;">
    <h1><?= htmlspecialchars($titulo) ?></h1>
    <p><strong>Autores:</strong> <?= htmlspecialchars($autores) ?></p>
    <p><strong>Média dos usuários:</strong> <?= $media ? $media : "Sem avaliações ainda" ?></p>
    <p><strong>Nota Google Books:</strong> <?= $nota ?></p>
    <p><strong>Categorias:</strong> <?= htmlspecialchars($categorias) ?></p>
    <p><?= nl2br(htmlspecialchars($descricaoTraduzida)) ?></p>

    <?php if (!empty($webReaderLink)): ?>
        <div style="margin-top:25px; text-align:center;">
            <a href="<?= htmlspecialchars($webReaderLink) ?>" 
               target="_blank"
               style="
                    display:inline-block;
                    background:#2e2e38;
                    color:white;
                    font-weight:bold;
                    border:none;
                    padding:12px 25px;
                    border-radius:15px;
                    text-decoration:none;
                    box-shadow:0 6px 20px rgba(0,0,0,0.4);
                    transition:all 0.3s ease;
               "
               onmouseover="this.style.transform='scale(1.07)'; this.style.background='#3e3e4a';"
               onmouseout="this.style.transform='scale(1)'; this.style.background='#2e2e38';">
               Ver no Google Books
            </a>
        </div>
    <?php endif; ?>
    </section>
</div>

<div id="comentarios-e-avaliacao">
    <div id="form-comentario">
        <form id="avaliacao-form">
            <input type="hidden" name="livro_id" value="<?= htmlspecialchars($id) ?>">
            <p><strong>Avaliações</strong></p>
            <div class="estrelas">
                <?php for ($i = 10; $i >= 1; $i--): ?>
                    <input type="radio" id="estrela<?= $i ?>" name="nota" value="<?= $i ?>">
                    <label for="estrela<?= $i ?>">★</label>
                <?php endfor; ?>
            </div>
            <textarea name="texto" placeholder="Escreva seu comentário..." required></textarea>
            <div style="display:flex; align-items:center; gap:10px;">
                <input type="checkbox" id="spoiler" name="spoiler" value="1">
                <label for="spoiler" style="font-size:14px; color:#f2f2f2;">Comentário com spoiler?</label>
            </div>
            <button type="submit">Enviar</button>
        </form>
    </div>

    <div id="comentarios-container">
        <?php if ($comentarios): ?>
            <?php foreach($comentarios as $c): ?>
                <div class="comentario">
                    <strong><?= htmlspecialchars($c['usuario']) ?></strong> — <?= date("d/m/Y H:i", strtotime($c['data_hora'])) ?><br>
                    Nota: <?= htmlspecialchars($c['nota']) ?><br><br>
                    <?= nl2br(htmlspecialchars($c['texto'])) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
const emojis = ['📚','⭐','🎉','📖','🎬','🍿','🎭'];
const container = document.getElementById('emoji-bg');
for(let i=0;i<20;i++){
    const span = document.createElement('span');
    span.classList.add('emoji');
    span.textContent = emojis[Math.floor(Math.random()*emojis.length)];
    span.style.left = Math.random()*100+"vw";
    span.style.fontSize = (14+Math.random()*20)+"px";
    span.style.animationDuration = (10+Math.random()*10)+"s";
    span.style.opacity = 0.15 + Math.random()*0.15;
    container.appendChild(span);
}

const form = document.getElementById('avaliacao-form');
form.addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);

    fetch('comentarioLivro.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            const container = document.getElementById('comentarios-container');
            const div = document.createElement('div');
            div.classList.add('comentario');
            div.innerHTML = `<strong>${data.usuario}</strong> — ${data.data_hora}<br>Nota: ${data.nota}<br><br>${data.texto}`;
            container.prepend(div);
            document.getElementById('media-usuarios').innerText = data.media;
            form.reset();
        } else {
            alert("Erro ao enviar comentário.");
        }
    })
    .catch(err => console.error(err));
});
</script>
</body>
</html>
