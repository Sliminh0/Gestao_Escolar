<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = (int)($_GET["id"] ?? 0);

try {
    $stmt = $sql->prepare("DELETE FROM funcionario WHERE id_funcionario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

} catch (Exception $e) {
    // Acontece quando o registro está sendo usado em outro cadastro (matrícula, notas, turma...)
    die("Não foi possível excluir: este registro está ligado a outros cadastros.<br><a href='admin/listarfunci.php'>Voltar</a>");
}

header("Location: admin/listarfunci.php");
?>
