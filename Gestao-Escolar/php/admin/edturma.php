<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID não informado.");
}

$query = $sql->prepare("SELECT * FROM turma WHERE id_turma = ?");
$query->bind_param("i", $id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Turma não encontrada.");
}

$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Turma - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Alterar Turma</h2>

  <form action="../alterarturma.php" method="post" class="formularios">

    <input type="hidden" name="id" value="<?php echo $row['id_turma']; ?>">

        <div class="org">
          <label for="nome_turma">Nome da Turma</label>
          <input type="text" id="nome_turma" name="nome_turma" required placeholder="Ex.: 1º Ano A" value="<?php echo h($row['nome_turma']); ?>">
        </div>
        <div class="org">
          <label for="serie">Série</label>
          <input type="text" id="serie" name="serie" required placeholder="Ex.: 1º Ano" value="<?php echo h($row['serie']); ?>">
        </div>
        <div class="org">
          <label for="turno">Turno</label>
          <select id="turno" name="turno">
            <option value="">Selecione...</option>
            <option value="Manhã" <?php if ($row['turno'] == "Manhã") echo "selected"; ?>>Manhã</option>
            <option value="Tarde" <?php if ($row['turno'] == "Tarde") echo "selected"; ?>>Tarde</option>
            <option value="Noite" <?php if ($row['turno'] == "Noite") echo "selected"; ?>>Noite</option>
          </select>
        </div>
        <div class="org">
          <label for="ano_letivo">Ano Letivo</label>
          <input type="number" id="ano_letivo" name="ano_letivo" required min="2000" max="2100" value="<?php echo h($row['ano_letivo']); ?>">
        </div>

    <input class="btn-form" type="reset" value="Limpar">
    <input class="btn-form" type="submit" value="Atualizar" name="atualizar">
  </form>

  <a class="voltar" href="listarturma.php">← Voltar para a lista</a>
</div>

</body>
</html>
