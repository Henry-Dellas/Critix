<?php 
session_start(); 
if (!isset($_SESSION["usuarios"])) { 
    header("location:Login Teste.php"); 
} 
$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025"); 
$stmt = $conn->query("SELECT id, nome, imagem FROM filmes"); 
$filmes = $stmt->fetchAll(); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
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

* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', Arial, Helvetica, sans-serif; }

html, body { width: 100vw; height: 100vh; overflow: hidden; position: relative; }

body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #1e1e2f, #007B83);
    background-size: 800% 800%;
    animation: gradientMove 120s ease infinite;
    padding: 20px; 
}

@keyframes gradientMove { 
    0% { background-position: 0% 50%; } 
    50% { background-position: 100% 50%; } 
    100% { background-position: 0% 50%; } 
}

header { 
    font-family: "Cinzel", serif; 
    font-size: 70px; 
    text-align: center; 
    color: var(--coral); 
    text-shadow: 0 0 25px rgba(255,107,107,0.7); 
    margin-bottom: 30px; 
    z-index: 2; 
}

#area-texto {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    background-color: #343A40;
    padding: 25px 35px;
    border-radius: 20px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.5);
    max-width: 1200px;
    width: 90%;
    color: var(--branco-gelo);
    margin-bottom: 40px;
}

#bemvindo { font-size: 2.2em; font-weight: 600; }

#area-texto div { display: flex; gap: 15px; }

#button, #button-indicacoes {
    background: linear-gradient(45deg, var(--azul-petroleo), var(--coral));
    border: none;
    padding: 18px 40px;
    border-radius: 15px;
    color: var(--branco-gelo);
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.4s ease;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}
#button:hover, #button-indicacoes:hover {
    background: var(--coral);
    transform: scale(1.07) translateY(-2px);
    box-shadow: 0 0 30px var(--coral);
}

#carrossel-container {
    position: relative;
    z-index: 1;
    overflow: hidden;
    background: #2e2e38;
    border-radius: 25px;
    padding: 25px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.5);
    max-width: 1200px;
    width: 90%;
}
#carrossel { display: flex; gap: 30px; animation: scrollCarrossel 40s linear infinite; }
#carrossel a img { width: 180px; height: 260px; border-radius: 18px; object-fit: cover; transition: transform 0.4s ease, box-shadow 0.4s ease; filter: brightness(0.95); }
#carrossel a img:hover { transform: scale(1.12); box-shadow: 0 0 30px var(--coral); filter: brightness(1); }

@keyframes scrollCarrossel { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

#emoji-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1; }
.emoji { position: absolute; font-size: 24px; animation: float 10s linear infinite; }
@keyframes float { 0% { transform: translateY(100vh) rotate(0deg); } 100% { transform: translateY(-10vh) rotate(360deg); } }

@media (max-width: 1200px) { 
    #carrossel a img { width: 150px; height: 220px; } 
    #bemvindo { font-size: 1.8em; } 
    #button, #button-indicacoes { padding: 15px 30px; font-size: 15px; } 
}
@media (max-width: 800px) { 
    #area-texto { flex-direction: column; align-items: stretch; gap: 20px; } 
    #carrossel a img { width: 130px; height: 190px; } 
    #bemvindo { font-size: 1.5em; text-align: center; } 
}
</style>
</head>
<body>

<div id="emoji-bg"></div>

<header>Critix</header>
<div id="area-texto">
    <h1 id="bemvindo">Bem-vindo, <?php echo htmlspecialchars($_SESSION["usuarios"]); ?>.</h1>
    <div>
        <!-- 🔗 Caminho corrigido -->
        <a href="../IA/testeIA.html" id="button-indicacoes">Ir para Indicações</a>
        <a href="../SobreNos.php" id="button-indicacoes">Integrantes</a>
        <a href="../Cadastro_Login/logout.php" id="button">Sair da conta</a>
    </div>
</div>

<div id="carrossel-container">
    <div id="carrossel">
        <?php foreach ($filmes as $filme): ?>
            <a href="filme.php?id=<?= $filme['id'] ?>"><img src="imagem.php?id=<?= $filme['id'] ?>" alt="<?= htmlspecialchars($filme['nome']) ?>"></a>
        <?php endforeach; ?>
        <?php foreach ($filmes as $filme): ?>
            <a href="filme.php?id=<?= $filme['id'] ?>"><img src="imagem.php?id=<?= $filme['id'] ?>" alt="<?= htmlspecialchars($filme['nome']) ?>"></a>
        <?php endforeach; ?>
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
    span.style.animationDuration = 8 + Math.random()*8 + 's';
    span.style.opacity = 0.6 + Math.random()*0.4;
    emojiContainer.appendChild(span);
}
</script>

</body>
</html>

