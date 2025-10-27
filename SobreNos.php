<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Critix - Sobre Nós</title>
<link rel="shortcut icon" href="Adobe_Express_-_file40px.png" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
:root {
    --fundo-claro: #1e1e2f;
    --fundo-escuro: #343A40;
    --cor-principal: #007B83;
    --cor-destaque: #FF6B6B;
    --texto-claro: #F8F9FA;
    --texto-secundario: #a8e6cf;
}

/* Reset e fontes */
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', Arial, Helvetica, sans-serif; }
body { 
    background: linear-gradient(135deg, #1e1e2f, #007B83); 
    background-size: 800% 800%; 
    animation: gradientMove 120s ease infinite; 
    color: var(--texto-claro); 
    position: relative;
    overflow-x: hidden;
}

/* Animação do background */
@keyframes gradientMove { 
    0% { background-position: 0% 50%; } 
    50% { background-position: 100% 50%; } 
    100% { background-position: 0% 50%; } 
}

/* Botão de Voltar estilo seta */
#botao-voltar {
    position: fixed;
    top: 20px;
    left: 25px;
    width: 30px;     
    height: 30px;     
    border-left: 3px solid var(--cor-destaque);
    border-bottom: 3px solid var(--cor-destaque);
    transform: rotate(45deg);
    cursor: pointer;
    transition: transform 0.2s;
    z-index: 10;
}
#botao-voltar:hover {
    transform: rotate(45deg) scale(1.2);
}

/* Container */
.container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 40px 20px; }

/* Títulos de seções */
.section-title h2 {
    font-family: "Cinzel", serif;
    font-size: 3rem;
    color: var(--cor-destaque);
    text-align: center;
    text-shadow: 0 0 25px rgba(255,107,107,0.7);
    margin-bottom: 2rem;
}

/* About - Nossa História */
.about-content { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 2rem; margin-bottom: 40px; }
.about-text { flex: 1; min-width: 300px; line-height: 1.6; text-align: justify; color: var(--texto-claro); }
.about-image { flex: 1; min-width: 300px; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,.5); }
.about-image img { width: 100%; height: auto; display: block; transition: transform 0.5s ease; }
.about-image img:hover { transform: scale(1.05); }

/* Mission & Vision */
.mission-vision { background-color: var(--fundo-escuro); padding: 50px 0; }
.mv-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem; }
.mv-card { background: var(--fundo-claro); padding: 2rem; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,.5); flex: 1; min-width: 300px; max-width: 500px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; color: var(--texto-claro); }
.mv-card:hover { transform: translateY(-5px); box-shadow: 0 6px 15px rgba(255,107,107,0.6); }
.mv-card i { font-size: 2.5rem; color: var(--cor-destaque); margin-bottom: 1rem; }
.mv-card h3 { font-size: 1.5rem; margin-bottom: 1rem; color: var(--cor-destaque); }

/* Values */
.values { padding: 50px 0; }
.values-grid { display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; }
.value-card { background: var(--fundo-claro); padding: 2rem; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,.5); flex: 1; min-width: 250px; max-width: 300px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; color: var(--texto-claro); }
.value-card:hover { transform: translateY(-5px); box-shadow: 0 6px 15px rgba(255,107,107,0.6); }
.value-card i { font-size: 2rem; color: var(--cor-destaque); margin-bottom: 1rem; }
.value-card h3 { font-size: 1.3rem; margin-bottom: 1rem; color: var(--cor-destaque); }

/* Team */
.team { 
    background-color: var(--fundo-escuro); 
    padding: 50px 0; 
    text-align: center; 
}
.team img { 
    width: 850px; max-width: 90%; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,.5); 
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.team img:hover { transform: scale(1.05); box-shadow: 0 6px 15px rgba(255,107,107,0.6); }

/* Footer */
footer { background-color: var(--fundo-escuro); color: var(--texto-claro); padding: 3rem 0; text-align: center; }
.footer-links a:hover { color: var(--cor-destaque); }
.social-icons a { display:flex; align-items:center; justify-content:center; width:40px; height:40px; background-color: var(--cor-destaque); color: var(--fundo-escuro); border-radius:50%; text-decoration:none; transition: transform 0.3s, background-color 0.3s; }
.social-icons a:hover { transform: translateY(-3px); background-color: var(--texto-secundario) !important; }

/* Responsividade */
@media (max-width: 768px) { 
    .values-grid { flex-direction: column; gap: 1.5rem; }
    .mv-container { flex-direction: column; gap: 1.5rem; }
    .team img { width: 90%; }
}

/* Emoji Background Suave e Infinito */
#emoji-bg { 
    position: fixed; 
    top: 0; left: 0; 
    width: 100%; height: 100%; 
    pointer-events: none; 
    z-index: -1; 
}
.emoji { 
    position: absolute; 
    will-change: transform;
    font-size: 18px;
    opacity: 0.3;
    user-select: none;
}
</style>
</head>
<body>

<!-- Botão de voltar ajustado -->
<a href="index.php" id="botao-voltar"></a>

<div id="emoji-bg"></div>

