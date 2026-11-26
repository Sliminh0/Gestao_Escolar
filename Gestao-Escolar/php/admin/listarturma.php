<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$busca = trim($_GET["busca"] ?? "");
$like = "%" . $busca . "%";

$stmt = $sql->prepare("SELECT * FROM turma WHERE nome_turma LIKE ? OR serie LIKE ? OR turno LIKE ? ORDER BY ano_letivo DESC, nome_turma");
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$query = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Turmas</h2>
    <a class="btn-novo" href="cadturma.php">+ Nova turma</a>
  </div>

  <form method="get" class="toolbar">
    <input type="search" name="busca" class="busca" placeholder="Buscar por turma, série ou turno..." value="<?php echo h($busca); ?>">
    <button class="btn" type="submit">Buscar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Turma</th><th>Série</th><th>Turno</th><th class="num">Ano letivo</th><th>Ações</th></tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="6">Nenhum registro encontrado.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id_turma']; ?></td>
          <td><?php echo h($row['nome_turma']); ?></td>
          <td><?php echo h($row['serie']); ?></td>
          <td><?php echo h($row['turno'] ?? '—'); ?></td>
          <td class="num"><?php echo (int)$row['ano_letivo']; ?></td>
          <td class="acoes">
            <a class="btn-editar" href="edturma.php?id=<?php echo (int)$row['id_turma']; ?>">editar</a>
            <a class="btn-excluir" href="../excturma.php?id=<?php echo (int)$row['id_turma']; ?>">excluir</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
