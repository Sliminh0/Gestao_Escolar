<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$busca = trim($_GET["busca"] ?? "");
$like = "%" . $busca . "%";

$stmt = $sql->prepare("SELECT * FROM materia WHERE nome_materia LIKE ? ORDER BY nome_materia");
$stmt->bind_param("s", $like);
$stmt->execute();
$query = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matérias - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Matérias</h2>
    <a class="btn-novo" href="cadmateria.php">+ Nova matéria</a>
  </div>

  <form method="get" class="toolbar">
    <input type="search" name="busca" class="busca" placeholder="Buscar matéria..." value="<?php echo h($busca); ?>">
    <button class="btn" type="submit">Buscar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Matéria</th><th>Carga horária</th><th>Ações</th></tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="4">Nenhum registro encontrado.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id_materia']; ?></td>
          <td><?php echo h($row['nome_materia']); ?></td>
          <td><?php echo $row['carga_horaria'] !== null ? (int)$row['carga_horaria'] . ' h' : '—'; ?></td>
          <td class="acoes">
            <a class="btn-editar" href="edmateria.php?id=<?php echo (int)$row['id_materia']; ?>">editar</a>
            <a class="btn-excluir" href="../excmateria.php?id=<?php echo (int)$row['id_materia']; ?>">excluir</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
