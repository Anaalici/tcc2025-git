<?php
if (!isset($_SESSION)) {
    session_start();
}

$servidor = "localhost";
$username = "root";
$usersenha = "";
$database = "receitademestre";

$conexao = new mysqli($servidor, $username, $usersenha, $database);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4"); 

?>