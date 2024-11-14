<?php
// Conexão com o banco de dados
require "conexao.php";

// Verificar se foi feita uma pesquisa
$search = isset($_GET['contato']) ? mysqli_real_escape_string($link, $_GET['contato']) : '';

// Definir a consulta SQL com base na busca
$query = "SELECT c.id, c.nome, 
                GROUP_CONCAT(DISTINCT t.telefone SEPARATOR '<br>') AS telefones, 
                GROUP_CONCAT(DISTINCT e.email SEPARATOR '<br>') AS emails
            FROM tb_contato c
            LEFT JOIN tb_telefone t ON c.id = t.id_nome
            LEFT JOIN tb_email e ON c.id = e.id_nome";

// Se houver pesquisa, adicionar o filtro de busca
if ($search) {
    $query .= " WHERE c.nome LIKE '%$search%' 
                OR t.telefone LIKE '%$search%' 
                OR e.email LIKE '%$search%'";
}

// Agrupar os resultados por id do contato, para evitar múltiplas linhas para o mesmo contato
$query .= " GROUP BY c.id";

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
    </header>

    <main>
        <section>
            <h2><strong>Buscar Contato</strong></h2>
            <form method="GET" action="">
                <div class="index">
                    <input type="text" name="contato" id="contato" placeholder="Buscar contato" 
                            value="<?php echo isset($_GET['contato']) ? $_GET['contato'] : ''; ?>">
                    <button class="buscar" type="submit"><strong>Buscar</strong></button>
                </div>
            </form>

            <h2><strong>Resultado da Pesquisa:</strong></h2>
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <p><strong><?php echo mysqli_num_rows($resultado); ?> resultados encontrados.</strong></p>
            <?php else: ?>
                <p><strong>Nenhum resultado encontrado.</strong></p>
            <?php endif; ?>

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
                        // Exibindo os resultados
                        while($dados = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>" . $dados['id'] . "</td>";
                            echo "<td>" . $dados['nome'] . "</td>";
                            // Exibe os telefones agrupados
                            echo "<td>" . ($dados['telefones'] ? $dados['telefones'] : 'Não informado') . "</td>";
                            // Exibe os e-mails agrupados
                            echo "<td>" . ($dados['emails'] ? $dados['emails'] : 'Não informado') . "</td>";
                            echo "<td>
                                    <button id='gerenciarBtn'><a href='editar.php?id=".$dados['id']."'>Editar</a></button>
                                    <button id='gerenciarBtn'><a href='deletar.php?acao=excluir&id=".$dados['id']."'>Excluir</a></button>
                                </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <?php
        // Fechar a conexão com o banco de dados
        mysqli_close($link);
    ?>
</body>
</html>
