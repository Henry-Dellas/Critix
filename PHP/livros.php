<?php include "dados.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Livros - DataMind</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/estrelinhas.css">
  <script src="js/script.js" defer></script>
</head>
<body>
<header class="topo">
  <div class="brand"><span>Bem-vindo(a)</span> ao <strong>DataMind</strong></div>
  <nav class="abas">
    <a class="aba" href="index.php">Filmes</a>
    <a class="aba" href="series.php">Séries</a>
    <a class="aba ativo" href="livros.php">Livros</a>
  </nav>
  <div class="acoes">
    <div class="busca"><span class="icone-busca">🔍</span><input type="text" placeholder="Pesquisar"></div>
    <div class="avatar">👤</div>
  </div>
</header>

<main>
<?php 
$livros_por_categoria = [];
foreach($categorias as $categoria => $itens) {
  $livros = array_filter($itens, fn($i)=>$i['tipo']==='livro');
  if($livros) $livros_por_categoria[$categoria] = $livros;
}
foreach($livros_por_categoria as $categoria => $itens): ?>
  <h2 class="categoria"><?= htmlspecialchars($categoria) ?></h2>
  <div class="lista">
    <?php foreach($itens as $id => $item): ?>
      <div class="card" onclick="location.href='detalhes.php?id=<?= $id ?>&cat=<?= urlencode($categoria) ?>'">
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
