<?php
session_start();
if (!isset($_SESSION["usuarios"])) {
    header("Location: Login Teste.php");
    exit;
}

$usuario = $_SESSION["usuarios"];
$texto = $_POST['texto'] ?? '';
$nota = $_POST['nota'] ?? 1;
$filme_id = $_POST['filme_id'] ?? 0;

if ($texto && $filme_id) {
    try {
        $pdo = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO comentarios (filme_id, usuario, texto, nota) VALUES (?, ?, ?, ?)");
        $stmt->execute([$filme_id, $usuario, $texto, $nota]);

        header("Location: filme.php?id=$filme_id");
        exit;
    } catch (PDOException $e) {
        die("Erro ao salvar comentário: " . $e->getMessage());
    }
} else {
    die("Comentário inválido.");
}