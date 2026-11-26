<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID não informado.");
}

$query = $sql->prepare("SELECT * FROM aluno WHERE id_aluno = ?");
$query->bind_param("i", $id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Aluno não encontrado.");
}

$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Aluno - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Alterar Aluno</h2>

  <form action="../alteraraluno.php" method="post" class="formularios">

    <input type="hidden" name="id" value="<?php echo $row['id_aluno']; ?>">

        <div class="org">
          <label for="nome">Nome Completo</label>
          <input type="text" id="nome" name="nome" required value="<?php echo h($row['nome']); ?>">
        </div>
        <div class="org">
          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" value="<?php echo h($row['cpf']); ?>">
        </div>
        <div class="org">
          <label for="telefone">Telefone</label>
          <input type="tel" id="telefone" name="telefone" required placeholder="(00) 91234-5678" pattern="\(\d{2}\) \d{4,5}-\d{4}" value="<?php echo h($row['tel']); ?>">
        </div>
        <div class="org">
          <label for="diasnasc">Data de Nascimento</label>
          <input type="date" id="diasnasc" name="dataNascimento" value="<?php echo h($row['data_nascimento']); ?>">
        </div>
        <div class="org">
          <label for="responsavel">Responsável</label>
          <input type="text" id="responsavel" name="responsavel" required value="<?php echo h($row['responsavel']); ?>">
        </div>
        <div class="org">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required value="<?php echo h($row['email']); ?>">
        </div>

    <input class="btn-form" type="reset" value="Limpar">
    <input class="btn-form" type="submit" value="Atualizar" name="atualizar">
  </form>

  <a class="voltar" href="listaraluno.php">← Voltar para a lista</a>
</div>

</body>
</html>
