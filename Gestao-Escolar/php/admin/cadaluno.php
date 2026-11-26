<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Cadastro de Aluno</h2>

  <form action="../salvaraluno.php" method="post" class="formularios">

        <div class="org">
          <label for="nome">Nome Completo</label>
          <input type="text" id="nome" name="nome" required>
        </div>
        <div class="org">
          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">
        </div>
        <div class="org">
          <label for="telefone">Telefone</label>
          <input type="tel" id="telefone" name="telefone" required placeholder="(00) 91234-5678" pattern="\(\d{2}\) \d{4,5}-\d{4}">
        </div>
        <div class="org">
          <label for="diasnasc">Data de Nascimento</label>
          <input type="date" id="diasnasc" name="dataNascimento">
        </div>
        <div class="org">
          <label for="responsavel">Responsável</label>
          <input type="text" id="responsavel" name="responsavel" required>
        </div>
        <div class="org">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>

    <input class="btn-form" type="submit" value="Salvar">
    <input class="btn-form" type="reset" value="Limpar">
  </form>

  <a class="voltar" href="listaraluno.php">← Voltar para a lista</a>
</div>

</body>
</html>
