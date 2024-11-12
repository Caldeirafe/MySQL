<?php
//conexao banco

require "conexao.php";

//inserir

if($_POST) {
    // Iniciar transação
    mysqli_begin_transaction($link);

    try {
        // Inserir na tabela tb_contato
        $nome = mysqli_real_escape_string($link, $_POST['nome']);
        $queryContato = "INSERT INTO tb_contato (nome) VALUES ('$nome')";
        mysqli_query($link, $queryContato);
        $contato_id = mysqli_insert_id($link);

        // Inserir na tabela tb_telefone
        $telefone = mysqli_real_escape_string($link, $_POST['telefone']);
        $queryTelefone = "INSERT INTO tb_telefone (id_nome, telefone) VALUES ($contato_id, '$telefone')";
        mysqli_query($link, $queryTelefone);

        // Inserir na tabela tb_email
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $queryEmail = "INSERT INTO tb_email (id_nome, email) VALUES ($contato_id, '$email')";
        mysqli_query($link, $queryEmail);

        // Confirmar transação
        mysqli_commit($link);
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=sucesso");
        exit();

    } catch (Exception $e) {
        // Reverter transação em caso de erro
        mysqli_rollback($link);
        echo "Erro ao inserir contato: " . $e->getMessage();
    }
}

$query = "SELECT c.id, c.nome, t.telefone, e.email
        FROM tb_contato c
        LEFT JOIN tb_telefone t ON c.id = t.id_nome
        LEFT JOIN tb_email e ON c.id = e.id_nome";
$resultado = mysqli_query($link, $query);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Adicionar Contato</title>
</head>
<body>
    <header>
        <h1>Agenda de Contatos</h1>
        <h3><a href="index.php">Voltar</a></h3>
    </header>
    <section>
        <h2><strong>Adicionar Novo Contato</strong></h2>
        <form method="POST" action="index.php" class='contato'>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Digite o nome do contato" required>

            <label for="telefone">Telefone:(Separados por Virgula)</label>
            <input type="text" name="telefone" id="telefone" placeholder="Digite o telefone" required>

            <label for="email">Email:(Separados por Virgula)</label>
            <input type="text" name="email" id="email" placeholder="Digite o email" required>
            
            <br>
            <button type="submit" class='btnc'><strong>Adicionar</strong></button>
        </form>
    </section>
</body>
</html>
