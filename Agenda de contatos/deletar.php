<?php
// Conexão com o banco de dados
require "conexao.php";

// Verificar se a ação é excluir e se o ID do contato foi passado
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $contato_id = intval($_GET['id']);

    // Iniciar a transação
    mysqli_begin_transaction($link);

    try {
        // Deletar emails associados ao contato
        $queryEmail = "DELETE FROM tb_email WHERE id_nome = $contato_id";
        mysqli_query($link, $queryEmail);

        // Deletar telefones associados ao contato
        $queryTelefone = "DELETE FROM tb_telefone WHERE id_nome = $contato_id";
        mysqli_query($link, $queryTelefone);

        // Deletar o contato
        $queryContato = "DELETE FROM tb_contato WHERE id = $contato_id";
        mysqli_query($link, $queryContato);

        // Confirmar a transação
        mysqli_commit($link);
        header("Location: deletar.php?msg=excluido");
        exit();

    } catch (Exception $e) {
        // Desfazer a transação em caso de erro
        mysqli_rollback($link);
        echo "Erro ao excluir contato: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Deletar</title>
</head>
<body>
    <header>
        <h1>Agenda de Contatos</h1>
        <h3><a href="contato.php">Adicionar contato</a></h3>
    </header>
    <div class="gorila">
    <img  src="gorila.jfif" alt="">
    <h2 class="h2"> Contato Deletado com <a class="a" href="index.php">Banana!</a></h2>
    </div>
</body>
</html>