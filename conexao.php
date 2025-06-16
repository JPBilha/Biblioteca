<?php
$servidor = "localhost";
$usuario_db = "root";
$senha_db = ""; // Senha do seu banco de dados XAMPP (geralmente vazia)
$banco = "biblioteca";

$conexao = mysqli_connect($servidor, $usuario_db, $senha_db, $banco);

// Define o charset para utf8 para evitar problemas com acentuação
mysqli_set_charset($conexao, "utf8");

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Inicia a sessão em todas as páginas que incluírem este arquivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>