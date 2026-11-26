<?php
// Nome da pasta onde ficam css/, fontes/ e php/ (ao lado deste index.php).
// Se a sua pasta tiver outro nome, é só trocar aqui.
$pasta = "Gestao-Escolar";
$p = rawurlencode($pasta);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestão Escolar</title>
    <link rel="stylesheet" href="<?php echo $p; ?>/css/style.css">

</head>
<body class="cop">

<div class="divformm">
    <h2 class="titulo">Login</h2>

    <?php if (isset($_GET['erro'])): ?>
        <p class="msg-login">
            <?= $_GET['erro'] === '2' ? 'Faça login para continuar.' : 'E-mail ou senha inválidos.' ?>
        </p>
    <?php elseif (isset($_GET['ok'])): ?>
        <p class="msg-login">Administrador criado! Faça login.</p>
    <?php endif; ?>

    <form action="<?php echo $p; ?>/php/login.php" method="post" class="login">

        <div class="org">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
        </div>

        <div class="org">
            
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
                
                <label > <a href="<?php echo $p; ?>/recuperarsenha.php" class="senha"> Esqueceu a senha? </a></label>

        </div>     


        <div class="org">
            <input id="cad" type="submit" value="Login" name="login">
        </div>

    </form>
      
</div>    
</body>
</html>