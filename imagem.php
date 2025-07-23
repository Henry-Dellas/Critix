<?php
$pdo = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT imagem FROM filmes WHERE id = ?");
$stmt->execute([$id]);
$filme = $stmt->fetch(PDO::FETCH_ASSOC);
if ($filme && !empty($filme['imagem'])) {
    header("Content-Type: image/jpeg");
    echo $filme['imagem'];
    exit;
} else {
    header("Content-Type: text/plain");
    echo "Imagem não encontrada.";
}
?>
