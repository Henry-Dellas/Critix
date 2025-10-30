<?php
session_start();
if(!isset($_SESSION["usuarios"])) {
    header("location:Login Teste.php");
    exit;
}

$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
$apikeyTMDB = "7a4a474069f49e3f759f137ccfa33365";
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) die("ID inválido.");

$baseUrl = "https://api.themoviedb.org/3/tv/$id?api_key=$apikeyTMDB&language=pt-BR";

$filmeData = @json_decode(file_get_contents($baseUrl), true);

if (!$filmeData || (isset($filmeData["success"]) && $filmeData["success"] === false)) {
    $titulo = "Série não encontrada";
    $sinopse = "Descrição indisponível";
    $nota = "-";
    $duracao = "-";
    $lancamento = "-";
    $generos = [];
    $poster = "https://via.placeholder.com/300x450?text=Sem+Imagem";
} else {
    $titulo = $filmeData["name"] ?? "Título indisponível";
    $sinopse = $filmeData["overview"] ?: "Sem descrição disponível.";
    $nota = $filmeData["vote_average"] ? number_format($filmeData["vote_average"], 1) : "-";
    $duracao = $filmeData["episode_run_time"][0] ?? "Duração não informada";
    $lancamento = $filmeData["first_air_date"] ?? "-";
    $generos = array_column($filmeData["genres"], "name");
    $poster = $filmeData["poster_path"]
        ? "https://image.tmdb.org/t/p/w500" . $filmeData["poster_path"]
        : "https://via.placeholder.com/300x450?text=Sem+Imagem";
}

