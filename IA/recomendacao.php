<?php
$apiKeyTMDB = "7a4a474069f49e3f759f137ccfa33365";
$apiKeyGoogle = "";

$humor = $_POST['humor'] ?? '';
$tipo  = $_POST['tipo'] ?? 'filme';
$filtro = $_POST['filtro'] ?? 'popular';

if (!$humor || !$tipo) {
    header("Location: testeIA.html");
    exit;
}

$mapaHumorFilmes = [
    "animado"=>["genero"=>35], "triste"=>["genero"=>18], "romântico"=>["genero"=>10749],
    "assustado"=>["genero"=>27], "aventureiro"=>["genero"=>12], "pensativo"=>["genero"=>99],
    "curioso"=>["genero"=>9648], "empolgado"=>["genero"=>28], "sonhador"=>["genero"=>14],
];
$mapaHumorSeries = [
    "animado"=>["genero"=>35], "triste"=>["genero"=>18], "romântico"=>["genero"=>10766],
    "assustado"=>["genero"=>9648], "aventureiro"=>["genero"=>10759], "pensativo"=>["genero"=>99],
    "curioso"=>["genero"=>10765], "empolgado"=>["genero"=>80], "sonhador"=>["genero"=>16],
];
$mapaHumorLivros = [
    "animado"=>"comedy","triste"=>"drama","romântico"=>"romance","assustado"=>"terror",
    "aventureiro"=>"adventure","pensativo"=>"philosophy","curioso"=>"mystery",
    "empolgado"=>"action","sonhador"=>"fantasy"
];

if($tipo==="filme") $generoTMDB = $mapaHumorFilmes[$humor]["genero"] ?? 35;
elseif($tipo==="serie") $generoTMDB = $mapaHumorSeries[$humor]["genero"] ?? 35;
$generoLivro = $mapaHumorLivros[$humor] ?? "ficção";

$paramFiltro="";
switch($filtro){
    case "nota_alta": $paramFiltro="&vote_average.gte=7"; break;
    case "sem_terror": $paramFiltro="&without_genres=27"; break;
    case "lancamentos": $paramFiltro="&primary_release_year=".date("Y"); break;
}

$itemEscolhido = null;

