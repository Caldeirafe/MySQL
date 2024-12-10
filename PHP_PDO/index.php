<?php
if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {
    $dsn = 'mysql:host=localhost;dbname=db_pdo';
    $user = 'root';
    $pass = '';

    try {
        $link = new PDO($dsn, $user, $pass);
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Definindo o modo de erro para exceções

        // Proteção contra SQL Injection: Usando parâmetros preparados
        $query = "SELECT * FROM TB_USUARIOS WHERE usuario = :usuario AND senha = :senha";

        $res = $link->prepare($query); // Prepara a consulta

        // Vincula os valores aos parâmetros
        $res->bindValue(':usuario', $_POST['usuario']);
        $res->bindValue(':senha', $_POST['senha']);

        // Executa a consulta
        $res->execute();

        // Verifica se encontrou o usuário
        $usuario = $res->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo "Usuário encontrado!";
        } else {
            echo "Usuário ou senha inválidos.";
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getCode() . ' Mensagem: ' . $e->getMessage(); // Tratamento de erro
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>
<section class="section is-medium">
<form action="index.php" method="post">
<div class="control">
<input name="usuario" class="input is-hovered" type="text" placeholder="Usuário" />
</div>
<div class="control">
<input name="senha" class="input is-hovered" type="password" placeholder="Senha" />
</div>
<button type="submit" class="button is-warning">Entrar</button>
</form>
</section>
    <?php 
    if(empty($usuario)){
        echo "<h2> Faça login para entrar </h2>";
    }else {
        echo "<h2>Logado</h2>";
    }
    ?>
</body>
</html>