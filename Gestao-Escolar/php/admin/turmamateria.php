<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$turmas = $sql->query("SELECT id_turma, CONCAT(nome_turma, ' - ', COALESCE(turno, ''), ' (', ano_letivo, ')') AS rotulo
                       FROM turma ORDER BY ano_letivo DESC, nome_turma")->fetch_all(MYSQLI_ASSOC);
$materias = $sql->query("SELECT id_materia, nome_materia FROM materia ORDER BY nome_materia")->fetch_all(MYSQLI_ASSOC);
$professores = $sql->query("SELECT id_professor, nome FROM professor ORDER BY nome")->fetch_all(MYSQLI_ASSOC);

$busca = trim($_GET["busca"] ?? "");
$like = "%" . $busca . "%";

$stmt = $sql->prepare("SELECT tm.id_turma_materia, t.nome_turma, t.ano_letivo, mat.nome_materia, p.nome AS professor
                       FROM turma_materia tm
                       JOIN turma t ON t.id_turma = tm.tm_id_turma
                       JOIN materia mat ON mat.id_materia = tm.tm_id_materia
                       JOIN professor p ON p.id_professor = tm.tm_id_professor
                       WHERE t.nome_turma LIKE ? OR mat.nome_materia LIKE ? OR p.nome LIKE ?
                       ORDER BY t.ano_letivo DESC, t.nome_turma, mat.nome_materia");
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$query = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disciplinas por Turma - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform compacta">
  <h2 class="titulo">Disciplinas por Turma</h2>

  <form action="../salvarturmamateria.php" method="post" class="formularios">

        <div class="org">
          <label for="tm_id_turma">Turma</label>
          <select id="tm_id_turma" name="tm_id_turma" required>
            <option value="">Selecione...</option>
            <?php foreach ($turmas as $o): ?>
            <option value="<?php echo $o['id_turma']; ?>"><?php echo h($o['rotulo']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="tm_id_materia">Matéria</label>
          <select id="tm_id_materia" name="tm_id_materia" required>
            <option value="">Selecione...</option>
            <?php foreach ($materias as $o): ?>
            <option value="<?php echo $o['id_materia']; ?>"><?php echo h($o['nome_materia']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="tm_id_professor">Professor</label>
          <select id="tm_id_professor" name="tm_id_professor" required>
            <option value="">Selecione...</option>
            <?php foreach ($professores as $o): ?>
            <option value="<?php echo $o['id_professor']; ?>"><?php echo h($o['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

    <input class="btn-form" type="submit" value="Vincular">
  </form>
</div>

<div class="container">

  <h3 class="secao-titulo">Vínculos cadastrados</h3>

  <form method="get" class="toolbar">
    <input type="search" name="busca" class="busca" placeholder="Buscar por turma, matéria ou professor..." value="<?php echo h($busca); ?>">
    <button class="btn" type="submit">Buscar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Turma</th><th>Matéria</th><th>Professor</th><th>Ações</th></tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="5">Nenhum vínculo encontrado.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id_turma_materia']; ?></td>
          <td><?php echo h($row['nome_turma']); ?> (<?php echo (int)$row['ano_letivo']; ?>)</td>
          <td><?php echo h($row['nome_materia']); ?></td>
          <td><?php echo h($row['professor']); ?></td>
          <td class="acoes">
            <a class="btn-excluir" href="../excturmamateria.php?id=<?php echo (int)$row['id_turma_materia']; ?>">excluir</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
