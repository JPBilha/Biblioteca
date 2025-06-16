<?php
require 'conexao.php';

// Se o usuário já estiver logado, redireciona para o painel correto
if (isset($_SESSION['id_usuario'])) {
    if ($_SESSION['tipo_usuario'] == 'admin') {
        header("Location: painel_admin.php");
    } else {
        header("Location: painel_aluno.php");
    }
    exit();
}

// Se não, redireciona para a página de login
header("Location: login.php");
exit();
?>