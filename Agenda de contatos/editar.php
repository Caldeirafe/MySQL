<?php
require "conexao.php";

if (isset($_GET['id'])) {
    $contato_id = intval($_GET['id']);
    
    // Buscar dados do contato
    $resultadoContato = mysqli_query($link, "SELECT nome FROM tb_contato WHERE id = $contato_id");
    $dadosContato = mysqli_fetch_assoc($resultadoContato);
    
    // Buscar telefone associado
    $resultadoTelefone = mysqli_query($link, "SELECT telefone FROM tb_telefone WHERE id_nome = $contato_id");
    $dadosTelefone = mysqli_fetch_assoc($resultadoTelefone);
    
    // Buscar email associado
    $resultadoEmail = mysqli_query($link, "SELECT email FROM tb_email WHERE id_nome = $contato_id");
    $dadosEmail = mysqli_fetch_assoc($resultadoEmail);
}

// Atualizar dados no banco de dados após submissão do formulário
if ($_POST) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    // Atualizar nome na tabela tb_contato
    mysqli_query($link, "UPDATE tb_contato SET nome = '$nome' WHERE id = $contato_id");

    // Atualizar telefone na tabela tb_telefone
    mysqli_query($link, "UPDATE tb_telefone SET telefone = '$telefone' WHERE id_nome = $contato_id");

    // Atualizar email na tabela tb_email
    mysqli_query($link, "UPDATE tb_email SET email = '$email' WHERE id_nome = $contato_id");

    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar</title>
</head>
<body>
<header>
        <h1>Agenda de Contatos</h1>
        <h3><a href="index.php">Voltar</a></h3>
    </header>
    <section>
        <h2><strong>Editar Contato</strong></h2>
        <form method="POST" action="" class='contato'>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Digite o nome do contato" value="<?php echo ($dadosContato['nome']) ?>" required>

            <label for="telefone">Telefone:(Separados por Virgula)</label>
            <input type="text" name="telefone" id="telefone" placeholder="Digite o telefone" value="<?php echo ($dadosTelefone['telefone']) ?>" required>

            <label for="email">Email:(Separados por Virgula)</label>
            <input type="text" name="email" id="email" placeholder="Digite o email" value="<?php echo ($dadosEmail['email']) ?>" required>

            <br>
            <button type="submit" class='btnc'><strong>Atualizar</strong></button>
        </form>
    </section>
</body>
</html>