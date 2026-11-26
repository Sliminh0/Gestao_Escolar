<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID não informado.");
}

$query = $sql->prepare("SELECT * FROM funcionario WHERE id_funcionario = ?");
$query->bind_param("i", $id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Funcionário não encontrado.");
}

$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Funcionário - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Alterar Funcionário</h2>

  <form action="../alterarfunci.php" method="post" class="formularios">

    <input type="hidden" name="id" value="<?php echo $row['id_funcionario']; ?>">

        <div class="org">
          <label for="nome">Nome Completo</label>
          <input type="text" id="nome" name="nome" required value="<?php echo h($row['nome']); ?>">
        </div>
        <div class="org">
          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" value="<?php echo h($row['cpf']); ?>">
        </div>
        <div class="org">
          <label for="cargo">Cargo</label>
          <input type="text" id="cargo" name="cargo" required placeholder="Ex.: Secretária, Coordenador" value="<?php echo h($row['cargo']); ?>">
        </div>
        <div class="org">
          <label for="email">E-mail</label>
          <input type="email" id="email" name="email" required value="<?php echo h($row['email']); ?>">
        </div>
        <div class="org">
          <label for="telefone">Telefone</label>
          <input type="tel" id="telefone" name="telefone" placeholder="(00) 91234-5678" pattern="\(\d{2}\) \d{4,5}-\d{4}" value="<?php echo h($row['telefone']); ?>">
        </div>
        <div class="org">
          <label for="salario">Salário (R$)</label>
          <input type="number" id="salario" name="salario" min="0" step="0.01" placeholder="0,00" value="<?php echo h($row['salario']); ?>">
        </div>

    <input class="btn-form" type="reset" value="Limpar">
    <input class="btn-form" type="submit" value="Atualizar" name="atualizar">
  </form>

  <a class="voltar" href="listarfunci.php">← Voltar para a lista</a>
</div>

</body>
</html>
