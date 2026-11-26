<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$busca = trim($_GET["busca"] ?? "");
$estado = $_GET["estado"] ?? "";
$like = "%" . $busca . "%";

$consulta = "SELECT m.*, a.nome AS aluno, t.nome_turma
             FROM matricula m
             JOIN aluno a ON a.id_aluno = m.id_aluno
             JOIN turma t ON t.id_turma = m.id_turma
             WHERE (a.nome LIKE ? OR t.nome_turma LIKE ? OR CAST(m.ano_letivo AS CHAR) LIKE ?)";
$tipos = "sss";
$params = [$like, $like, $like];

if (in_array($estado, ["Ativa", "Concluida", "Cancelada", "Transferida"], true)) {
    $consulta .= " AND m.estado = ?";
    $tipos .= "s";
    $params[] = $estado;
}
$consulta .= " ORDER BY m.ano_letivo DESC, a.nome";

$query = consulta($sql, $consulta, $tipos, $params)->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrículas - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Matrículas</h2>
    <a class="btn-novo" href="cadmatricula.php">+ Nova matrícula</a>
  </div>

  <form method="get" class="toolbar">
    <input type="search" name="busca" class="busca" placeholder="Buscar por aluno, turma ou ano..." value="<?php echo h($busca); ?>">
    <select name="estado">
      <option value="">Todos os estados</option>
      <option value="Ativa" <?php if ($estado == "Ativa") echo "selected"; ?>>Ativa</option>
      <option value="Concluida" <?php if ($estado == "Concluida") echo "selected"; ?>>Concluída</option>
      <option value="Cancelada" <?php if ($estado == "Cancelada") echo "selected"; ?>>Cancelada</option>
      <option value="Transferida" <?php if ($estado == "Transferida") echo "selected"; ?>>Transferida</option>
    </select>
    <button class="btn" type="submit">Buscar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Aluno</th><th>Turma</th><th class="num">Ano letivo</th><th>Data</th><th>Estado</th><th>Ações</th></tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="7">Nenhum registro encontrado.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id_matricula']; ?></td>
          <td><?php echo h($row['aluno']); ?></td>
          <td><?php echo h($row['nome_turma']); ?></td>
          <td class="num"><?php echo (int)$row['ano_letivo']; ?></td>
          <td><?php echo data_br($row['data_matricula']); ?></td>
          <td><?php echo '<span class="badge badge-' . strtolower($row['estado']) . '">' . h(rotulo_estado($row['estado'])) . '</span>'; ?></td>
          <td class="acoes">
            <a class="btn-editar" href="edmatricula.php?id=<?php echo (int)$row['id_matricula']; ?>">editar</a>
            <a class="btn-excluir" href="../excmatricula.php?id=<?php echo (int)$row['id_matricula']; ?>">excluir</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
