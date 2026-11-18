<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<header>
  <div class="logo">Olá Adminstrador</div>

  <input type="checkbox" id="menu-toggle">

  <label for="menu-toggle" class="hamburguer">
    ☰
  </label>

  <nav>
    <a href="#">Início</a>
    <a href="#">Sobre</a>
    <a href="#">Projetos</a>
    <a href="#">Contato</a>
  </nav>
</header>
        
        <div class="divform">
        <h2 class="titulo">Cadastro de Aluno</h2>
        <form action="../php/salvarcli.php" method="post" class="formularios">
          
          <div class="org">
          <label for="nome">Nome Completo</label>
          <input type="text" id="nome" name="nome" required>
          </div>

          <div class="org">
          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">
          </div>
        
          <div class="org">
          <label for="telefone">Telefone</label>
          <input type="tel" id="telefone" name="telefone" placeholder="(00) 91234-5678" required pattern="\(\d{2}\) \d{5}-\d{4}">
          </div>

          <div class="org">
          <label for="dataNascimento">Data de Nascimento</label>
          <input type="date" id="diasnasc" name="dataNascimento">
          </div>

          <div class="org">
          <label for="responsavel">Responsavel</label>
          <input type="text" id="responsavel" name="responsavel">
          </div>
          
          <div class="org">
          <label for="email">Email</label>
          <input type="email" id="email" name="email"required>
          </div>
  
          <input id="cad" type="submit" value="Cadastrar">
          <input id="cad" type="reset" value="Limpar">


        </form>
      </div>