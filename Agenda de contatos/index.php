<?php

require "conexao.php";

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
    <title>Agenda</title>
</head>
<body>
    <header>
        <h1>Agenda de Contatos</h1>
        <h3><a href="contato.php">Adicionar contato</a></h3>
        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == 'sucesso') {

        }
        ?>
    </header>
    <main>
        <section>
        <h2><strong>Buscar Contato</strong></h2>
        <div class='index'>
                <input type="text" name="contato" id="contato" placeholder='Buscar contato'>
                <button class='buscar' type="button"><strong>Buscar</strong></button>
        </div>
        <h2><strong>Resutado da Pesquisa:</strong></h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Gerenciar</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while($dados = mysqli_fetch_assoc($resultado)){
                    echo"<tr>";
                        echo"<td>".$dados['id']."</td>";
                        echo"<td>".$dados['nome']."</td>";
                        echo"<td>".$dados['telefone']."</td>";
                        echo"<td>".$dados['email']."</td>";
                        echo"<td>
                                <button id='gerenciarBtn'><a href='editar.php?id=".$dados['id']."'>Editar</a></button>
                                <button id='gerenciarBtn'><a href='deletar.php?acao=excluir&id=".$dados['id']."'>Excluir</a></button>
                            </td>";
                    echo"</tr>";
                }
                ?>
            </tbody>
        </table>
        </section>
    </main>
</body>
</html>