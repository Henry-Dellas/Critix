<?php
session_start();
if (!isset($_SESSION["usuarios"])) {
    header("Location: Login Teste.php");
    exit;
}

$usuario = $_SESSION["usuarios"];
$texto = $_POST['texto'] ?? '';
$nota = $_POST['nota'] ?? 1;
$livro_id = $_POST['livro_id'] ?? 0;
$spoiler = isset($_POST['spoiler']) && $_POST['spoiler'] == "on" ? 1 : 0;

if ($texto && $livro_id) {
    try {
        $pdo = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO comentariosLivro (livro_id, usuario, texto, nota, spoiler) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$livro_id, $usuario, $texto, $nota, $spoiler]);
        header("Location: livro.php?id=$livro_id");

        exit;
    } catch (PDOException $e) {
        die("Erro ao salvar comentário: " . $e->getMessage());
    }
} else {
    die("Comentário inválido.");
}