<section class="about">
    <div class="container">
        <div class="section-title"><h2>Nossa História</h2></div>
        <div class="about-content">
            <div class="about-text">
                <p>A DataMind nasceu em 2025 da paixão de um grupo de amigos por cinema, séries e literatura. Percebemos que faltava uma plataforma onde entusiastas pudessem compartilhar suas opiniões e descobrir novas obras através de recomendações confiáveis.</p>
                <p>Começamos com nosso pequeno grupo de amigos conversando sobre assuntos geeks e criando nossas críticas. Algumas críticas que não concordamos acabamos até recusando assistir.</p>
                <p>No nosso TCC, nossa missão agora é democratizar o acesso à crítica cultural, permitindo que todas as vozes sejam ouvidas e valorizadas.</p>
            </div>
            <div class="about-image">
                <img src="https://i.pinimg.com/736x/26/48/45/2648458cfd4e7cf5d07ead4435609898.jpg" alt="Equipe DataMind">
            </div>
        </div>
    </div>
</section>

<section class="mission-vision">
    <div class="container">
        <div class="section-title"><h2>Missão e Visão</h2></div>
        <div class="mv-container">
            <div class="mv-card">
                <i class="fas fa-bullseye"></i>
                <h3>Missão</h3>
                <p>Conectar entusiastas de cinema, séries e livros através de uma plataforma colaborativa onde possam compartilhar avaliações e descobrir novas obras.</p>
            </div>
            <div class="mv-card">
                <i class="fas fa-eye"></i>
                <h3>Visão</h3>
                <p>Ser referência em recomendações culturais na América Latina, reconhecida pela qualidade das discussões e diversidade de perspectivas.</p>
            </div>
        </div>
    </div>
</section>

<section class="values">
    <div class="container">
        <div class="section-title"><h2>Nossos Valores</h2></div>
        <div class="values-grid">
            <div class="value-card">
                <i class="fas fa-users"></i>
                <h3>Comunidade</h3>
                <p>Valorizamos cada membro da comunidade e acreditamos que a diversidade de opiniões enriquece a experiência cultural de todos.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-star"></i>
                <h3>Qualidade</h3>
                <p>Buscamos excelência em nossas avaliações e incentivamos conteúdos bem fundamentados e reflexivos.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Transparência</h3>
                <p>Mantemos processos claros e honestos em nossas avaliações, sem influência de interesses comerciais.</p>
            </div>
        </div>
    </div>
</section>

<section class="team">
    <div class="container">
        <div class="section-title"><h2>Nosso Time</h2></div>
        <img src="748826c0-4877-4b55-a3d6-7f886cff61a8.jpg" alt="Equipe DataMind">
    </div>
</section>

<footer>
  <div class="container">
    <div class="footer-content" style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:flex-start; gap:2rem;">
      <div class="footer-section" style="flex:1; min-width:250px; text-align:left;">
        <h3 style="color: var(--cor-destaque); font-size: 1.5rem; margin-bottom:10px;">DataMind</h3>
        <p style="color: var(--texto-secundario); line-height: 1.6; margin-left:0;">Sua plataforma de reviews comunitários de filmes, séries e livros.</p>
        <div class="social-icons" style="margin-top:15px; display:flex; gap:10px;">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="footer-section" style="flex:1; min-width:250px; text-align:right;">
        <h3 style="color: var(--cor-destaque); font-size: 1.5rem; margin-bottom:10px;">Contato</h3>
        <ul style="list-style:none; color: var(--texto-secundario); line-height:1.8; padding:0;">
          <li><i class="fas fa-envelope"></i> contato@datamind.com</li>
          <li><i class="fas fa-phone"></i> (11) 9999-9999</li>
          <li><i class="fas fa-map-marker-alt"></i> São Paulo, Brasil</li>
        </ul>
      </div>
    </div>
    <div style="margin-top:30px; border-top:1px solid rgba(255,255,255,0.1); padding-top:15px; text-align:center; color:var(--texto-secundario); font-size:0.9rem;">
      &copy; 2023 DataMind - Todos os direitos reservados
    </div>
  </div>
</footer>

<script>
const emojis = ['🎬','🍿','📚','🎥','⭐','🎶','📖','🎭','😄','🤩','🥳','🎉'];
const emojiContainer = document.getElementById('emoji-bg');

function createEmoji() {
    const span = document.createElement('span');
    span.classList.add('emoji');
    span.textContent = emojis[Math.floor(Math.random()*emojis.length)];
    span.style.left = Math.random()*100 + 'vw';
    span.style.fontSize = 14 + Math.random()*16 + 'px';
    span.style.opacity = 0.2 + Math.random()*0.4;

    emojiContainer.appendChild(span);

    let posY = window.innerHeight + Math.random()*200;
    const speed = 0.3 + Math.random()*0.5;
    const rotation = 0.1 + Math.random()*0.2;
    let rot = 0;

    function animate() {
        posY -= speed;
        rot += rotation;
        span.style.top = posY + 'px';
        span.style.transform = `rotate(${rot}deg)`;
        if(posY < -50){
            posY = window.innerHeight + 50;
            span.style.left = Math.random()*100 + 'vw';
        }
        requestAnimationFrame(animate);
    }
    animate();
}

// Cria 20 emojis flutuando suavemente
for(let i=0;i<20;i++){
    createEmoji();
}
</script>

</body>
</html>
