<?php
    /*echo '<h1>';
    print_r($_POST);
    echo'</h1>';*/
    




    //conectar banco

    require "conexao.php";


// inserir 

    if($_POST){ 
    $servico = $_POST ['servico'];
    $email = $_POST ['email'];
    $senha = $_POST ['senha'];
    mysqli_query($link, "INSERT INTO tb_info (servico, email, senha) VALUES('$servico', '$email', '$senha')");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
    //read

    $resultado = mysqli_query($link, 'SELECT * FROM tb_info');
    //print_r($resultado);

    //delete
    if (isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
        $id = intval($_GET['id']); // Obtem o ID da URL e o converte para inteiro
        mysqli_query($link, "DELETE FROM tb_info WHERE id = $id"); // Executa a exclusão
        header('Location: index.php'); // Redireciona após a exclusão
        exit; // Garante que o script não continue após o redirecionamento
    }



    //criar banco

    mysqli_query($link, 'CREATE DATABASE IF NOT EXISTS GER_BACON');

    //criar tabela

    mysqli_query($link, 'CREATE TABLE IF NOT EXISTS TB_INFO(
        id int primary key auto_increment not null,
        servico varchar(40) not null,
        email varchar(30) not null,
        senha varchar(20) not null
    )
    ');
    ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Bacon</title>

</head>

<body>
<main>

        <form method="POST"  action="index.php" class="form">
            <div class="form-title"><span>Gerenciador</span></div>
            <div class="form-title"><span>De</span></div>
            <div class="title-2"><span>Bacon</span></div>
            <div class="input-container">
                <input name="servico" required class="input-mail" type="text" placeholder="Serviços">
                <input name="email" required class="input-mail" type="email" placeholder="Email">
                <span> </span>
            </div>
    
            <section class="bg-stars">
                <span class="star"></span>
                <span class="star"></span>
                <span class="star"></span>
                <span class="star"></span>
            </section>
    
            <div class="input-container">
                <input required name="senha" class="input-pwd" type="password" placeholder="Senha">
            </div>
            <button type="submit" class="submit">
                <span class="sign-text">Confirma</span>
            </button>

            <p class="signup-link">
                Não tem conta ?
                <a href="" class="up">Foda-se!</a>
            </p>
        </form>
    <section>
                <!-- Tabela de Credenciais -->
                <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Serviço/Site</th>
                    <th>Login/E-mail</th>
                    <th>Senha</th>
                    <th>Gerenciar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($dados = mysqli_fetch_assoc($resultado)){
                    echo"<tr>";
                        echo"<td>".$dados['id']."</td>";
                        echo"<td>".$dados['servico']."</td>";
                        echo"<td>".$dados['email']."</td>";
                        echo"<td>".$dados['senha']."</td>";
                        echo"<td>
                                <button id='gerenciarBtn'><a href='update.php?id=".$dados['id']."'>Editar</a></button>
                                <button id='gerenciarBtn'><a href='index.php?acao=excluir&id=".$dados['id']."'>Excluir</a></button>
                            </td>";
                    echo"</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    </section>
</main>

</body>

</html>