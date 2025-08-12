<?php
//inicializa a sessão
session_start();
//remove todas as variáveis de sessão
$_SESSION = array();
//destrua a sessão.
session_destroy();
//Redirecionar para a página de login
header("location: Login Teste.php");
exit;
?>