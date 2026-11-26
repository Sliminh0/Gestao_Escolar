<?php
$exigido = "Professor";
include "../verifica.php";
include_once "../conexao.php";
$idProfessor = (int)($_SESSION["id_professor"] ?? 0);

$query = consulta($sql,
    "SELECT tm.id_turma_materia, t.nome_turma, t.turno, t.ano_letivo, mat.nome_materia,
            (SELECT COUNT(*) FROM matricula m WHERE m.id_turma = t.id_turma AND m.estado = 'Ativa') AS alunos
     FROM turma_materia tm
     JOIN turma t ON t.id_turma = tm.tm_id_turma
     JOIN materia mat ON mat.id_materia = tm.tm_id_materia
     WHERE tm.tm_id_professor = ?
     ORDER BY t.ano_letivo DESC, t.nome_turma, mat.nome_materia",
    "i", [$idProfessor])->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas turmas - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_professor.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Minhas turmas</h2>
  </div>

<?php if ($query->num_rows == 0): ?>
  <p class="subtitulo">Você ainda não foi vinculado a nenhuma turma. Procure a secretaria.</p>
<?php endif; ?>

  <div class="cards">
<?php while ($row = $query->fetch_assoc()): ?>
    <div class="card">
      <h3><?php echo h($row['nome_materia']); ?></h3>
      <p><?php echo h($row['nome_turma']); ?> - <?php echo h($row['turno'] ?? ''); ?> (<?php echo (int)$row['ano_letivo']; ?>)</p>
      <p><?php echo (int)$row['alunos']; ?> alunos</p>
      <a class="btn" href="lancarnotas.php?tm=<?php echo (int)$row['id_turma_materia']; ?>">Lançar notas</a>
    </div>
<?php endwhile; ?>
  </div>

</div>

</body>
</html>
