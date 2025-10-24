<?php
// Configurações de API
$apiKeyTMDB = "7a4a474069f49e3f759f137ccfa33365"; // Gere em: https://www.themoviedb.org/settings/api
$apiKeyGoogle = ""; // Opcional para Google Books (pode deixar vazio para uso básico)

// Captura entradas do formulário
$humor = $_POST['humor'] ?? '';
$tipo  = $_POST['tipo'] ?? 'filme';
$filtro = $_POST['filtro'] ?? 'popular';

if (!$humor || !$tipo) {
    header("Location: TesteIA.html");
    exit;
}

// Mapeamento de humor → gêneros
$mapaHumorFilmes = [
    "animado" => ["genero" => 35],        // Comédia
    "triste" => ["genero" => 18],         // Drama
    "romântico" => ["genero" => 10749],   // Romance
    "assustado" => ["genero" => 27],      // Terror
    "aventureiro" => ["genero" => 12],    // Aventura
    "pensativo" => ["genero" => 99],      // Documentário
    "curioso" => ["genero" => 9648],      // Mistério
    "empolgado" => ["genero" => 28],      // Ação
    "sonhador" => ["genero" => 14],       // Fantasia
];

$mapaHumorSeries = [
    "animado" => ["genero" => 35],        // Comédia
    "triste" => ["genero" => 18],         // Drama
    "romântico" => ["genero" => 10766],   // Novela / Romance
    "assustado" => ["genero" => 9648],    // Mistério
    "aventureiro" => ["genero" => 10759], // Action & Adventure
    "pensativo" => ["genero" => 99],      // Documentário
    "curioso" => ["genero" => 10765],     // Sci-Fi & Fantasy
    "empolgado" => ["genero" => 80],      // Crime
    "sonhador" => ["genero" => 16],       // Animação
];

// ===== MAPEAMENTO DE HUMOR PARA LIVROS (Google Books) =====
$mapaHumorLivros = [
    "animado" => "comedy",
    "triste" => "drama",
    "romântico" => "romance",
    "assustado" => "terror",
    "aventureiro" => "adventure",
    "pensativo" => "philosophy",
    "curioso" => "mystery",
    "empolgado" => "action",
    "sonhador" => "fantasy"
];

if ($tipo === "filme") {
    $generoTMDB = $mapaHumorFilmes[$humor]["genero"] ?? 35;
} elseif ($tipo === "serie") {
    $generoTMDB = $mapaHumorSeries[$humor]["genero"] ?? 35;
}

$generoLivro = $mapaHumorLivros[$humor] ?? "ficção";

// Filtragem
$paramFiltro = "";
switch ($filtro) {
    case "nota_alta":
        $paramFiltro = "&vote_average.gte=7";
        break;
    case "sem_terror":
        $paramFiltro = "&without_genres=27";
        break;
    case "lancamentos":
        $anoAtual = date("Y");
        $paramFiltro = "&primary_release_year=$anoAtual";
        break;
    case "popular":
    default:
        break;
}

// Inicializa variáveis
$itemEscolhido = null;
$tipoLabel = ucfirst($tipo);

