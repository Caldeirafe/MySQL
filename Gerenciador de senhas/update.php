<?php

require "conexao.php";

if(isset ($_GET['id'])){
    $id = intval($_GET['id']);
    $resultado = mysqli_query($link, "SELECT * FROM tb_info WHERE id = $id");
    $dados = mysqli_fetch_assoc($resultado);
}

if($_POST){
    $servico = $_POST['servico'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    mysqli_query($link, "UPDATE tb_info SET servico= '$servico', email= '$email', senha= '$senha' WHERE id=$id");
    header("location: index.php");
}




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

        <form method="POST"  action="" class="form">
            <div class="form-title"><span>Gerenciador</span></div>
            <div class="form-title"><span>De</span></div>
            <div class="title-2"><span>Bacon</span></div>
            <div class="input-container">
                <input name="servico" required class="input-mail" type="text" placeholder="Serviços" value="<?php echo ($dados['servico']);?>">
                <input name="email" required class="input-mail" type="email" placeholder="Email" value="<?php echo ($dados['email']);?>">
                <span> </span>
            </div>
    
            <section class="bg-stars">
                <span class="star"></span>
                <span class="star"></span>
                <span class="star"></span>
                <span class="star"></span>
            </section>
    
            <div class="input-container">
                <input required name="senha" class="input-pwd" type="password" placeholder="Senha" value="<?php echo ($dados['senha']);?>">
            </div>
            <button type="submit" class="submit">
                <span class="sign-text">Confirma</span>
            </button>

            <p class="signup-link">
                Não tem conta ?
                <a href="" class="up">Foda-se!</a>
            </p>
        </form>