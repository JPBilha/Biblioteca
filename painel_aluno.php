<?php
require 'conexao.php';

// Proteção da página
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] != 'aluno') {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome_usuario'];
$mensagem = "";

// Lógica para reservar livro
if (isset($_GET['reservar_id'])) {
    $id_livro = (int)$_GET['reservar_id'];
    $livro_check_sql = "SELECT quantidade FROM livros WHERE id = $id_livro";
    $livro_check_res = mysqli_query($conexao, $livro_check_sql);
    $livro_data = mysqli_fetch_assoc($livro_check_res);

    if ($livro_data && $livro_data['quantidade'] > 0) {
        mysqli_query($conexao, "UPDATE livros SET quantidade = quantidade - 1 WHERE id = $id_livro");
        $data_reserva = date("Y-m-d");
        $data_devolucao = date('Y-m-d', strtotime('+15 days'));
        $insert_sql = "INSERT INTO reservas (id_livro, id_usuario, data_reserva, data_devolucao, status) VALUES ($id_livro, $id_usuario, '$data_reserva', '$data_devolucao', 'reservado')";
        mysqli_query($conexao, $insert_sql);
        $mensagem = "<p class='message success'>Livro reservado com sucesso! Prazo para devolução: " . date("d/m/Y", strtotime($data_devolucao)) . "</p>";
    } else {
        $mensagem = "<p class='message error'>Livro indisponível ou não encontrado!</p>";
    }
}

// Lógica para devolver livro
if (isset($_GET['devolver_id'])) {
    $id_reserva = (int)$_GET['devolver_id'];
    $reserva_sql = "SELECT id_livro FROM reservas WHERE id = $id_reserva AND id_usuario = $id_usuario AND status = 'reservado'";
    $reserva_res = mysqli_query($conexao, $reserva_sql);
    if(mysqli_num_rows($reserva_res) > 0) {
        $reserva_data = mysqli_fetch_assoc($reserva_res);
        $id_livro = $reserva_data['id_livro'];
        mysqli_query($conexao, "UPDATE livros SET quantidade = quantidade + 1 WHERE id = $id_livro");
        mysqli_query($conexao, "UPDATE reservas SET status = 'devolvido' WHERE id = $id_reserva");
        $mensagem = "<p class='message success'>Livro devolvido com sucesso!</p>";
    }
}

// Buscar livros disponíveis
$livros_sql = "SELECT * FROM livros WHERE quantidade > 0 ORDER BY titulo";
$livros_resultado = mysqli_query($conexao, $livros_sql);

// Buscar minhas reservas
$reservas_sql = "
    SELECT r.id, l.titulo, r.data_reserva, r.data_devolucao, r.status
    FROM reservas r JOIN livros l ON r.id_livro = l.id
    WHERE r.id_usuario = $id_usuario ORDER BY r.status, r.data_devolucao ASC";
$reservas_resultado = mysqli_query($conexao, $reservas_sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Aluno</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Painel do Aluno</h1>
        <p>Bem-vindo(a), <?php echo htmlspecialchars($nome_usuario); ?>! <a href="logout.php" class="logout" style="float: right; margin-top: -10px;">Sair</a></p>

        <?php echo $mensagem; ?>

        <hr>
        <h2>Meus Livros Reservados</h2>
        <table>
            <tr><th>Título</th><th>Data Reserva</th><th>Prazo Devolução</th><th>Status</th><th>Ação</th></tr>
            <?php while ($reserva = mysqli_fetch_assoc($reservas_resultado)): ?>
            <tr>
                <td><?php echo htmlspecialchars($reserva['titulo']); ?></td>
                <td><?php echo date("d/m/Y", strtotime($reserva['data_reserva'])); ?></td>
                <td><?php echo date("d/m/Y", strtotime($reserva['data_devolucao'])); ?></td>
                <td><?php echo htmlspecialchars($reserva['status']); ?></td>
                <td>
                    <?php if ($reserva['status'] == 'reservado'): ?>
                        <a href="painel_aluno.php?devolver_id=<?php echo $reserva['id']; ?>">Devolver</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <hr>
        <h2>Livros Disponíveis para Reserva</h2>
        <table>
            <tr><th>Título</th><th>Autor</th><th>Ação</th></tr>
            <?php while ($livro = mysqli_fetch_assoc($livros_resultado)): ?>
            <tr>
                <td><?php echo htmlspecialchars($livro['titulo']); ?></td>
                <td><?php echo htmlspecialchars($livro['autor']); ?></td>
                <td><a href="painel_aluno.php?reservar_id=<?php echo $livro['id']; ?>">Reservar</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>