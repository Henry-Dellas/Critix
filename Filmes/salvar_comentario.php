<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION["usuarios"])) {
    echo json_encode(['success'=>false,'msg'=>'Usuário não logado']);
    exit;
}

$usuario = $_SESSION["usuarios"];
$texto = $_POST['texto'] ?? '';
$nota = $_POST['nota'] ?? 1;
$filme_id = $_POST['filme_id'] ?? 0;

if(!$texto || !$filme_id){
    echo json_encode(['success'=>false,'msg'=>'Dados inválidos']);
    exit;
}

try {
    $pdo = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO comentarios (filme_id, usuario, texto, nota) VALUES (?, ?, ?, ?)");
    $stmt->execute([$filme_id, $usuario, $texto, $nota]);

    $stmt2 = $pdo->prepare("SELECT ROUND(AVG(nota),1) AS media FROM comentarios WHERE filme_id = ?");
    $stmt2->execute([$filme_id]);
    $media = $stmt2->fetchColumn();

    echo json_encode([
        'success'=>true,
        'usuario'=>$usuario,
        'texto'=>htmlspecialchars($texto),
        'nota'=>$nota,
        'data_hora'=>date("d/m/Y H:i"),
        'media'=>$media
    ]);
} catch (PDOException $e){
    echo json_encode(['success'=>false,'msg'=>$e->getMessage()]);
}
