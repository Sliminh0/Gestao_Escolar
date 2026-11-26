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

$mediaGeral = consulta($sql, "SELECT AVG(media) AS m FROM notas WHERE nota_id_aluno = ?",
    "i", [$idAluno])->get_result()->fetch_assoc()["m"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu painel - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_aluno.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Meu painel</h2>
  </div>

<?php if (!$aluno): ?>
  <p class="subtitulo">Seu usuário não está ligado a nenhum aluno. Procure a secretaria.</p>
<?php else: ?>
  <div class="cards">
    <div class="card"><span class="rotulo">Turma atual</span><span class="num"><?php echo $matricula ? h($matricula['nome_turma']) : '—'; ?></span></div>
    <div class="card"><span class="rotulo">Ano letivo</span><span class="num"><?php echo $matricula ? (int)$matricula['ano_letivo'] : '—'; ?></span></div>
    <div class="card"><span class="rotulo">Matrícula</span><span class="num"><?php echo $matricula ? h(rotulo_estado($matricula['estado'])) : '—'; ?></span></div>
    <div class="card"><span class="rotulo">Média geral</span><span class="num"><?php echo $mediaGeral !== null ? number_format((float)$mediaGeral, 1, ',', '.') : '—'; ?></span></div>
  </div>

  <h3 class="secao-titulo">Acesso rápido</h3>

  <div class="cards">
    <a class="card" href="boletim.php"><h3>Boletim</h3><p>Veja suas notas por bimestre</p></a>
    <a class="card" href="meusdados.php"><h3>Meus dados</h3><p>Dados cadastrais e matrícula</p></a>
  </div>
<?php endif; ?>

</div>

</body>
</html>
