<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$bimestres = ["Primeiro" => "1º Bimestre", "Segundo" => "2º Bimestre", "Terceiro" => "3º Bimestre", "Quarto" => "4º Bimestre"];

$turmas = $sql->query("SELECT id_turma, CONCAT(nome_turma, ' - ', COALESCE(turno, ''), ' (', ano_letivo, ')') AS rotulo
                       FROM turma ORDER BY ano_letivo DESC, nome_turma")->fetch_all(MYSQLI_ASSOC);
$materias = $sql->query("SELECT id_materia, nome_materia FROM materia ORDER BY nome_materia")->fetch_all(MYSQLI_ASSOC);

$fTurma = (int)($_GET["turma"] ?? 0);
$fMateria = (int)($_GET["materia"] ?? 0);
$fBimestre = $_GET["bimestre"] ?? "";

// Monta o WHERE só com os filtros que foram escolhidos
$where = [];
$tipos = "";
$params = [];
if ($fTurma > 0) { $where[] = "tm.tm_id_turma = ?"; $tipos .= "i"; $params[] = $fTurma; }
if ($fMateria > 0) { $where[] = "tm.tm_id_materia = ?"; $tipos .= "i"; $params[] = $fMateria; }
if (isset($bimestres[$fBimestre])) { $where[] = "n.bimestre = ?"; $tipos .= "s"; $params[] = $fBimestre; }

$consulta = "SELECT a.nome AS aluno, t.nome_turma, mat.nome_materia, n.bimestre, n.nota1, n.nota2, n.nota3, n.media
             FROM notas n
             JOIN aluno a ON a.id_aluno = n.nota_id_aluno
             JOIN turma_materia tm ON tm.id_turma_materia = n.nota_id_turma_materia
             JOIN turma t ON t.id_turma = tm.tm_id_turma
             JOIN materia mat ON mat.id_materia = tm.tm_id_materia"
          . ($where ? " WHERE " . implode(" AND ", $where) : "")
          . " ORDER BY t.nome_turma, mat.nome_materia, a.nome, n.bimestre LIMIT 500";

$query = consulta($sql, $consulta, $tipos, $params)->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Notas - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Consulta de Notas</h2>
  </div>

  <form method="get" class="toolbar">
    <select name="turma">
      <option value="">Todas as turmas</option>
      <?php foreach ($turmas as $o): ?>
      <option value="<?php echo $o['id_turma']; ?>" <?php if ($fTurma == $o['id_turma']) echo "selected"; ?>><?php echo h($o['rotulo']); ?></option>
      <?php endforeach; ?>
    </select>
    <select name="materia">
      <option value="">Todas as matérias</option>
      <?php foreach ($materias as $o): ?>
      <option value="<?php echo $o['id_materia']; ?>" <?php if ($fMateria == $o['id_materia']) echo "selected"; ?>><?php echo h($o['nome_materia']); ?></option>
      <?php endforeach; ?>
    </select>
    <select name="bimestre">
      <option value="">Todos os bimestres</option>
      <?php foreach ($bimestres as $valor => $texto): ?>
      <option value="<?php echo $valor; ?>" <?php if ($fBimestre == $valor) echo "selected"; ?>><?php echo $texto; ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn" type="submit">Filtrar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr>
          <th>Aluno</th><th>Turma</th><th>Matéria</th><th>Bimestre</th>
          <th class="num">Nota 1</th><th class="num">Nota 2</th><th class="num">Nota 3</th><th class="num">Média</th>
        </tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="8">Nenhuma nota encontrada.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo h($row['aluno']); ?></td>
          <td><?php echo h($row['nome_turma']); ?></td>
          <td><?php echo h($row['nome_materia']); ?></td>
          <td><?php echo h($bimestres[$row['bimestre']] ?? $row['bimestre']); ?></td>
          <?php echo celula_nota($row['nota1']); ?>
          <?php echo celula_nota($row['nota2']); ?>
          <?php echo celula_nota($row['nota3']); ?>
          <?php echo celula_nota($row['media']); ?>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
