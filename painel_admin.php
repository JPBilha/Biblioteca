<?php
require 'conexao.php';

// Proteção da página
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: login.php");
    exit();
}

$nome_usuario = $_SESSION['nome_usuario'];
$mensagem = "";

// Lógica para adicionar livro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_livro'])) {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $autor = mysqli_real_escape_string($conexao, $_POST['autor']);
    $quantidade = (int)$_POST['quantidade'];
    $sql = "INSERT INTO livros (titulo, autor, quantidade) VALUES ('$titulo', '$autor', $quantidade)";
    if (mysqli_query($conexao, $sql)) {
        $mensagem = "<p class='message success'>Livro adicionado com sucesso!</p>";
    } else {
        $mensagem = "<p class='message error'>Erro ao adicionar livro.</p>";
    }
}

// Lógica para deletar livro
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $sql = "DELETE FROM livros WHERE id = $id";
    if (mysqli_query($conexao, $sql)) {
        header("Location: painel_admin.php?msg=deleted");
    } else {
        header("Location: painel_admin.php?msg=error");
    }
    exit();
}

if(isset($_GET['msg'])) {
    if($_GET['msg'] == 'deleted') $mensagem = "<p class='message success'>Livro deletado com sucesso!</p>";
    if($_GET['msg'] == 'error') $mensagem = "<p class='message error'>Erro: Não foi possível deletar o livro. Verifique se existem reservas ativas para ele.</p>";
}

// Buscar todos os livros
$livros_sql = "SELECT * FROM livros ORDER BY titulo";
$livros_resultado = mysqli_query($conexao, $livros_sql);

// Buscar todas as reservas
$reservas_sql = "
    SELECT r.id, l.titulo, u.nome as usuario_nome, r.data_reserva, r.data_devolucao, r.status
    FROM reservas r
    JOIN livros l ON r.id_livro = l.id
    JOIN usuarios u ON r.id_usuario = u.id
    ORDER BY r.status, r.data_reserva DESC";
$reservas_resultado = mysqli_query($conexao, $reservas_sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Painel do Administrador</h1>
        <p>Bem-vindo(a), <?php echo htmlspecialchars($nome_usuario); ?>! <a href="logout.php" class="logout" style="float: right; margin-top: -10px;">Sair</a></p>

        <?php echo $mensagem; ?>

        <hr>
        <h2>Gerenciar Livros</h2>
        <form action="painel_admin.php" method="post">
            <h3>Adicionar Novo Livro</h3>
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" required>
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" required>
            <label for="quantidade">Quantidade</label>
            <input type="number" id="quantidade" name="quantidade" required min="1">
            <button type="submit" name="add_livro">Adicionar Livro</button>
        </form>

        <h3>Lista de Livros Cadastrados</h3>
        <table>
            <tr><th>ID</th><th>Título</th><th>Autor</th><th>Qtd.</th><th>Ação</th></tr>
            <?php while ($livro = mysqli_fetch_assoc($livros_resultado)): ?>
            <tr>
                <td><?php echo $livro['id']; ?></td>
                <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                <td><?php echo $livro['quantidade']; ?></td>
                <td><a href="painel_admin.php?delete_id=<?php echo $livro['id']; ?>" onclick="return confirm('Tem certeza?');">Deletar</a></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <hr>
        <h2>Relatório Geral de Reservas</h2>
        <table>
            <tr><th>ID</th><th>Livro</th><th>Aluno</th><th>Data Reserva</th><th>Prazo Devolução</th><th>Status</th></tr>
            <?php while ($reserva = mysqli_fetch_assoc($reservas_resultado)): ?>
            <tr class="<?php if($reserva['status'] == 'reservado' && strtotime($reserva['data_devolucao']) < time()) echo 'error'; ?>">
                <td><?php echo $reserva['id']; ?></td>
                <td><?php echo htmlspecialchars($reserva['titulo']); ?></td>
                <td><?php echo htmlspecialchars($reserva['usuario_nome']); ?></td>
                <td><?php echo date("d/m/Y", strtotime($reserva['data_reserva'])); ?></td>
                <td><?php echo date("d/m/Y", strtotime($reserva['data_devolucao'])); ?></td>
                <td><?php echo htmlspecialchars($reserva['status']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>