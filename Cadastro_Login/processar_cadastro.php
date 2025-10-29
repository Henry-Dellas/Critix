<?php
session_start();
$msg = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if(!$nome || !$email || !$senha){
        $msg = urlencode("Preencha todos os campos!");
        header("Location: Cadastro.html?msg=$msg");
        exit;
    }

    try {
        $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "amogus");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = :nome OR email = :email");
        $stmt->execute([':nome'=>$nome, ':email'=>$email]);
        $existe = $stmt->fetch(PDO::FETCH_ASSOC);

        if($existe){
            $msg = urlencode("Usuário já cadastrado!");
            header("Location: Cadastro.html?msg=$msg");
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
        $stmt->execute([':nome'=>$nome, ':email'=>$email, ':senha'=>$senha]);

        $msg = urlencode("Cadastro realizado com sucesso!");
        header("Location: Login Teste.php?msg=$msg");
        exit;

    } catch(Exception $e){
        $msg = urlencode("Erro no servidor: " . $e->getMessage());
        header("Location: Cadastro.html?msg=$msg");
        exit;
    }
}
?>