// --- Filme ---
if ($tipo === "filme") {
    $url = "https://api.themoviedb.org/3/discover/movie?api_key=$apiKeyTMDB&with_genres=$generoTMDB&language=pt-BR&page=1$include_adult=false$paramFiltro";
    $resposta = @file_get_contents($url);
    $data = json_decode($resposta, true);
    $itens = $data["results"] ?? [];
    $itensValidos = array_filter($itens, function ($item) {
        return !empty($item["title"]) &&
               !empty($item["overview"]) &&
               !empty($item["poster_path"]);
    });
    $itensValidos = array_values($itensValidos);
    $itemEscolhido = !empty($itensValidos) ? $itensValidos[array_rand($itensValidos)] : null;

// --- Série ---
} elseif ($tipo === "serie") {
    $url = "https://api.themoviedb.org/3/discover/tv?api_key=$apiKeyTMDB&with_genres=$generoTMDB&language=pt-BR&page=1$include_adult=false$paramFiltro";
    $resposta = @file_get_contents($url);
    $data = json_decode($resposta, true);
    $itens = $data["results"] ?? [];
    $itensValidos = array_filter($itens, function ($item) {
        return !empty($item["name"]) &&
               !empty($item["overview"]) &&
               !empty($item["poster_path"]);
    });
    $itensValidos = array_values($itensValidos);
    $itemEscolhido = !empty($itensValidos) ? $itensValidos[array_rand($itensValidos)] : null;

// --- Livro ---
} elseif ($tipo === "livro") {
    $url = "https://www.googleapis.com/books/v1/volumes?q=subject:" . urlencode($generoLivro) . "&langRestrict=pt&maxResults=40&country=BR";
    if ($apiKeyGoogle) {
        $url .= "&key=$apiKeyGoogle";
    }
    $urlPT = $url . "&langRestrict=pt";
    $resposta = @file_get_contents($urlPT);   
    $data = json_decode($resposta, true);
    $livros = $data["items"] ?? [];
    $livrosFiltrados = array_filter($livros, function ($livro) {
        $info = $livro["volumeInfo"] ?? [];
        return !empty($info["title"])
            && !empty($info["description"])
            && !empty($info["imagelinks"]["thumbnail"])
            && in_array($info["language"] ?? "", ["pt", "pt-BR"]);
    });

    if (empty($livrosFiltrados)) {
        $resposta = @file_get_contents($url);
        $data = json_decode($resposta, true);
        $livros = $data["items"] ?? [];

        $livrosFiltrados = array_filter($livros, function ($livro) {
            $info = $livro["volumeInfo"] ?? [];
            return !empty($info["title"]) &&
                   !empty($info["description"]) &&
                   !empty($info["imageLinks"]["thumbnail"]);
        });
    }
    $livrosFiltrados = array_values($livrosFiltrados);
    $itemEscolhido = !empty($livrosFiltrados) ? $livrosFiltrados[array_rand($livrosFiltrados)] : null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Recomendação</title>
  <link rel="stylesheet" href="EstiloIA.css">
</head>
<body>
  <div class="container">
    <h1>✨ Sua Recomendação</h1>
    <p><strong>Humor detectado:</strong> <?= htmlspecialchars($humor) ?></p>
    <p><strong>Tipo escolhido:</strong> <?= htmlspecialchars($tipoLabel) ?></p>
    <p><strong>Filtro escolhido:</strong> <?= htmlspecialchars($filtro) ?></p>
    <hr>

    <?php if ($tipo === "filme" && !empty($itemEscolhido)): ?>
        <h2><?= htmlspecialchars($itemEscolhido["title"]) ?></h2>
        <p><?= htmlspecialchars($itemEscolhido["overview"]) ?></p>
        <?php if ($itemEscolhido["poster_path"]): ?>
            <img src="https://image.tmdb.org/t/p/w300<?= $itemEscolhido["poster_path"] ?>" alt="Poster do filme">
        <?php endif; ?>

    <?php elseif ($tipo === "serie" && $itemEscolhido): ?>
        <h2><?= htmlspecialchars($itemEscolhido["name"]) ?></h2>
        <p><?= htmlspecialchars($itemEscolhido["overview"]) ?></p>
        <?php if ($itemEscolhido["poster_path"]): ?>
            <img src="https://image.tmdb.org/t/p/w300<?= $itemEscolhido["poster_path"] ?>" alt="Poster da série">
        <?php endif; ?>

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
                    $partes[] = mb_substr($texto, $offset $max, 'UTF-8');
                }
                $traducaoFinal = '';

                foreach ($partes as $parte) {
                    $urlParte = "https://api.mymemory.translated.net/get?q=" . urlencode($parte) . "&langpair={$de}|{$para}";
                    $respParte = @file_get_contents($urlParte);
                    if ($respParte) {
                        $dadosParte = json_decode($respParte, true);
                        $traducaoFinal .= ($dadosParte["responseData"]["translatedText"] ?? $parte) . ' ';                       
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
    
    <h2>📚 Livro recomendado:</h2>
            <div>
                <img src="<?= $imagem ?>" alt="Capa de <?= $titulo ?>" style="width:150px;height:auto;border-radius:8px;">
                <div>
                    <h3><?= $titulo ?></h3>
                    <p><?= $descricao ?></p>
                    <?php if ($link !== "#"): ?>
                        <a href="<?= $link ?>" target="_blank" style="color:#007BFF;text-decoration:none;">🔗 Ver mais detalhes</a>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <p>❌ Nenhum livro encontrado.</p>
        <?php endif; ?>


    <br><br>
    <a href="testeIA.html"><button>Voltar</button></a>
  </div>
</body>
</html>