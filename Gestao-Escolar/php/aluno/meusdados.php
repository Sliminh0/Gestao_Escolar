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

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus dados - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_aluno.php"; ?>

<div class="divform">
  <h2 class="titulo">Meus dados</h2>

<?php if (!$aluno): ?>
  <p class="aviso">Seu usuário não está ligado a nenhum aluno. Procure a secretaria.</p>
<?php else: ?>
  <dl class="dados">
    <dt>Nome</dt><dd><?php echo h($aluno['nome']); ?></dd>
    <dt>E-mail</dt><dd><?php echo h($aluno['email'] ?? '—'); ?></dd>
    <dt>CPF</dt><dd><?php echo h($aluno['cpf']); ?></dd>
    <dt>Telefone</dt><dd><?php echo h($aluno['tel'] ?? '—'); ?></dd>
    <dt>Data de nascimento</dt><dd><?php echo data_br($aluno['data_nascimento']); ?></dd>
    <dt>Responsável</dt><dd><?php echo h($aluno['responsavel']); ?></dd>
    <dt>Turma atual</dt><dd><?php echo $matricula ? h($matricula['nome_turma'] . ' - ' . ($matricula['turno'] ?? '') . ' (' . $matricula['ano_letivo'] . ')') : '—'; ?></dd>
    <dt>Matrícula</dt>
    <dd><?php if ($matricula): ?><span class="badge badge-<?php echo strtolower($matricula['estado']); ?>"><?php echo h(rotulo_estado($matricula['estado'])); ?></span><?php else: ?>—<?php endif; ?></dd>
  </dl>

  <p class="aviso">Para alterar seus dados, procure a secretaria da escola.</p>
<?php endif; ?>
</div>

</body>
</html>
