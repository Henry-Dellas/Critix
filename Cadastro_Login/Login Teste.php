<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Critix - Login</title>
<link rel="shortcut icon" href="Adobe_Express_-_file40px.png" type="image/x-icon">
<style>
:root {
    --branco-gelo: #F8F9FA;
    --cinza-escuro: #343A40;
    --azul-petroleo: #007B83;
    --coral: #FF6B6B;
    --transparente-preto: rgba(52, 58, 64, 0.9);
}

* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', Arial, Helvetica, sans-serif; }

body {
    height:100vh; display:flex; justify-content:center; align-items:center;
    background: linear-gradient(135deg, #1e1e2f, #007B83);
    background-size:800% 800%; animation:gradientMove 120s ease infinite;
    position: relative; overflow:hidden;
}

@keyframes gradientMove {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}

#emoji-bg {
    position: fixed; top:0; left:0; width:100%; height:100%;
    pointer-events:none; z-index:-1;
}
.emoji {
    position:absolute; font-size:24px;
    animation: float 10s linear infinite;
}
@keyframes float {
    0% { transform: translateY(100vh) rotate(0deg); }
    100% { transform: translateY(-10vh) rotate(360deg); }
}

#notificacao { position: fixed; top:20px; right:20px; z-index:9999; }
.notificacao-msg { background-color: rgba(0,0,0,0.8); color:#fff; padding:15px 25px; margin-bottom:10px; border-radius:10px; font-weight:600; animation: slideIn 0.5s ease, fadeOut 0.5s ease 3s forwards; }
.notificacao-sucesso { background-color:#28a745; }
.notificacao-erro { background-color:#dc3545; }
.notificacao-aviso { background-color:#ffc107; color:#343A40; }
@keyframes slideIn { from { transform: translateX(100%); opacity:0; } to { transform:translateX(0); opacity:1; } }
@keyframes fadeOut { to { opacity:0; transform:translateX(100%); } }

.login-container {
    position: relative; z-index: 2;
    background-color: var(--transparente-preto);
    backdrop-filter: blur(12px);
    padding: 60px 50px;
    border-radius: 25px;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    width: 465px; text-align: center; color: var(--branco-gelo);
    transition: all 0.3s ease;
}
.login-container:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(0,0,0,0.7); }

h1 { font-family:"Cinzel", serif; font-size:37px; margin-bottom:40px; color: var(--coral); text-transform:uppercase; letter-spacing:2px; text-shadow:0 0 20px rgba(255,107,107,0.7); }
label { display:block; text-align:left; margin-bottom:8px; font-weight:500; font-size:15px; }
input { width:100%; padding:14px; margin-bottom:20px; border:none; border-radius:15px; background-color: var(--branco-gelo); color: var(--cinza-escuro); font-size:15px; transition:all 0.3s ease; }
input:focus { outline:none; box-shadow:0 0 12px var(--azul-petroleo); }
button { background: linear-gradient(45deg, var(--azul-petroleo), var(--coral)); border:none; padding:14px; width:100%; border-radius:15px; color: var(--branco-gelo); font-size:16px; font-weight:600; cursor:pointer; margin-top:25px; transition:all 0.3s ease; }
button:hover { transform: scale(1.05); box-shadow: 0 0 20px var(--coral); }
a { display:inline-block; margin-top:20px; background: linear-gradient(45deg, var(--azul-petroleo), var(--coral)); padding:14px; width:100%; border-radius:15px; color: var(--branco-gelo); font-size:16px; font-weight:600; text-decoration:none; text-align:center; cursor:pointer; transition:all 0.3s ease; }
a:hover { transform:scale(1.05); box-shadow:0 0 20px var(--coral); }

@media (max-width: 500px) {
    .login-container { width:85%; padding:40px 25px; }
    h1 { font-size:28px; }
}
</style>
</head>
<body>

<div id="notificacao"></div>
<div id="emoji-bg"></div>

<div class="login-container">
    <form id="loginForm">
        <h1>Critix <br> Iniciar Sessão</h1>
        <label for="usuarios">Nome</label>
        <input type="text" id="usuarios" name="usuarios" placeholder="Digite seu nome" required>
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
        <button type="submit">Entrar</button>
    </form>
    <a href="Cadastro.html">Cadastro</a>
</div>

<script>
const emojis = ['🎬','🍿','📚','🎥','😄','🤩','⭐','🎶','📖','🎭','😎','🥳','🍿','🎉'];
const emojiContainer = document.getElementById('emoji-bg');
for(let i=0;i<25;i++){
    const span = document.createElement('span');
    span.classList.add('emoji');
    span.textContent = emojis[Math.floor(Math.random()*emojis.length)];
    span.style.left = Math.random()*100 + 'vw';
    span.style.fontSize = 16 + Math.random()*24 + 'px';
    span.style.animationDuration = 8 + Math.random()*8 + 's';
    span.style.opacity = 0.6 + Math.random()*0.4;
    emojiContainer.appendChild(span);
}

const notificacao = document.getElementById('notificacao');
function mostrarNotificacao(msg, tipo){
    const div = document.createElement('div');
    div.classList.add('notificacao-msg', 'notificacao-' + tipo);
    div.textContent = msg;
    notificacao.appendChild(div);
    setTimeout(()=>div.remove(), 3500);
}

document.getElementById('loginForm').addEventListener('submit', function(e){
    e.preventDefault();
    const nome = document.getElementById('usuarios').value.trim();
    const senha = document.getElementById('senha').value.trim();

    fetch('Login.php', {
        method: 'POST',
        headers: { 'Content-Type':'application/x-www-form-urlencoded' },
        body: `usuarios=${encodeURIComponent(nome)}&senha=${encodeURIComponent(senha)}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'ok'){
            window.location.href = '../Filmes/index.php';
        } else {
            mostrarNotificacao(data.msg, 'erro');
        }
    })
    .catch(err => mostrarNotificacao('Erro no servidor!', 'erro'));
});
</script>

</body>
</html>
