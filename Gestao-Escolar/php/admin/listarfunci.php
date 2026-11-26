<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$busca = trim($_GET["busca"] ?? "");
$like = "%" . $busca . "%";

$stmt = $sql->prepare("SELECT * FROM funcionario WHERE nome LIKE ? OR cargo LIKE ? OR cpf LIKE ? OR email LIKE ? ORDER BY nome");
$stmt->bind_param("ssss", $like, $like, $like, $like);
$stmt->execute();
$query = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Funcionários</h2>
    <a class="btn-novo" href="cadfunci.php">+ Novo funcionário</a>
  </div>

  <form method="get" class="toolbar">
    <input type="search" name="busca" class="busca" placeholder="Buscar por nome, cargo, CPF ou e-mail..." value="<?php echo h($busca); ?>">
    <button class="btn" type="submit">Buscar</button>
  </form>

  <div class="tabela-wrap">
    <table>
      <thead>
        <tr><th>ID</th><th>Nome</th><th>Cargo</th><th>CPF</th><th>E-mail</th><th>Telefone</th><th>Salário</th><th>Ações</th></tr>
      </thead>
      <tbody>
<?php if ($query->num_rows == 0): ?>
        <tr><td colspan="8">Nenhum registro encontrado.</td></tr>
<?php endif; ?>
<?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?php echo (int)$row['id_funcionario']; ?></td>
          <td><?php echo h($row['nome']); ?></td>
          <td><?php echo h($row['cargo']); ?></td>
          <td><?php echo h($row['cpf']); ?></td>
          <td><?php echo h($row['email']); ?></td>
          <td><?php echo h($row['telefone'] ?? '—'); ?></td>
          <td><?php echo dinheiro($row['salario']); ?></td>
          <td class="acoes">
            <a class="btn-editar" href="edfunci.php?id=<?php echo (int)$row['id_funcionario']; ?>">editar</a>
            <a class="btn-excluir" href="../excfunci.php?id=<?php echo (int)$row['id_funcionario']; ?>">excluir</a>
          </td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>
