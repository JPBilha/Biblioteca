# Sistema de Gerenciamento de Biblioteca

![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)
![Status](https://img.shields.io/badge/status-conclu%C3%ADdo-green)

Um sistema web simples para gerenciamento de uma biblioteca, desenvolvido como projeto para a disciplina de Construção de Aplicações Web. O sistema permite o controle de livros e reservas, com dois níveis de acesso: Administrador e Aluno.

---

## ✨ Funcionalidades

O sistema possui as seguintes funcionalidades principais:

### 👤 Gerais
- **Autenticação de Usuários:** Sistema de login seguro para diferenciar os níveis de acesso.
- **Sessões de Usuário:** Mantém o usuário conectado enquanto navega pelo sistema.

### 👑 Painel do Administrador
- **CRUD de Livros:**
  - **C**riar: Adicionar novos livros ao catálogo.
  - **R**ecuperar: Visualizar a lista completa de livros existentes.
  - **D**eletar: Remover livros do sistema (validação impede exclusão se houver reservas ativas).
- **Relatório de Reservas:** Visualizar um relatório completo com todas as reservas feitas no sistema, incluindo as ativas, as já devolvidas e as atrasadas.

### 🎓 Painel do Aluno
- **Visualização de Livros:** Ver a lista de todos os livros com exemplares disponíveis para reserva.
- **Sistema de Reserva:** Realizar a reserva de um livro disponível. O sistema automaticamente abate a quantidade do estoque e define um prazo de devolução de 15 dias.
- **Minhas Reservas:** Consultar uma lista com todas as suas reservas (ativas e já devolvidas).
- **Sistema de Devolução:** Realizar a devolução de um livro, atualizando o status da reserva e repondo a quantidade no estoque.

---

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP 7.4+
- **Banco de Dados:** MySQL
- **Frontend:** HTML5 e CSS3
- **Ambiente de Servidor Local:** XAMPP (Apache + MySQL)

---

## 🚀 Como Rodar o Projeto

Para executar este projeto localmente, siga os passos abaixo.

### Pré-requisitos
- Ter o **XAMPP** instalado em sua máquina. (Você pode baixá-lo em [apachefriends.org](https://www.apachefriends.org/pt_br/index.html)).

### Passos de Instalação

1.  **Clone ou Baixe o Projeto**
    - Coloque a pasta completa do projeto (`biblioteca/`) dentro do diretório `htdocs` da sua instalação do XAMPP.
    - O caminho final deve ser: **`C:\xampp\htdocs\biblioteca`**.

2.  **Inicie o XAMPP**
    - Abra o Painel de Controle do XAMPP e inicie os módulos **Apache** e **MySQL**.

3.  **Crie e Importe o Banco de Dados**
    - Abra seu navegador e acesse o phpMyAdmin: **`http://localhost/phpmyadmin`**.
    - Clique na aba **"SQL"**.
    - Copie todo o conteúdo do arquivo `banco_de_dados/01_estrutura.sql` e execute. Isso criará o banco e as tabelas.
    - Em seguida, copie todo o conteúdo do arquivo `banco_de_dados/02_dados_iniciais.sql` e execute. Isso irá popular o banco com dados de teste.

4.  **Acesse a Aplicação**
    - Com tudo pronto, acesse o sistema pelo seu navegador no seguinte endereço:
    - **`http://localhost/biblioteca/`**

---

## 🔑 Credenciais de Acesso

Use os seguintes dados de teste para acessar os diferentes painéis do sistema:

### Administrador
- **Email:** `admin@email.com`
- **Senha:** `123`

### Aluno
- **Email:** `aluno@email.com`
- **Senha:** `123`

---

## 📂 Estrutura do Projeto