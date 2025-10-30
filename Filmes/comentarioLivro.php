<?php
session_start();
if (!isset($_SESSION["usuarios"])) {
    echo json_encode(['success'=>false]);
    exit;
}

$usuario = $_SESSION["usuarios"];
$texto = $_POST['texto'] ?? '';
$nota = $_POST['nota'] ?? 1;
$livro_id = $_POST['livro_id'] ?? 0;
$spoiler = isset($_POST['spoiler']) && $_POST['spoiler'] == "1" ? 1 : 0;

if ($texto && $livro_id) {
    try {
        $pdo = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO comentariosLivro (livro_id, usuario, texto, nota, spoiler) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$livro_id, $usuario, $texto, $nota, $spoiler]);

        $mediaStmt = $pdo->prepare("SELECT ROUND(AVG(nota),1) AS media FROM comentariosLivro WHERE livro_id = ?");
        $mediaStmt->execute([$livro_id]);
        $media = $mediaStmt->fetchColumn();

        echo json_encode([
            'success'=>true,
            'usuario'=>$usuario,
            'texto'=>nl2br(htmlspecialchars($texto)),
            'nota'=>$nota,
            'data_hora'=>date("d/m/Y H:i"),
            'media'=>$media
        ]);
    } catch(PDOException $e) {
        echo json_encode(['success'=>false]);
    }
} else {
    echo json_encode(['success'=>false]);
}
?>
