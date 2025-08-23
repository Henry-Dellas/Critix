<?php
$pdo = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
$id = $_GET['id'] ?? 0;

// Ativa modo de streaming
$stmt = $pdo->prepare("SELECT imagem_diretor FROM filmes WHERE id = ?");
$stmt->execute([$id]);
$stmt->bindColumn('imagem_diretor', $imagem, PDO::PARAM_LOB);
$stmt->fetch(PDO::FETCH_BOUND);

// Verifica e envia a imagem
if (!empty($imagem)) {
    header("Content-Type: image/jpeg");
    fpassthru($imagem); 
    exit;
} else {
    header("Content-Type: text/plain");
    echo "Imagem não encontrada.";
    exit;
}