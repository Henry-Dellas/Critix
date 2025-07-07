<?php
//Obtendo os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//string de conexão

try
{
   $conn = new PDO("pgsql:host=localhost;dbname=bancox", "postgres", "amogus");

   //string SQL - Inserir os dados na tabela de usuários
   $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

   $result = $conn->query($sql);

   if($result)
   {
      echo "Usuário cadastrado com sucesso!";
   }else
   {
      echo "Erro ao cadastrar o usuário: ".$conn->error;
   }
}
catch(Exception $e)
{
    echo 'Possível erro de excessão: ', $e->getMessage(), "\n";
}

//Fechar a conexão com o banco de dados
$conn = null;
?>
