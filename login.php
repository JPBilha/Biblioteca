<?php
require 'conexao.php';
$erro = "";

// Redireciona se já estiver logado
if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    $sql = "SELECT id, nome, tipo, senha FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        
        if ($senha == $usuario['senha']) { // Em projeto real, use password_verify()
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['tipo_usuario'] = $usuario['tipo'];

            header("Location: index.php");
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Nenhum usuário encontrado com este e-mail.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Biblioteca</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container login-form">
        <h1>Sistema de Biblioteca</h1>
        <h2>Login</h2>
        
        <?php if ($erro): ?>
            <p class="message error"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit">Entrar</button>
        </form>
        <p><strong>Admin:</strong> admin@email.com / <strong>Senha:</strong> 123</p>
        <p><strong>Aluno:</strong> aluno@email.com / <strong>Senha:</strong> 123</p>
    </div>
</body>
</html>