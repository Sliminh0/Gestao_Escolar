<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$busca = trim($_GET["busca"] ?? "");
$like = "%" . $busca . "%";

$stmt = $sql->prepare("SELECT * FROM professor WHERE nome LIKE ? OR cpf LIKE ? OR email LIKE ? ORDER BY nome");
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$query = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professores - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Professores</h2>
    <a class="btn-novo" href="cadprofessor.php">+ Novo professor</a>
  </div>

  <form method="get" class="toolbar">
    <input type="search" name="busca" class="busca" placeholder="Buscar por nome, CPF ou e-mail..." value="<?php echo h($busca); ?>">
    <button class="btn" type="submit">Buscar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Nome</th><th>CPF</th><th>E-mail</th><th>Telefone</th><th>Salário</th><th>Ações</th></tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="7">Nenhum registro encontrado.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id_professor']; ?></td>
          <td><?php echo h($row['nome']); ?></td>
          <td><?php echo h($row['cpf']); ?></td>
          <td><?php echo h($row['email']); ?></td>
          <td><?php echo h($row['tel'] ?? '—'); ?></td>
          <td><?php echo dinheiro($row['salario']); ?></td>
          <td class="acoes">
            <a class="btn-editar" href="edprofessor.php?id=<?php echo (int)$row['id_professor']; ?>">editar</a>
            <a class="btn-excluir" href="../excprofessor.php?id=<?php echo (int)$row['id_professor']; ?>">excluir</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
