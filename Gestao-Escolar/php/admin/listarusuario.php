<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$busca = trim($_GET["busca"] ?? "");
$like = "%" . $busca . "%";

$stmt = $sql->prepare("SELECT u.*, p.nome AS professor, a.nome AS aluno
                       FROM usuario u
                       LEFT JOIN professor p ON p.id_professor = u.id_professor
                       LEFT JOIN aluno a ON a.id_aluno = u.id_aluno
                       WHERE u.email LIKE ? OR u.tipo_usuario LIKE ?
                       ORDER BY u.email");
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$query = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Usuários</h2>
    <a class="btn-novo" href="cadusuario.php">+ Novo usuário</a>
  </div>

  <form method="get" class="toolbar">
    <input type="search" name="busca" class="busca" placeholder="Buscar por e-mail ou tipo..." value="<?php echo h($busca); ?>">
    <button class="btn" type="submit">Buscar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>E-mail</th><th>Tipo</th><th>Vínculo</th><th>Ações</th></tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="5">Nenhum registro encontrado.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id_usuario']; ?></td>
          <td><?php echo h($row['email']); ?></td>
          <td><span class="badge badge-<?php echo strtolower($row['tipo_usuario']); ?>"><?php echo h($row['tipo_usuario']); ?></span></td>
          <td><?php echo h($row['professor'] ?? $row['aluno'] ?? '—'); ?></td>
          <td class="acoes">
            <a class="btn-editar" href="edusuario.php?id=<?php echo (int)$row['id_usuario']; ?>">editar</a>
            <a class="btn-excluir" href="../excusuario.php?id=<?php echo (int)$row['id_usuario']; ?>">excluir</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
