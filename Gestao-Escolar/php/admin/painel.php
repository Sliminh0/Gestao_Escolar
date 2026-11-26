<?php
$exigido = "Administrador";
include "../verifica.php";
include_once "../conexao.php";
$totalAlunos = $sql->query("SELECT COUNT(*) AS n FROM aluno")->fetch_assoc()["n"];
$totalProfessores = $sql->query("SELECT COUNT(*) AS n FROM professor")->fetch_assoc()["n"];
$totalTurmas = $sql->query("SELECT COUNT(*) AS n FROM turma")->fetch_assoc()["n"];
$totalAtivas = $sql->query("SELECT COUNT(*) AS n FROM matricula WHERE estado = 'Ativa'")->fetch_assoc()["n"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Gestão Escolar</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<?php include "../includes/header_admin.php"; ?>

<div class="container">

  <div class="page-head">
    <h2 class="titulo-pag">Painel do Administrador</h2>
  </div>

  <div class="cards">
    <a class="card" href="listaraluno.php"><span class="rotulo">Alunos</span><span class="num"><?php echo (int)$totalAlunos; ?></span></a>
    <a class="card" href="listarprofessor.php"><span class="rotulo">Professores</span><span class="num"><?php echo (int)$totalProfessores; ?></span></a>
    <a class="card" href="listarturma.php"><span class="rotulo">Turmas</span><span class="num"><?php echo (int)$totalTurmas; ?></span></a>
    <a class="card" href="listarmatricula.php"><span class="rotulo">Matrículas ativas</span><span class="num"><?php echo (int)$totalAtivas; ?></span></a>
  </div>

  <h3 class="secao-titulo">Atalhos</h3>

  <div class="cards">
    <a class="card" href="cadaluno.php"><h3>+ Novo aluno</h3><p>Cadastrar um aluno</p></a>
    <a class="card" href="cadprofessor.php"><h3>+ Novo professor</h3><p>Cadastrar um professor</p></a>
    <a class="card" href="cadturma.php"><h3>+ Nova turma</h3><p>Criar turma do ano letivo</p></a>
    <a class="card" href="cadmatricula.php"><h3>+ Nova matrícula</h3><p>Matricular aluno em uma turma</p></a>
    <a class="card" href="turmamateria.php"><h3>Disciplinas por turma</h3><p>Matéria e professor de cada turma</p></a>
    <a class="card" href="consultanotas.php"><h3>Consultar notas</h3><p>Filtrar por turma e bimestre</p></a>
  </div>

</div>

</body>
</html>
