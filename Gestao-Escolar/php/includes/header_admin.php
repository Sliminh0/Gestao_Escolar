<?php
// Marca o item do menu da página atual
$paginaAtual = basename($_SERVER['PHP_SELF']);
if (!function_exists('ativo')) {
    function ativo(array $arquivos) {
        global $paginaAtual;
        return in_array($paginaAtual, $arquivos) ? ' class="ativo"' : '';
    }
}
?>
<header>
  <div class="logo">Olá Administrador</div>

  <input type="checkbox" id="menu-toggle">

  <label for="menu-toggle" class="hamburguer">
    ☰
  </label>

  <nav>
    <a href="painel.php"<?php echo ativo(['painel.php']); ?>>Início</a>
    <span class="grupo">Pessoas</span>
    <a href="listaraluno.php"<?php echo ativo(['listaraluno.php', 'cadaluno.php', 'edaluno.php']); ?>>Alunos</a>
    <a href="listarprofessor.php"<?php echo ativo(['listarprofessor.php', 'cadprofessor.php', 'edprofessor.php']); ?>>Professores</a>
    <a href="listarfunci.php"<?php echo ativo(['listarfunci.php', 'cadfunci.php', 'edfunci.php']); ?>>Funcionários</a>
    <span class="grupo">Acadêmico</span>
    <a href="listarturma.php"<?php echo ativo(['listarturma.php', 'cadturma.php', 'edturma.php']); ?>>Turmas</a>
    <a href="listarmateria.php"<?php echo ativo(['listarmateria.php', 'cadmateria.php', 'edmateria.php']); ?>>Matérias</a>
    <a href="turmamateria.php"<?php echo ativo(['turmamateria.php']); ?>>Disciplinas por turma</a>
    <a href="listarmatricula.php"<?php echo ativo(['listarmatricula.php', 'cadmatricula.php', 'edmatricula.php']); ?>>Matrículas</a>
    <a href="consultanotas.php"<?php echo ativo(['consultanotas.php']); ?>>Notas</a>
    <span class="grupo">Sistema</span>
    <a href="listarusuario.php"<?php echo ativo(['listarusuario.php', 'cadusuario.php', 'edusuario.php']); ?>>Usuários</a>
    <a href="../logout.php">Sair</a>
  </nav>
</header>
