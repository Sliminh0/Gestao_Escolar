<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID não informado.");
}

$query = $sql->prepare("SELECT * FROM matricula WHERE id_matricula = ?");
$query->bind_param("i", $id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Matrícula não encontrada.");
}

$row = $result->fetch_assoc();
$alunos = $sql->query("SELECT id_aluno, nome FROM aluno ORDER BY nome")->fetch_all(MYSQLI_ASSOC);
$turmas = $sql->query("SELECT id_turma, CONCAT(nome_turma, ' - ', COALESCE(turno, ''), ' (', ano_letivo, ')') AS rotulo
                       FROM turma ORDER BY ano_letivo DESC, nome_turma")->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Matrícula - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Alterar Matrícula</h2>

  <form action="../alterarmatricula.php" method="post" class="formularios">

    <input type="hidden" name="id" value="<?php echo $row['id_matricula']; ?>">

        <div class="org">
          <label for="id_aluno">Aluno</label>
          <select id="id_aluno" name="id_aluno" required>
            <option value="">Selecione...</option>
            <?php foreach ($alunos as $o): ?>
            <option value="<?php echo $o['id_aluno']; ?>" <?php if ($row['id_aluno'] == $o['id_aluno']) echo "selected"; ?>><?php echo h($o['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="id_turma">Turma</label>
          <select id="id_turma" name="id_turma" required>
            <option value="">Selecione...</option>
            <?php foreach ($turmas as $o): ?>
            <option value="<?php echo $o['id_turma']; ?>" <?php if ($row['id_turma'] == $o['id_turma']) echo "selected"; ?>><?php echo h($o['rotulo']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="ano_letivo">Ano Letivo</label>
          <input type="number" id="ano_letivo" name="ano_letivo" required min="2000" max="2100" value="<?php echo h($row['ano_letivo']); ?>">
        </div>
        <div class="org">
          <label for="data_matricula">Data da Matrícula</label>
          <input type="date" id="data_matricula" name="data_matricula" value="<?php echo h($row['data_matricula']); ?>">
        </div>
        <div class="org">
          <label for="estado">Estado</label>
          <select id="estado" name="estado" required>
            <option value="">Selecione...</option>
            <option value="Ativa" <?php if ($row['estado'] == "Ativa") echo "selected"; ?>>Ativa</option>
            <option value="Concluida" <?php if ($row['estado'] == "Concluida") echo "selected"; ?>>Concluída</option>
            <option value="Cancelada" <?php if ($row['estado'] == "Cancelada") echo "selected"; ?>>Cancelada</option>
            <option value="Transferida" <?php if ($row['estado'] == "Transferida") echo "selected"; ?>>Transferida</option>
          </select>
        </div>

    <input class="btn-form" type="reset" value="Limpar">
    <input class="btn-form" type="submit" value="Atualizar" name="atualizar">
  </form>

  <a class="voltar" href="listarmatricula.php">← Voltar para a lista</a>
</div>

</body>
</html>
