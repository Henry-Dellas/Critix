<?php 
session_start(); 
if (!isset($_SESSION["usuarios"])) { 
    header("location:Login Teste.php"); 
} 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Critix</title>
<link rel="shortcut icon" href="Adobe_Express_-_file40px.png" type="image/x-icon">
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<style>
:root {
    --branco-gelo: #F8F9FA;
    --cinza-escuro: #343A40;
    --azul-petroleo: #007B83;
    --coral: #FF6B6B;
}

* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', Arial, Helvetica, sans-serif; }

html, body { width: 100%; min-height: 100%; overflow-y: auto; position: relative; }

body {
    display: flex;
    flex-direction: column;
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
    margin: 0 auto 40px auto;
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

/* === Containers de carrossel === */
#tipo-container {
    margin-bottom: 20px;
    text-align: center;
    color: white;
}

#carrossel-container {
    position: relative;
    z-index: 1;
    background: #2e2e38;
    border-radius: 25px;
    padding: 25px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.5);
    max-width: 1200px;
    width: 90%;
    margin: 0 auto 30px auto;
}

.swiper {
    width: 100%;
    padding: 20px 0;
}
.swiper-slide {
    background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(0,0,0,0.2));
    border-radius: 18px;
    overflow: hidden;
    text-align: center;
    transition: transform .3s ease;
}
.swiper-slide:hover { transform: scale(1.07); }
.poster {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
.slide-info {
    color: #fff;
    padding: 10px;
    font-size: 14px;
}

#emoji-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1; }
.emoji { position: absolute; font-size: 24px; animation: float 10s linear infinite; }
@keyframes float { 0% { transform: translateY(100vh) rotate(0deg); } 100% { transform: translateY(-10vh) rotate(360deg); } }

@media (max-width: 1200px) { 
    #bemvindo { font-size: 1.8em; } 
    #button, #button-indicacoes { padding: 15px 30px; font-size: 15px; } 
}
@media (max-width: 800px) { 
    #area-texto { flex-direction: column; align-items: stretch; gap: 20px; } 
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
        <a href="../SobreNos.php" id="button-indicacoes">Sobre Nós</a>
        <a href="../IA/testeIA.html" id="button-indicacoes">Ir para Indicações</a>
        <a href="../Cadastro_Login/logout.php" id="button">Sair da conta</a>
    </div>
</div>

<!-- Seletor Filmes/Séries -->
<div id="tipo-container">
    <label for="tipo">Selecione tipo:</label>
    <select id="tipo" style="padding:10px 15px; border-radius:8px; font-size:16px;">
        <option value="movie" selected>Filmes</option>
        <option value="tv">Séries</option>
        <option value="livro">Livros</option> 
    </select>
</div>

<!-- 🔍 Barra de Pesquisa -->
<div id="search-container" style="text-align:center; margin-bottom:25px;">
  <input 
    type="text" 
    id="searchInput" 
    placeholder="Buscar filmes ou séries..." 
    style="padding:10px 15px; border-radius:8px; font-size:16px; width:50%; max-width:400px;"
  >
  <button id="searchButton" style="padding:10px 20px; border-radius:8px; background:#FF6B6B; color:white; border:none; cursor:pointer;">
    Pesquisar
  </button>
  <button id="clearButton" style="padding:10px 20px; border-radius:8px; background:#007B83; color:white; border:none; cursor:pointer; display:none;">
    Limpar busca
  </button>
</div>

<!-- 🔎 Resultados da Pesquisa -->
<div id="searchResults" style="display:none;"></div>



<!-- Carrosséis por gênero -->
<div id="carrossel-principal"></div>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
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

// API TMDb
const TMDB_API_KEY = "7a4a474069f49e3f759f137ccfa33365";
const TMDB_LANGUAGE = "pt-BR";

const generos = {
    movie: [
        {id:28, name:"Ação"},
        {id:35, name:"Comédia"},
        {id:18, name:"Drama"},
        {id:27, name:"Terror"},
        {id:10749, name:"Romance"},
    ],
    tv: [
        {id:10759, name:"Ação & Aventura"},
        {id:35, name:"Comédia"},
        {id:18, name:"Drama"},
        {id:10765, name:"Fantasia & Ficção"},
        {id:80, name:"Crime"},
    ],
    livro: [
        {id: "fiction", name: "Ficção"},
        {id: "romance", name: "Romance"},
        {id: "horror", name: "Terror"},
        {id: "history", name: "História"},
        {id: "science", name: "Ciência"}
    ]
};

// Busca livros pelo termo digitado (ou gênero, dependendo do uso)
async function fetchBooks(query) {
    try {
        const encodedQuery = encodeURIComponent(query);
        const url = `https://www.googleapis.com/books/v1/volumes?q=${encodedQuery}&maxResults=10&printType=books`;

        const response = await fetch(url);
        if (!response.ok) throw new Error("Erro ao acessar API Google Books");

        const data = await response.json();

        if (!data.items || data.items.length === 0) {
            console.warn("Nenhum livro encontrado para:", query);
            return [];
        }

        return data.items;
    } catch (error) {
        console.error("Erro em fetchBooks:", error);
        return [];
    }
}

async function fetchMedia(tipo = "movie", generoId = null, page = 1) {
  const url = `https://api.themoviedb.org/3/discover/${tipo}?api_key=${TMDB_API_KEY}&language=${TMDB_LANGUAGE}&sort_by=popularity.desc&page=${page}&include_adult=false${generoId ? "&with_genres=" + generoId : ""}`;

  const res = await fetch(url);
  const data = await res.json();
  const results = data.results || [];

  const adultKeywords = [
    "porn", "xxx", "erotic", "adult", "sex", "18+", "nude", "explicit", "hot", "sensual",
    "ligaw", "bold", "temptation", "affair", "lust", "seduction" // adiciona aqui as palavras que quiser
  ];

  // função para detectar conteúdo adulto
  function isAdultContent(item) {
    if (item.adult === true) return true;

    const textToCheck = `
      ${item.title || ""} 
      ${item.original_title || ""} 
      ${item.name || ""} 
      ${item.original_name || ""} 
      ${item.overview || ""}
    `.toLowerCase();

    return adultKeywords.some(word => textToCheck.includes(word));
  }

  const filtered = results.filter(item => !isAdultContent(item));

  return filtered;
}

async function fetchMedia(tipo="movie", generoId=null, page=1){
    let url = `https://api.themoviedb.org/3/discover/${tipo}?api_key=${TMDB_API_KEY}&language=${TMDB_LANGUAGE}&sort_by=popularity.desc&page=${page}`;
    if (generoId) url += `&with_genres=${generoId}`;
    const res = await fetch(url);
    const data = await res.json();
    return data.results;
}

function createMediaSlide(item, tipo) {
    const imageUrl = item.poster_path
        ? `https://image.tmdb.org/t/p/w500${item.poster_path}`
        : "https://via.placeholder.com/300x450?text=Sem+Imagem";
    const title = item.title || item.name || "Título indisponível";
    const nota = item.vote_average ? item.vote_average.toFixed(1) : "-";
    const link = tipo === "movie" ? `filme.php?id=${item.id}` : `serie.php?id=${item.id}`;

    return `
        <div class="swiper-slide">
            <a href="${link}" class="slide-link">
                <img src="${imageUrl}" alt="${title}" class="poster">
                <div class="slide-info">
                    <strong>${title}</strong><br>
                    ⭐ ${nota} / 10
                </div>
            </a>
        </div>
    `;
}

// Atualiza a função initCarrossels para suportar livros
async function initCarrossels(tipo = "movie") {
    const container = document.getElementById("carrossel-principal");
    container.innerHTML = ""; // limpa antes de inserir
    container.style.display = "block"; // garante que container seja exibido

    for (const genero of generos[tipo]) {
        // Cria container do gênero
        const generoContainer = document.createElement("div");
        generoContainer.classList.add("carrossel-gen");
        generoContainer.innerHTML = `
            <div id="carrossel-container">
                <h2 style="color:white; margin-bottom:15px;">${tipo === "livro" ? "📚" : "🎬"} ${genero.name}</h2>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper" id="swiper-${tipo}-${genero.id}"></div>
                </div>
            </div>
        `;
        container.appendChild(generoContainer);

        const wrapper = document.getElementById(`swiper-${tipo}-${genero.id}`);
        let slidesHtml = "";

        if (tipo === "livro") {
            // Busca livros pelo gênero
            const livros = await fetchBooks(genero.id);
            slidesHtml = livros.map(book => {
                const info = book.volumeInfo || {};
                const title = info.title || "Título indisponível";
                const imageUrl = info.imageLinks?.thumbnail 
                    ? info.imageLinks.thumbnail.replace("http:", "https:") 
                    : "https://via.placeholder.com/300x450?text=Sem+Imagem";
                const description = info.description 
                    ? info.description.substring(0, 100) + "..." 
                    : "Sem descrição disponível";

                return `
                    <div class="swiper-slide">
                        <a href="livros.php?id=${book.id}" class="slide-link">
                            <img src="${imageUrl}" alt="${title}" class="poster">
                            <div class="slide-info">
                                <strong>${title}</strong><br>
                                📖 ${description}
                            </div>
                        </a>
                    </div>
                `;
            }).join("");
        } else {
            // Filmes ou séries
            const mediaList = await fetchMedia(tipo, genero.id);
            slidesHtml = mediaList.map(item => createMediaSlide(item, tipo)).join("");
        }

        wrapper.innerHTML = slidesHtml;

        // Inicializa Swiper
        new Swiper(`#carrossel-container .mySwiper`, {
            slidesPerView: 5,
            spaceBetween: 15,
            loop: true,
            autoplay: { delay: 2500, disableOnInteraction: false },
            breakpoints: {
                0: { slidesPerView: 1 },
                600: { slidesPerView: 2 },
                900: { slidesPerView: 4 },
                1200: { slidesPerView: 5 }
            }
        });
    }
}

// 🔎 Função para buscar filmes/séries na TMDb
async function searchMedia(query, tipo="movie") {
  if (!query.trim()) return [];

  if (tipo === "livro") {
    const apiKeyGoogle = "";
    const url = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&maxResults=20&langRestrict=pt`;
    const res = await fetch(url);
    const data = await res.json();
    return data.items || [];
  } else {
  const url = `https://api.themoviedb.org/3/search/${tipo}?api_key=${TMDB_API_KEY}&language=${TMDB_LANGUAGE}&query=${encodeURIComponent(query)}&include_adult=false`;
  const res = await fetch(url);
  const data = await res.json();
  return data.results || [];
  }
}

function createSearchCard(item, tipo) {
  if (tipo === "livro") {
    const info = item.volumeInfo || {};
    const title = info.title && info.title.trim() !== "" ? info.title : "Título não disponível";
    const authors = Array.isArray(info.authors) ? info.authors.join(", ") : "Autor desconhecido";
    const description = info.description ? info.description.substring(0, 120) + "..." : "Sem descrição disponível.";
    const imageUrl = info.imageLinks?.thumbnail
      ? info.imageLinks.thumbnail.replace("http:", "https:")
      : "https://via.placeholder.com/300x450?text=Sem+Imagem";

    // Usa o ID do livro para abrir a página interna
    const bookId = item.id || "";

    return `
      <div style="
        background:#2e2e38;
        border-radius:15px;
        padding:10px;
        margin:10px;
        text-align:center;
        color:white;
        width:180px;
        box-shadow:0 6px 20px rgba(0,0,0,0.4);
        transition:transform 0.3s;
      " onmouseover="this.style.transform='scale(1.07)'" onmouseout="this.style.transform='scale(1)'">
        <a href="livros.php?id=${bookId}" style="text-decoration:none; color:white;">
          <img src="${imageUrl}" alt="${title}" style="width:100%; border-radius:10px;">
          <div style="margin-top:8px;">
            <strong>${title}</strong><br>
            <small>${authors}</small><br>
            <p style="font-size:12px; margin-top:5px; opacity:0.8;">${description}</p>
          </div>
        </a>
      </div>
    `;
  } else {  
    // Filmes / Séries (inalterado)
    const imageUrl = item.poster_path
      ? `https://image.tmdb.org/t/p/w500${item.poster_path}`
      : "https://via.placeholder.com/300x450?text=Sem+Imagem";
    const title = item.title || item.name || "Título indisponível";
    const nota = item.vote_average ? item.vote_average.toFixed(1) : "-";
    const id = item.id;

    const link = tipo === "movie" ? `filme.php?id=${id}` : `serie.php?id=${id}`;

    return `
      <div style="
        background:#2e2e38;
        border-radius:15px;
        padding:10px;
        margin:10px;
        text-align:center;
        color:white;
        width:180px;
        box-shadow:0 6px 20px rgba(0,0,0,0.4);
        transition:transform 0.3s;
      " onmouseover="this.style.transform='scale(1.07)'" onmouseout="this.style.transform='scale(1)'">
        <a href="${link}" style="text-decoration:none; color:white;">
          <img src="${imageUrl}" alt="${title}" style="width:100%; border-radius:10px;">
          <div style="margin-top:8px;">
            <strong>${title}</strong><br>
            ⭐ ${nota} / 10
          </div>
        </a>
      </div>
    `;
  }
}

// 🔍 Evento do botão de pesquisa
document.getElementById("searchButton").addEventListener("click", async () => {
  const query = document.getElementById("searchInput").value;
  const tipo = document.getElementById("tipo").value;
  const resultsDiv = document.getElementById("searchResults");
  const carrosselDiv = document.getElementById("carrossel-principal");
  const clearButton = document.getElementById("clearButton");

  resultsDiv.style.display = "block";
  resultsDiv.innerHTML = "<p style='color:white; text-align:center;'>🔎 Buscando...</p>";

  const results = await searchMedia(query, tipo);

  if (results.length === 0) {
    resultsDiv.innerHTML = "<p style='color:white; text-align:center;'>Nenhum resultado encontrado 😢</p>";
    return;
  }

  // Oculta os carrosséis
  carrosselDiv.style.display = "none";
  clearButton.style.display = "inline-block";

  // Exibe resultados
  resultsDiv.style.display = "flex";
  resultsDiv.style.flexWrap = "wrap";
  resultsDiv.style.justifyContent = "center";
  resultsDiv.style.gap = "15px";
  resultsDiv.innerHTML = results.map(item => createSearchCard(item, tipo)).join("");
});

// 🧹 Limpa a busca e restaura os carrosséis
document.getElementById("clearButton").addEventListener("click", () => {
  document.getElementById("searchInput").value = "";
  document.getElementById("searchResults").style.display = "none";
  document.getElementById("carrossel-principal").style.display = "block";
  document.getElementById("clearButton").style.display = "none";
});

// 🔄 Pressionar Enter também faz a busca
document.getElementById("searchInput").addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    e.preventDefault();
    document.getElementById("searchButton").click();
  }
});


// Listener do seletor
document.getElementById("tipo").addEventListener("change", (e)=>{
    initCarrossels(e.target.value);
});

// Inicializa
document.addEventListener("DOMContentLoaded", ()=>{
    initCarrossels(document.getElementById("tipo").value);
});
</script>
</body>
</html>
