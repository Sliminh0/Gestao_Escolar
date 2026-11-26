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
  <div class="logo">Olá, <?php echo h($_SESSION['nome']); ?></div>

  <input type="checkbox" id="menu-toggle">

  <label for="menu-toggle" class="hamburguer">
    ☰
  </label>

  <nav>
    <a href="painel.php"<?php echo ativo(['painel.php']); ?>>Início</a>
    <a href="boletim.php"<?php echo ativo(['boletim.php']); ?>>Boletim</a>
    <a href="meusdados.php"<?php echo ativo(['meusdados.php']); ?>>Meus dados</a>
    <a href="../logout.php">Sair</a>
  </nav>
</header>