$stmt2 = $conn->prepare("SELECT usuario, texto, data_hora, nota FROM comentarios WHERE filme_id = ? ORDER BY data_hora DESC");
$stmt2->execute([$id]);
$comentarios = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$mediaStmt = $conn->prepare("SELECT ROUND(AVG(nota),1) AS media FROM comentarios WHERE filme_id = ?");
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
    --branco-gelo:#F8F9FA;
    --cinza-escuro:#343A40;
    --azul-petroleo:#007B83;
    --coral:#FF6B6B;
    --transparente-preto:rgba(52,58,64,0.9);
}
*{margin:0;padding:0;box-sizing:border-box;font-family:"Poppins",sans-serif;}
html,body{width:100vw;min-height:100vh;overflow-x:hidden;}
body{background: linear-gradient(135deg, #1e1e2f, #007B83); background-size:800% 800%; animation: gradientMove 120s ease infinite;color:var(--branco-gelo); display:flex; flex-direction:column; align-items:center; padding:40px 20px; position:relative;}
@keyframes gradientMove{0%{background-position:0% 50%;}50%{background-position:100% 50%;}100%{background-position:0% 50%;}}
#botao-voltar{position:absolute;top:20px;left:25px;width:32px;height:32px;border-left:3px solid var(--coral);border-bottom:3px solid var(--coral);transform:rotate(45deg);cursor:pointer;transition:transform 0.2s;}
#botao-voltar:hover{transform:rotate(45deg) scale(1.2);}
header{font-family:"Cinzel", serif;font-size:70px;text-align:center;color:var(--coral);text-shadow:0 0 20px rgba(255,107,107,0.6);margin:20px 0;position:relative;z-index:2;}
.card, #form-comentario, .comentario{position:relative; z-index:2; background-color:var(--transparente-preto); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.1); box-shadow:0 20px 40px rgba(0,0,0,0.6); border-radius:25px; transition:all 0.3s ease;}
.card:hover, #form-comentario:hover, .comentario:hover{transform:translateY(-5px); box-shadow:0 25px 50px rgba(0,0,0,0.7);}
.card{display:flex; justify-content:center; align-items:flex-start; gap:25px; width:95%; max-width:1200px; padding:25px;}
#filme-img{width:260px; border-radius:16px; box-shadow:0 5px 25px rgba(0,0,0,0.5);}
section{flex:1; min-width:280px; padding:28px; overflow-y:auto; max-height:72vh; text-align:justify;}
section h1{font-size:26px;color:var(--coral);margin-bottom:12px;}
section p{font-size:16.5px;margin-bottom:10px; line-height:1.6;}
section p strong{color:var(--coral);}
#comentarios-e-avaliacao{display:flex; width:95%; max-width:1200px; margin-top:30px; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap;}
#form-comentario{flex:0 0 48%; padding:25px; display:flex; flex-direction:column; gap:15px;}
#comentarios-container{flex:1; display:flex; flex-wrap:wrap; justify-content:flex-start; gap:18px;}
.comentario{padding:16px 20px; font-size:14px; width:calc(50% - 10px); min-width:260px;}
.comentario strong{color:var(--coral);}
.estrelas{display:flex; flex-direction:row-reverse; justify-content:flex-end; gap:6px;}
.estrelas input{display:none;}
.estrelas label{font-size:26px; color:rgba(255,255,255,0.4); cursor:pointer; transition:0.2s;}
.estrelas input:checked ~ label, .estrelas label:hover, .estrelas label:hover ~ label{color:#FFD700; transform:scale(1.3);}
#form-comentario textarea{width:100%; height:110px; padding:12px; font-size:14px; border-radius:12px; border:none; resize:none; background: rgba(255,255,255,0.1); color:var(--branco-gelo);}
#form-comentario button{background: linear-gradient(135deg, var(--azul-petroleo), var(--coral)); color:#fff; border:none; padding:10px 22px; border-radius:12px; font-weight:600; cursor:pointer; transition:0.3s;}
#form-comentario button:hover{transform:scale(1.05); box-shadow:0 0 20px var(--coral);}
.checkbox-spoiler{display:flex; align-items:center; gap:10px; margin-top:5px;}
.checkbox-spoiler input{accent-color:var(--coral); width:18px; height:18px; cursor:pointer;}
.checkbox-spoiler label{font-size:14px; color:#f2f2f2; cursor:pointer;}
@media(max-width:900px){#comentarios-e-avaliacao{flex-direction:column;} #form-comentario,#comentarios-container{flex:1 1 100%;} .comentario{width:100%;} .card{flex-direction:column; align-items:center;}}
#emoji-bg{position:fixed;top:0;left:0;width:100%;height:100%;overflow:hidden;pointer-events:none;z-index:1;}
.emoji{position:absolute;animation:float linear infinite;opacity:0.25;filter:blur(0.5px);}
@keyframes float{0%{transform:translateY(100vh) rotate(0deg);}100%{transform:translateY(-10vh) rotate(360deg);}}
</style>
</head>
<body>

<div id="emoji-bg"></div>

<a href="index.php" id="botao-voltar"></a>
<header>Critix</header>

<div class="card">
    <img id="filme-img" src="<?= $poster ?>" alt="<?= htmlspecialchars($titulo) ?>">
    <section>
        <h1><?= htmlspecialchars($titulo) ?></h1>
        <p><strong>Média dos usuários:</strong> <span id="media-usuarios"><?= $media ? $media : "Sem avaliações ainda" ?></span></p>
        <p><strong>Nota TMDb:</strong> <?= $nota ?></p>
        <p><strong>Duração:</strong> <?= $duracao ?></p>
        <p><strong>Gêneros:</strong> <?= htmlspecialchars(implode(', ', $generos)) ?></p>
        <p><strong>Lançamento:</strong> <?= $lancamento !== "-" ? date("d/m/Y", strtotime($lancamento)) : "-" ?></p>
        <p><?= nl2br(htmlspecialchars($sinopse)) ?></p>
    </section>
</div>

<div id="comentarios-e-avaliacao">
    <div id="form-comentario">
        <form id="avaliacao-form">
            <input type="hidden" name="filme_id" value="<?= htmlspecialchars($id) ?>">
            <p><strong>Avaliações</strong></p>
            <div class="estrelas">
                <?php for ($i = 10; $i >= 1; $i--): ?>
                    <input type="radio" id="estrela<?= $i ?>" name="nota" value="<?= $i ?>">
                    <label for="estrela<?= $i ?>">★</label>
                <?php endfor; ?>
            </div>
            <textarea name="texto" placeholder="Escreva seu comentário..." required></textarea>
            
            <div class="checkbox-spoiler">
                <input type="checkbox" id="spoiler" name="spoiler" value="1">
                <label for="spoiler">Comentário com spoiler?</label>
            </div>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <div id="comentarios-container">
        <?php foreach($comentarios as $c): ?>
        <div class="comentario">
            <strong><?= htmlspecialchars($c['usuario']) ?> (<?= $c['nota'] ?>/10)</strong>
            <p><?= nl2br(htmlspecialchars($c['texto'])) ?></p>
            <small><?= date("d/m/Y H:i", strtotime($c['data_hora'])) ?></small>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
const emojis = ['🎬','🍿','📺','⭐','🎭','🎉','🎥','📖'];
const container = document.getElementById('emoji-bg');
for(let i=0; i<20; i++){
    const span = document.createElement('span');
    span.classList.add('emoji');
    span.textContent = emojis[Math.floor(Math.random()*emojis.length)];
    span.style.left = Math.random()*100 + "vw";
    span.style.fontSize = (14 + Math.random()*20) + "px";
    span.style.animationDuration = (10 + Math.random()*10) + "s";
    container.appendChild(span);
}
</script>
</body>
</html>
