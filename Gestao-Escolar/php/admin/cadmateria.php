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
    <title>Cadastro de Matéria - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Cadastro de Matéria</h2>

  <form action="../salvarmateria.php" method="post" class="formularios">

        <div class="org">
          <label for="nome_materia">Nome da Matéria</label>
          <input type="text" id="nome_materia" name="nome_materia" required placeholder="Ex.: Matemática">
        </div>
        <div class="org">
          <label for="carga_horaria">Carga Horária (horas)</label>
          <input type="number" id="carga_horaria" name="carga_horaria" min="1" placeholder="Ex.: 80">
        </div>

    <input class="btn-form" type="submit" value="Salvar">
    <input class="btn-form" type="reset" value="Limpar">
  </form>

  <a class="voltar" href="listarmateria.php">← Voltar para a lista</a>
</div>

</body>
</html>
