<?php
session_start();
if (!isset($_SESSION["usuarios"])) {
    header("Location: ../Cadastro_Login/Login Teste.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "System@2025");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT MAX(id) AS max_id FROM filmes");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $novo_id = $row['max_id'] !== null ? $row['max_id'] + 1 : 1;

        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $idade = $_POST['idade'] ?? 0;
        $minutos = $_POST['minutos'] ?? 0;
        $diretor = $_POST['diretor'] ?? '';
        $descricao_diretor = $_POST['descricao_diretor'] ?? '';

        $imagemFilme = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $infoImagem = getimagesize($_FILES['imagem']['tmp_name']);
            if ($infoImagem === false || ($infoImagem[2] !== IMAGETYPE_JPEG)) {
                die("A capa do filme deve ser uma imagem JPG válida.");
            }
            $imagemFilme = file_get_contents($_FILES['imagem']['tmp_name']);
        } else {
            die("A capa do filme é obrigatória.");
        }

        $imagemDiretor = null;
        if (isset($_FILES['imagem_diretor']) && $_FILES['imagem_diretor']['error'] === UPLOAD_ERR_OK) {
            $infoImagemDir = getimagesize($_FILES['imagem_diretor']['tmp_name']);
            if ($infoImagemDir === false || ($infoImagemDir[2] !== IMAGETYPE_JPEG)) {
                die("A foto do diretor deve ser uma imagem JPG válida.");
            }
            $imagemDiretor = file_get_contents($_FILES['imagem_diretor']['tmp_name']);
        }

        $stmt = $pdo->prepare("
            INSERT INTO filmes 
            (id, nome, descricao, idade, minutos, diretor, descricao_diretor, imagem, imagem_diretor) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bindParam(1, $novo_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $nome);
        $stmt->bindParam(3, $descricao);
        $stmt->bindParam(4, $idade, PDO::PARAM_INT);
        $stmt->bindParam(5, $minutos, PDO::PARAM_INT);
        $stmt->bindParam(6, $diretor);
        $stmt->bindParam(7, $descricao_diretor);
        $stmt->bindParam(8, $imagemFilme, PDO::PARAM_LOB);
        $stmt->bindParam(9, $imagemDiretor, PDO::PARAM_LOB);

        $stmt->execute();

        echo "Filme cadastrado com sucesso! (ID = {$novo_id})";

    } catch (PDOException $e) {
        die("Erro ao salvar no banco: " . $e->getMessage());
    }
} else {
    die("Método inválido.");
}