if($tipo==="filme"){
    $url="https://api.themoviedb.org/3/discover/movie?api_key=$apiKeyTMDB&with_genres=$generoTMDB&language=pt-BR&page=1&include_adult=false$paramFiltro";
    $data=json_decode(@file_get_contents($url),true);
    $itens=$data["results"]??[];
    $itensValidos=array_values(array_filter($itens, fn($i)=>!empty($i["title"])&&!empty($i["overview"])&&!empty($i["poster_path"])));
    $itemEscolhido=$itensValidos[array_rand($itensValidos)]??null;
}elseif($tipo==="serie"){
    $url="https://api.themoviedb.org/3/discover/tv?api_key=$apiKeyTMDB&with_genres=$generoTMDB&language=pt-BR&page=1&include_adult=false$paramFiltro";
    $data=json_decode(@file_get_contents($url),true);
    $itens=$data["results"]??[];
    $itensValidos=array_values(array_filter($itens, fn($i)=>!empty($i["name"])&&!empty($i["overview"])&&!empty($i["poster_path"])));
    $itemEscolhido=$itensValidos[array_rand($itensValidos)]??null;
}elseif($tipo==="livro"){
    $url="https://www.googleapis.com/books/v1/volumes?q=subject:".urlencode($generoLivro)."&langRestrict=pt&maxResults=40&country=BR";
    if($apiKeyGoogle) $url.="&key=$apiKeyGoogle";
    $data=json_decode(@file_get_contents($url),true);
    $livros=$data["items"]??[];
    $livrosFiltrados=array_values(array_filter($livros, fn($l)=>!empty($l["volumeInfo"]["title"])));
    $itemEscolhido=$livrosFiltrados[array_rand($livrosFiltrados)]??null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Critix</title>
<link rel="shortcut icon" href="Adobe_Express_-_file40px.png" type="image/x-icon">
<style>
:root{
  --branco:#F8F9FA; --azul:#007B83; --coral:#FF6B6B; --transp:rgba(52,58,64,0.72);
}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
html,body{width:100%;height:100%;overflow:hidden;background:linear-gradient(135deg,#1e1e2f,#007B83);background-size:800% 800%;animation:grad 120s ease infinite;display:flex;justify-content:center;align-items:center;}
@keyframes grad{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%;}}
#emoji-container{position:fixed;top:0;left:0;width:100vw;height:100vh;pointer-events:none;z-index:0;overflow:hidden;}

.container{
  position:relative;
  padding:45px 35px;
  background:var(--transp);
  backdrop-filter:blur(14px);
  border-radius:20px;
  color:var(--branco);
  box-shadow:0 16px 45px rgba(0,0,0,0.55);
  width:85vw; max-width:820px;
  display:flex; flex-direction:column; gap:25px;
}

.back-inside{
  position:absolute;
  bottom:18px;
  right:18px;
  padding:16px 28px;
  background: linear-gradient(45deg, var(--azul), var(--coral));
  border:none;
  border-radius:16px;
  color:var(--branco);
  font-weight:600;
  text-decoration:none;
  cursor:pointer;
  font-size:17px;
  transition:all 0.3s ease;
}
.back-inside:hover{
  transform:scale(1.05);
  box-shadow:0 0 25px rgba(255,107,107,0.7);
}

.title{
  font-family:"Cinzel",serif;
  font-size:44px; 
  color:var(--coral);
  text-shadow:0 0 20px rgba(255,107,107,0.8);
  margin-bottom:15px;
  margin-left:15px;
}

.main{display:flex;align-items:center;gap:25px;width:100%;min-height:320px;}
.poster{flex:0 0 240px; display:flex; justify-content:center; align-items:center;}
.poster img{width:100%; height:auto; border-radius:14px; box-shadow:0 12px 32px rgba(0,0,0,0.55);}
.textos{flex:1 1 auto; min-width:0; display:flex; flex-direction:column; justify-content:center;}
.textos h2{color:var(--coral); font-size:24px; margin-bottom:12px;}
.textos p{line-height:1.8; font-size:17px; overflow-wrap:break-word;}

@media(max-width:750px){
  .main{flex-direction:column;align-items:center;text-align:center;}
  .poster{flex:0 0 220px;}
  .title{font-size:36px; margin-left:10px;}
}
</style>
</head>
<body>
<div id="emoji-container"></div>

<div class="container">
    <div class="title">Sua Indicação</div>
    <div class="main">
        <?php if($tipo==="filme"&&$itemEscolhido): ?>
            <div class="poster"><img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($itemEscolhido['poster_path']) ?>" alt="Poster"></div>
            <div class="textos">
                <h2><?= htmlspecialchars($itemEscolhido['title']) ?></h2>
                <p><?= htmlspecialchars($itemEscolhido['overview']) ?></p>
            </div>
        <?php elseif($tipo==="serie"&&$itemEscolhido): ?>
            <div class="poster"><img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($itemEscolhido['poster_path']) ?>" alt="Poster"></div>
            <div class="textos">
                <h2><?= htmlspecialchars($itemEscolhido['name']) ?></h2>
                <p><?= htmlspecialchars($itemEscolhido['overview']) ?></p>
            </div>
            <?php elseif ($tipo === "livro" && $itemEscolhido): ?>        
        <?php 
            $info = $itemEscolhido["volumeInfo"];
            $tituloOriginal = htmlspecialchars($info["title"]);
            $descricaoOriginal = htmlspecialchars($info["description"] ?? "Sem descrição disponível");

            // função para traduzir texto usando API gratuita
            function traduzirTexto($texto, $de = "en", $para = "pt-BR") {
                if (empty($texto)) return $texto;

                // Remove tags HTML
                $texto = trim(strip_tags($texto));

                // Evita erro de limite de API
                if (strlen($texto) > 480) {
                    $texto = substr($texto, 0, 480);
                }

                $max = 200;
                $partes = [];
                $len = mb_strlen($texto, 'UTF-8');
                for ($offset = 0; $offset < $len; $offset += $max) {
                    $partes[] = mb_substr($texto, $offset, $max, 'UTF-8');
                }
                $traducaoFinal = '';

                foreach ($partes as $parte) {
                    $urlParte = "https://api.mymemory.translated.net/get?q=" . urlencode($parte) . "&langpair={$de}|{$para}";
                    $respParte = @file_get_contents($urlParte);
                    if ($respParte) {
                        $dadosParte = json_decode($respParte, true);
                        $traducaoFinal .= ($dadosParte["responseData"]["translatedText"] ?? $parte);
                    } else {
                        $traducaoFinal .= $parte . ' ';
                    }
                    usleep(150000);
                }
                
                return trim($traducaoFinal);
                
            }

            $tituloTraduzido = traduzirTexto($tituloOriginal);
            $descricaoTraduzida = traduzirTexto($descricaoOriginal);

            $titulo = htmlspecialchars($tituloTraduzido, ENT_QUOTES, 'UTF-8');
            $descricao = htmlspecialchars($descricaoTraduzida, ENT_QUOTES, 'UTF-8');
            $imagem = $info["imageLinks"]["thumbnail"] ?? "https://via.placeholder.com/150x220?text=Sem+Imagem";
            $link = $info["infoLink"] ?? "#";
        ?>
            <div class="poster"><img src="<?= $imagem ?>" alt="Capa"></div>
            <div class="textos">
                <h2>📚 <?= $titulo ?></h2>
                <p><?= $descricao ?></p>
            </div>
        <?php else: ?>
            <div class="poster"><img src="https://via.placeholder.com/220x300?text=Sem+Imagem" alt="Sem resultado"></div>
            <div class="textos">
                <h2>❌ Nenhum resultado encontrado</h2>
                <p>Tente outro filtro ou humor.</p>
            </div>
        <?php endif; ?>
    </div>
    <a class="back-inside" href="testeIA.html">Voltar</a>
</div>

<script>
const emojis=["✨","🌟","💫","🎬","📚","🍿","🎶","🎥","📖"];
const container=document.getElementById('emoji-container');
function createEmoji(){
    const e=document.createElement('div');
    e.textContent=emojis[Math.floor(Math.random()*emojis.length)];
    e.style.position='absolute'; e.style.left=Math.random()*100+'vw'; e.style.top='100vh';
    e.style.fontSize=(Math.random()*22+20)+'px'; e.style.opacity=(Math.random()*0.6+0.25).toString();
    e.style.pointerEvents='none'; container.appendChild(e);
    const dur=(Math.random()*8+8)*1000;
    e.animate([{transform:'translateY(0) rotate(0deg)',opacity:e.style.opacity},{transform:'translateY(-120vh) rotate(360deg)',opacity:0}],{duration:dur,easing:'linear'});
    setTimeout(()=>{try{container.removeChild(e);}catch{}},dur);
}
setInterval(createEmoji,400);
</script>
</body>
</html>
