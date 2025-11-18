<?php
$servidor = "localhost";
$username = "root";
$usersenha = "";
$database = "receitadmestre"; 

$conexao = new mysqli($servidor, $username, $usersenha, $database);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>