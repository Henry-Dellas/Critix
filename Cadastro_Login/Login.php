<?php
session_start();
header('Content-Type: application/json');

if(isset($_SESSION["usuarios"])) {
    echo json_encode(['status'=>'ok']);
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = trim($_POST['usuarios'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    try {
        $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "amogus");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = :nome AND senha = :senha");
        $stmt->execute([':nome'=>$nome, ':senha'=>$senha]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario){
            $_SESSION["usuarios"] = $usuario["nome"];
            echo json_encode(['status'=>'ok']);
        } else {
            echo json_encode(['status'=>'erro','msg'=>'Usuário não encontrado! Cadastre-se primeiro.']);
        }
    } catch(Exception $e){
        echo json_encode(['status'=>'erro','msg'=>'Erro no servidor: '.$e->getMessage()]);
    }
}
?>


