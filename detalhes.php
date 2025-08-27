<?php
session_start();
// Verifica se o usuário está logado
if(!isset($_SESSION["usuarios"])) {
    header("location: login.php");
    exit;
}

// Conexão com o banco (mesma do login.php)
$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$catAtual = isset($_GET['cat']) ? $_GET['cat'] : '';

if (!$id || !in_array($tipo, ['filme', 'livro', 'serie'])) { 
    http_response_code(404); 
    die("Item não encontrado."); 
}

// Buscar o item específico
$table = $tipo . 's'; // filmes, livros ou series
$stmt = $conn->prepare("SELECT * FROM $table WHERE id = :id");
$stmt->execute(['id' => $id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    http_response_code(404);
    die("Item não encontrado.");
}

// Buscar relacionados: mesmo autor/diretor
$relMesmoAutor = [];
if (!empty($item['autor'])) {
    $stmt = $conn->prepare("
        SELECT * FROM $table 
        WHERE autor = :autor AND id != :id 
        LIMIT 6
    ");
    $stmt->execute(['autor' => $item['autor'], 'id' => $id]);
    $relMesmoAutor = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Buscar relacionados: mesmo gênero
$relMesmoGenero = [];
if (!empty($item['genero'])) {
    $stmt = $conn->prepare("
        SELECT * FROM $table 
        WHERE genero = :genero AND id != :id 
        LIMIT 6
    ");
    $stmt->execute(['genero' => $item['genero'], 'id' => $id]);
    $relMesmoGenero = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Combinar resultados mantendo a prioridade
$relacionados = array_merge($relMesmoAutor, $relMesmoGenero);
$relacionados = array_slice($relacionados, 0, 6);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($item['titulo']) ?> - DataMind</title>
  <link rel="stylesheet" href="css/detalhes.css">
  <link rel="stylesheet" href="css/estrelinhas.css">
  <script src="js/script.js" defer></script>
</head>
<body>
<header class="topo">
  <a class="voltar" href="<?= $tipo==='livro'?'livros.php':($tipo==='serie'?'series.php':'index.php') ?>">⬅ Voltar</a>
  <nav class="abas">
    <a class="aba <?= $tipo==='filme'?'ativo':'' ?>" href="index.php">Filmes</a>
    <a class="aba <?= $tipo==='serie'?'ativo':'' ?>" href="series.php">Séries</a>
    <a class="aba <?= $tipo==='livro'?'ativo':'' ?>" href="livros.php">Livros</a>
  </nav>
  <div class="acoes">
    <div class="busca"><span class="icone-busca">🔍</span><input type="text" placeholder="Pesquisar"></div>
    <div class="avatar">👤 <?= htmlspecialchars($_SESSION["usuarios"]) ?></div>
    <a href="logout.php" style="margin-left: 15px; color: #333; text-decoration: none;">Sair</a>
  </div>
</header>

<main class="layout-detalhes">
  <!-- ESQUERDA: capa + relacionados -->
  <aside class="col-esq">
    <div class="capa">
      <img src="imagens/<?= htmlspecialchars($item['imagem']) ?>" alt="<?= htmlspecialchars($item['titulo']) ?>">
    </div>

    <?php if (!empty($relacionados)): ?>
      <h4 class="titulo-bloco"><?= ucfirst($tipo) ?>s Relacionados</h4>
      <div class="rel-livros">
        <?php foreach ($relacionados as $rel): ?>
          <div class="rel-card" onclick="location.href='detalhes.php?id=<?= $rel['id'] ?>&tipo=<?= $tipo ?>'">
            <img src="imagens/<?= htmlspecialchars($rel['imagem']) ?>" alt="<?= htmlspecialchars($rel['titulo']) ?>">
            <p><?= htmlspecialchars($rel['titulo']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </aside>

  <!-- CENTRO: conteúdo -->
  <section class="col-centro">
    <h1 class="titulo-item"><?= htmlspecialchars($item['titulo']) ?></h1>
    <div class="estrelas" data-nota="<?= $item['nota'] ?>"></div>

    <p class="descricao"><?= htmlspecialchars($item['detalhes'] ?? $item['descricao'] ?? '') ?></p>

    <!-- badges/infos como no mock -->
    <div class="linha-badges">
      <div class="badge"><span class="ico">📘</span> <?= $tipo==='livro'?'Lido':'Visto' ?></div>
      <div class="badge ok"><span class="ico">✔</span> Completo</div>
    </div>

    <div class="linha-metas">
      <?php if ($tipo==='livro'): ?>
        <div class="meta">
          <span class="barra"></span>
          <small>Aprox. <?= $item['paginas'] ?? 240 ?></small><br>
          <span class="rotulo">Número de páginas</span>
        </div>
      <?php elseif ($tipo==='serie'): ?>
        <div class="meta">
          <span class="barra"></span>
          <small><?= $item['temporadas'] ?? '—' ?></small><br>
          <span class="rotulo">Temporadas</span>
        </div>
      <?php endif; ?>
        <div class="meta">
          <span class="barra"></span>
          <small><?= $item['ano'] ?? '—' ?></small><br>
          <span class="rotulo">Ano</span>
        </div>

      <div class="meta">
        <div class="idade">16+</div>
        <span class="rotulo">Classificação</span>
      </div>
    </div>

    <h2 class="sub">Notas da Comunidade</h2>
    <div class="tabs">
      <button class="tab-btn ativo">Sem Spoiler</button>
      <button class="tab-btn">Com Spoiler</button>
    </div>
    <div class="comentarios">
      <div class="comentario">
        <div class="foto">N</div>
        <div>
          <div class="linha-user">
            <strong>NoobMaster69</strong>
            <div class="estrelas" data-nota="<?= $item['nota'] ?>"></div>
          </div>
          <p class="texto"><?= $tipo==='livro'
            ? "Ótimo romance; desenvolvimento de personagens e ambientação excelentes."
            : ($tipo==='serie' ? "Ritmo envolvente, personagens carismáticos e finais de temporada fortes."
                               : "Direção segura e atuações marcantes; fotografia impecável.") ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- DIREITA: cartão do autor/director -->
  <aside class="col-dir">
    <div class="autor-card">
      <div class="autor-foto"><?= strtoupper(substr($item['autor'],0,1)) ?></div>
      <h3><?= htmlspecialchars($item['autor']) ?></h3>
      <p class="bio">
        <?php if ($tipo==='livro'): ?>
          <?= htmlspecialchars($item['autor']) ?> é referência em literatura do gênero. "<?= htmlspecialchars($item['titulo']) ?>" segue como uma de suas obras mais queridas.
        <?php elseif ($tipo==='serie'): ?>
          Criado/direção de <?= htmlspecialchars($item['autor']) ?>, com episódios elogiados pela crítica.
        <?php else: ?>
          Realização de <?= htmlspecialchars($item['autor']) ?>, destaque pelo trabalho em grandes produções.
        <?php endif; ?>
      </p>
    </div>
  </aside>
</main>
</body>
</html>