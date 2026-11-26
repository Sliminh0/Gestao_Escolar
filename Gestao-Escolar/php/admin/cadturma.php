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
    <title>Cadastro de Turma - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Cadastro de Turma</h2>

  <form action="../salvarturma.php" method="post" class="formularios">

        <div class="org">
          <label for="nome_turma">Nome da Turma</label>
          <input type="text" id="nome_turma" name="nome_turma" required placeholder="Ex.: 1º Ano A">
        </div>
        <div class="org">
          <label for="serie">Série</label>
          <input type="text" id="serie" name="serie" required placeholder="Ex.: 1º Ano">
        </div>
        <div class="org">
          <label for="turno">Turno</label>
          <select id="turno" name="turno">
            <option value="">Selecione...</option>
            <option value="Manhã">Manhã</option>
            <option value="Tarde">Tarde</option>
            <option value="Noite">Noite</option>
          </select>
        </div>
        <div class="org">
          <label for="ano_letivo">Ano Letivo</label>
          <input type="number" id="ano_letivo" name="ano_letivo" required min="2000" max="2100" value="<?php echo date('Y'); ?>">
        </div>

    <input class="btn-form" type="submit" value="Salvar">
    <input class="btn-form" type="reset" value="Limpar">
  </form>

  <a class="voltar" href="listarturma.php">← Voltar para a lista</a>
</div>

</body>
</html>
