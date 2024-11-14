<?php
// Conexão com o banco
require "conexao.php";

if ($_POST) {
    // Iniciar transação
    mysqli_begin_transaction($link);

    try {
        // Inserir na tabela tb_contato
        $nome = mysqli_real_escape_string($link, $_POST['nome']);
        $queryContato = "INSERT INTO tb_contato (nome) VALUES ('$nome')";
        
        if (!mysqli_query($link, $queryContato)) {
            throw new Exception("Erro ao inserir na tabela tb_contato: " . mysqli_error($link));
        }
        $contato_id = mysqli_insert_id($link);

        // Inserir na tabela tb_telefone para múltiplos telefones
        $telefones = explode(',', $_POST['telefone']);
        foreach ($telefones as $telefone) {
            $telefone = mysqli_real_escape_string($link, trim($telefone));
            $queryTelefone = "INSERT INTO tb_telefone (id_nome, telefone) VALUES ($contato_id, '$telefone')";
            if (!mysqli_query($link, $queryTelefone)) {
                throw new Exception("Erro ao inserir na tabela tb_telefone: " . mysqli_error($link));
            }
        }

        // Inserir na tabela tb_email para múltiplos e-mails
        $emails = explode(',', $_POST['email']);
        foreach ($emails as $email) {
            $email = mysqli_real_escape_string($link, trim($email));
            $queryEmail = "INSERT INTO tb_email (id_nome, email) VALUES ($contato_id, '$email')";
            if (!mysqli_query($link, $queryEmail)) {
                throw new Exception("Erro ao inserir na tabela tb_email: " . mysqli_error($link));
            }
        }

        // Confirmar transação
        mysqli_commit($link);
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?msg=sucesso");
        exit();

    } catch (Exception $e) {
        // Reverter transação em caso de erro
        mysqli_rollback($link);
        echo "Erro ao inserir contato: " . $e->getMessage();
    }
}
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
        <form method="POST" action="" class='contato'>
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
