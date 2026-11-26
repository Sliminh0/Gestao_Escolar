<?php
$exigido = "Professor";
include "../verifica.php";
include_once "../conexao.php";
$idProfessor = (int)($_SESSION["id_professor"] ?? 0);
$bimestres = ["Primeiro" => "1º Bimestre", "Segundo" => "2º Bimestre", "Terceiro" => "3º Bimestre", "Quarto" => "4º Bimestre"];

// Disciplinas deste professor (para o seletor)
$disciplinas = consulta($sql,
    "SELECT tm.id_turma_materia, tm.tm_id_turma, t.nome_turma, t.turno, t.ano_letivo, mat.nome_materia
     FROM turma_materia tm
     JOIN turma t ON t.id_turma = tm.tm_id_turma
     JOIN materia mat ON mat.id_materia = tm.tm_id_materia
     WHERE tm.tm_id_professor = ?
     ORDER BY t.ano_letivo DESC, t.nome_turma, mat.nome_materia",
    "i", [$idProfessor])->get_result()->fetch_all(MYSQLI_ASSOC);

$tm = (int)($_GET["tm"] ?? 0);
$bimestre = $_GET["bimestre"] ?? "Primeiro";
if (!isset($bimestres[$bimestre])) {
    $bimestre = "Primeiro";
}

// Só aceita uma disciplina que pertence ao professor logado
$disc = null;
foreach ($disciplinas as $d) {
    if ((int)$d["id_turma_materia"] === $tm) {
        $disc = $d;
    }
}
$erro = ($tm > 0 && $disc === null) ? "Disciplina não encontrada." : "";

$alunos = [];
if ($disc !== null) {
    $alunos = consulta($sql,
        "SELECT a.id_aluno, a.nome, n.nota1, n.nota2, n.nota3, n.media
         FROM matricula m
         JOIN aluno a ON a.id_aluno = m.id_aluno
         LEFT JOIN notas n ON n.nota_id_aluno = a.id_aluno
                          AND n.nota_id_turma_materia = ?
                          AND n.bimestre = ?
         WHERE m.id_turma = ? AND m.estado = 'Ativa'
         ORDER BY a.nome",
        "isi", [$tm, $bimestre, (int)$disc["tm_id_turma"]])->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançar notas - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_professor.php"; ?>

<?php if ($erro !== ""): ?>
<div class="alerta alerta-erro"><?php echo h($erro); ?></div>
<?php elseif (isset($_GET['ok'])): ?>
<div class="alerta alerta-ok">Notas salvas com sucesso!</div>
<?php endif; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Lançar notas</h2>
  </div>

  <form method="get" class="toolbar">
    <select name="tm" required>
      <option value="">Escolha a turma e a matéria...</option>
      <?php foreach ($disciplinas as $d): ?>
      <option value="<?php echo (int)$d['id_turma_materia']; ?>" <?php if ($tm == $d['id_turma_materia']) echo "selected"; ?>><?php echo h($d['nome_turma']); ?> (<?php echo (int)$d['ano_letivo']; ?>) - <?php echo h($d['nome_materia']); ?></option>
      <?php endforeach; ?>
    </select>
    <select name="bimestre">
      <?php foreach ($bimestres as $valor => $texto): ?>
      <option value="<?php echo $valor; ?>" <?php if ($bimestre == $valor) echo "selected"; ?>><?php echo $texto; ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn" type="submit">Carregar alunos</button>
  </form>

<?php if ($disc !== null): ?>
  <p class="subtitulo"><?php echo h($disc['nome_materia']); ?> · <?php echo h($disc['nome_turma']); ?> · <?php echo h($bimestres[$bimestre]); ?></p>

  <!-- A média (das 3 notas) é calculada pelo PHP ao salvar -->
  <form action="../salvarnotas.php" method="post">
    <input type="hidden" name="id_turma_materia" value="<?php echo $tm; ?>">
    <input type="hidden" name="bimestre" value="<?php echo h($bimestre); ?>">

    <div class="tabela-wrap">
      <table>
        <thead>
          <tr>
            <th>Aluno</th>
            <th class="num">Nota 1</th><th class="num">Nota 2</th><th class="num">Nota 3</th>
            <th class="num">Média</th>
          </tr>
        </thead>
        <tbody>
<?php if (count($alunos) == 0): ?>
          <tr><td colspan="5">Nenhum aluno com matrícula ativa nesta turma.</td></tr>
<?php endif; ?>
<?php foreach ($alunos as $a): ?>
          <tr>
            <td><?php echo h($a['nome']); ?></td>
            <td class="num"><input class="input-nota" type="number" name="nota1[<?php echo (int)$a['id_aluno']; ?>]" min="0" max="10" step="0.1" value="<?php echo h($a['nota1']); ?>"></td>
            <td class="num"><input class="input-nota" type="number" name="nota2[<?php echo (int)$a['id_aluno']; ?>]" min="0" max="10" step="0.1" value="<?php echo h($a['nota2']); ?>"></td>
            <td class="num"><input class="input-nota" type="number" name="nota3[<?php echo (int)$a['id_aluno']; ?>]" min="0" max="10" step="0.1" value="<?php echo h($a['nota3']); ?>"></td>
            <?php echo celula_nota($a['media']); ?>
          </tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>

<?php if (count($alunos) > 0): ?>
    <div class="acoes-form">
      <button class="btn" type="submit">Salvar notas</button>
    </div>
<?php endif; ?>
  </form>
<?php endif; ?>

</div>

</body>
</html>
