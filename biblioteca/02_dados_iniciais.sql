-- Define o banco de dados 'biblioteca' como o padrão.
USE biblioteca;

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`) VALUES
(1, 'Administrador do Sistema', 'admin@email.com', '123', 'admin'),
(2, 'Aluno de Teste', 'aluno@email.com', '123', 'aluno');

INSERT INTO `livros` (`id`, `titulo`, `autor`, `quantidade`) VALUES
(1, 'O Senhor dos Anéis: A Sociedade do Anel', 'J.R.R. Tolkien', 3),
(2, 'Harry Potter e a Pedra Filosofal', 'J.K. Rowling', 5),
(3, '1984', 'George Orwell', 2),
(4, 'Dom Quixote', 'Miguel de Cervantes', 1);