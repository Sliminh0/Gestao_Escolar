<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID não informado.");
}

$query = $sql->prepare("SELECT * FROM materia WHERE id_materia = ?");
$query->bind_param("i", $id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Matéria não encontrada.");
}

$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Matéria - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Alterar Matéria</h2>

  <form action="../alterarmateria.php" method="post" class="formularios">

    <input type="hidden" name="id" value="<?php echo $row['id_materia']; ?>">

        <div class="org">
          <label for="nome_materia">Nome da Matéria</label>
          <input type="text" id="nome_materia" name="nome_materia" required placeholder="Ex.: Matemática" value="<?php echo h($row['nome_materia']); ?>">
        </div>
        <div class="org">
          <label for="carga_horaria">Carga Horária (horas)</label>
          <input type="number" id="carga_horaria" name="carga_horaria" min="1" placeholder="Ex.: 80" value="<?php echo h($row['carga_horaria']); ?>">
        </div>

    <input class="btn-form" type="reset" value="Limpar">
    <input class="btn-form" type="submit" value="Atualizar" name="atualizar">
  </form>

  <a class="voltar" href="listarmateria.php">← Voltar para a lista</a>
</div>

</body>
</html>
