<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="divform">
        <h2 class="titulo">Login</h1>

        <form action="../php/salvar.php" method="post" class="login">


        <label for="nome">Usuário</label>
        <input type="text" id="nome" name="nome" required>

        <label for="peso">Senha</label>
        <input type="password" id="senha" name="senha" required>
        
        <div class="but">
                <input id="cad"type="submit" value="Login" name="login">
        </div>
    </form>
      </div>
    
</body>
</html>