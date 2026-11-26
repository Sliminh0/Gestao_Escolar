<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$professores = $sql->query("SELECT id_professor, nome FROM professor ORDER BY nome")->fetch_all(MYSQLI_ASSOC);
$alunos = $sql->query("SELECT id_aluno, nome FROM aluno ORDER BY nome")->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="divform">
  <h2 class="titulo">Cadastro de Usuário</h2>

  <form action="../salvarusuario.php" method="post" class="formularios">

        <div class="org">
          <label for="email">E-mail (login)</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="org">
          <label for="senha">Senha (mínimo 6 caracteres)</label>
          <input type="password" id="senha" name="senha" minlength="6" autocomplete="new-password" required>
        </div>
        <div class="org">
          <label for="senha_confirmar">Confirmar senha</label>
          <input type="password" id="senha_confirmar" name="senha_confirmar" minlength="6" autocomplete="new-password" required>
        </div>
        <div class="org">
          <label for="tipo_usuario">Tipo de Usuário</label>
          <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="">Selecione...</option>
            <option value="Administrador">Administrador</option>
            <option value="Professor">Professor</option>
            <option value="Aluno">Aluno</option>
          </select>
        </div>
        <div class="org">
          <label for="id_professor">Professor vinculado (só se o tipo for Professor)</label>
          <select id="id_professor" name="id_professor">
            <option value="">Selecione...</option>
            <?php foreach ($professores as $o): ?>
            <option value="<?php echo $o['id_professor']; ?>"><?php echo h($o['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="org">
          <label for="id_aluno">Aluno vinculado (só se o tipo for Aluno)</label>
          <select id="id_aluno" name="id_aluno">
            <option value="">Selecione...</option>
            <?php foreach ($alunos as $o): ?>
            <option value="<?php echo $o['id_aluno']; ?>"><?php echo h($o['nome']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

    <input class="btn-form" type="submit" value="Salvar">
    <input class="btn-form" type="reset" value="Limpar">
  </form>

  <a class="voltar" href="listarusuario.php">← Voltar para a lista</a>
</div>

</body>
</html>
