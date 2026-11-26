<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$alunos = $sql->query("SELECT id_aluno, nome FROM aluno ORDER BY nome")->fetch_all(MYSQLI_ASSOC);
$turmas = $sql->query("SELECT id_turma, CONCAT(nome_turma, ' - ', COALESCE(turno, ''), ' (', ano_letivo, ')') AS rotulo
                       FROM turma ORDER BY ano_letivo DESC, nome_turma")->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Matrícula - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Cadastro de Matrícula</h2>

  <form action="../salvarmatricula.php" method="post" class="formularios">

        <div class="org">
          <label for="id_aluno">Aluno</label>
          <select id="id_aluno" name="id_aluno" required>
            <option value="">Selecione...</option>
            <?php foreach ($alunos as $o): ?>
            <option value="<?php echo $o['id_aluno']; ?>"><?php echo h($o['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="id_turma">Turma</label>
          <select id="id_turma" name="id_turma" required>
            <option value="">Selecione...</option>
            <?php foreach ($turmas as $o): ?>
            <option value="<?php echo $o['id_turma']; ?>"><?php echo h($o['rotulo']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="ano_letivo">Ano Letivo</label>
          <input type="number" id="ano_letivo" name="ano_letivo" required min="2000" max="2100" value="<?php echo date('Y'); ?>">
        </div>
        <div class="org">
          <label for="data_matricula">Data da Matrícula</label>
          <input type="date" id="data_matricula" name="data_matricula" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="org">
          <label for="estado">Estado</label>
          <select id="estado" name="estado" required>
            <option value="">Selecione...</option>
            <option value="Ativa">Ativa</option>
            <option value="Concluida">Concluída</option>
            <option value="Cancelada">Cancelada</option>
            <option value="Transferida">Transferida</option>
          </select>
        </div>

    <input class="btn-form" type="submit" value="Salvar">
    <input class="btn-form" type="reset" value="Limpar">
  </form>

  <a class="voltar" href="listarmatricula.php">← Voltar para a lista</a>
</div>

</body>
</html>
