<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID não informado.");
}

$query = $sql->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
$query->bind_param("i", $id);
$query->execute();

$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Usuário não encontrado.");
}

$row = $result->fetch_assoc();
$professores = $sql->query("SELECT id_professor, nome FROM professor ORDER BY nome")->fetch_all(MYSQLI_ASSOC);
$alunos = $sql->query("SELECT id_aluno, nome FROM aluno ORDER BY nome")->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Alterar Usuário</h2>

  <form action="../alterarusuario.php" method="post" class="formularios">

    <input type="hidden" name="id" value="<?php echo $row['id_usuario']; ?>">

        <div class="org">
          <label for="email">E-mail (login)</label>
          <input type="email" id="email" name="email" required value="<?php echo h($row['email']); ?>">
        </div>
        <div class="org">
          <label for="senha">Nova senha (deixe em branco para manter a atual)</label>
          <input type="password" id="senha" name="senha" minlength="6" autocomplete="new-password">
        </div>
        <div class="org">
          <label for="senha_confirmar">Confirmar senha</label>
          <input type="password" id="senha_confirmar" name="senha_confirmar" minlength="6" autocomplete="new-password">
        </div>
        <div class="org">
          <label for="tipo_usuario">Tipo de Usuário</label>
          <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="">Selecione...</option>
            <option value="Administrador" <?php if ($row['tipo_usuario'] == "Administrador") echo "selected"; ?>>Administrador</option>
            <option value="Professor" <?php if ($row['tipo_usuario'] == "Professor") echo "selected"; ?>>Professor</option>
            <option value="Aluno" <?php if ($row['tipo_usuario'] == "Aluno") echo "selected"; ?>>Aluno</option>
          </select>
        </div>
        <div class="org">
          <label for="id_professor">Professor vinculado (só se o tipo for Professor)</label>
          <select id="id_professor" name="id_professor">
            <option value="">Selecione...</option>
            <?php foreach ($professores as $o): ?>
            <option value="<?php echo $o['id_professor']; ?>" <?php if ($row['id_professor'] == $o['id_professor']) echo "selected"; ?>><?php echo h($o['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="id_aluno">Aluno vinculado (só se o tipo for Aluno)</label>
          <select id="id_aluno" name="id_aluno">
            <option value="">Selecione...</option>
            <?php foreach ($alunos as $o): ?>
            <option value="<?php echo $o['id_aluno']; ?>" <?php if ($row['id_aluno'] == $o['id_aluno']) echo "selected"; ?>><?php echo h($o['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

    <input class="btn-form" type="reset" value="Limpar">
    <input class="btn-form" type="submit" value="Atualizar" name="atualizar">
  </form>

  <a class="voltar" href="listarusuario.php">← Voltar para a lista</a>
</div>

</body>
</html>
