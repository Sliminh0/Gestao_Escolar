<?php
$exigido = "Aluno";
include "../verifica.php";
include_once "../conexao.php";
$idAluno = (int)($_SESSION["id_aluno"] ?? 0);

$stmt = $sql->prepare("SELECT * FROM aluno WHERE id_aluno = ?");
$stmt->bind_param("i", $idAluno);
$stmt->execute();
$aluno = $stmt->get_result()->fetch_assoc();

// Matrícula mais recente do aluno
$matricula = consulta($sql,
    "SELECT m.*, t.nome_turma, t.serie, t.turno
     FROM matricula m
     JOIN turma t ON t.id_turma = m.id_turma
     WHERE m.id_aluno = ?
     ORDER BY m.ano_letivo DESC, m.id_matricula DESC
     LIMIT 1",
    "i", [$idAluno])->get_result()->fetch_assoc();

$bimestres = ["Primeiro" => "1º Bim.", "Segundo" => "2º Bim.", "Terceiro" => "3º Bim.", "Quarto" => "4º Bim."];

$materias = [];
$notas = [];
if ($matricula) {
    // Matérias da turma do aluno
    $materias = consulta($sql,
        "SELECT tm.id_turma_materia, mat.nome_materia
         FROM turma_materia tm
         JOIN materia mat ON mat.id_materia = tm.tm_id_materia
         WHERE tm.tm_id_turma = ?
         ORDER BY mat.nome_materia",
        "i", [(int)$matricula["id_turma"]])->get_result()->fetch_all(MYSQLI_ASSOC);

    // Médias já lançadas: $notas[id_turma_materia][bimestre]
    $linhas = consulta($sql,
        "SELECT nota_id_turma_materia, bimestre, media FROM notas WHERE nota_id_aluno = ?",
        "i", [$idAluno])->get_result()->fetch_all(MYSQLI_ASSOC);
    foreach ($linhas as $l) {
        $notas[$l["nota_id_turma_materia"]][$l["bimestre"]] = $l["media"];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletim - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_aluno.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Boletim</h2>
  </div>

<?php if (!$matricula): ?>
  <p class="subtitulo">Você ainda não possui matrícula.</p>
<?php else: ?>
  <p class="subtitulo"><?php echo h($matricula['nome_turma']); ?> · Ano letivo <?php echo (int)$matricula['ano_letivo']; ?></p>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr>
          <th>Matéria</th>
          <?php foreach ($bimestres as $texto): ?>
          <th class="num"><?php echo $texto; ?></th>
          <?php endforeach; ?>
          <th class="num">Média final</th><th>Situação</th>
        </tr>
      </thead>
      <tbody>
<?php if (count($materias) == 0): ?>
        <tr><td colspan="7">Sua turma ainda não tem matérias cadastradas.</td></tr>
<?php endif; ?>
<?php foreach ($materias as $mat): ?>
<?php
    $medias = [];
    foreach ($bimestres as $chave => $texto) {
        $medias[$chave] = $notas[$mat['id_turma_materia']][$chave] ?? null;
    }
    $completo = !in_array(null, $medias, true);
    $final = $completo ? array_sum($medias) / 4 : null;
?>
        <tr>
          <td><?php echo h($mat['nome_materia']); ?></td>
          <?php foreach ($medias as $m): ?>
          <?php echo celula_nota($m); ?>
          <?php endforeach; ?>
          <?php echo celula_nota($final); ?>
          <td>
            <?php if (!$completo): ?>
              <span class="badge badge-andamento">Em andamento</span>
            <?php elseif ($final >= MEDIA_MINIMA): ?>
              <span class="badge badge-ativa">Aprovado</span>
            <?php else: ?>
              <span class="badge badge-cancelada">Reprovado</span>
            <?php endif; ?>
          </td>
        </tr>
<?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <p class="subtitulo">Para imprimir o boletim, use Ctrl + P no navegador.</p>
<?php endif; ?>

</div>

</body>
</html>
