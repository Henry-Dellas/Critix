<?php 
session_start();
// Verifica se o usuário está logado
if(!isset($_SESSION["usuarios"])) {
    header("location: login.php");
    exit;
}

// Conexão com o banco (mesma do login.php)
$conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");

$series_por_categoria = [];

// Buscar todas as categorias
$stmt = $conn->query("SELECT id, nome FROM categorias");
$categorias_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($categorias_db as $categoria) {
    // Buscar séries desta categoria
    $stmt = $conn->prepare("
        SELECT s.* 
        FROM series s 
        JOIN categoria_item ci ON s.id = ci.item_id AND ci.tipo_item = 'serie' 
        WHERE ci.categoria_id = :categoria_id
    ");
    $stmt->execute(['categoria_id' => $categoria['id']]);
    $series = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($series) {
        $series_por_categoria[$categoria['nome']] = $series;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Séries - DataMind</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/estrelinhas.css">
  <script src="js/script.js" defer></script>
</head>
<body>
<header class="topo">
  <div class="brand"><span>Bem-vindo(a), <?= htmlspecialchars($_SESSION["usuarios"]) ?></span> ao <strong>DataMind</strong></div>
  <nav class="abas">
    <a class="aba" href="index.php">Filmes</a>
    <a class="aba ativo" href="series.php">Séries</a>
    <a class="aba" href="livros.php">Livros</a>
  </nav>
  <div class="acoes">
    <div class="busca"><span class="icone-busca">🔍</span><input type="text" placeholder="Pesquisar"></div>
    <div class="avatar">👤</div>
    <a href="logout.php" style="margin-left: 15px; color: #333; text-decoration: none;">Sair</a>
  </div>
</header>

<main>
<?php foreach($series_por_categoria as $categoria => $itens): ?>
  <h2 class="categoria"><?= htmlspecialchars($categoria) ?></h2>
  <div class="lista">
    <?php foreach($itens as $item): ?>
      <div class="card" onclick="location.href='detalhes.php?id=<?= $item['id'] ?>&tipo=serie&cat=<?= urlencode($categoria) ?>'">
        <div class="thumb">
          <img src="imagens/<?= htmlspecialchars($item['imagem']) ?>" alt="<?= htmlspecialchars($item['titulo']) ?>">
          <div class="estrelas overlay" data-nota="<?= $item['nota'] ?>"></div>
        </div>
        <div class="info-card"><h3><?= htmlspecialchars($item['titulo']) ?></h3></div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>
</main>
</body>
</html>