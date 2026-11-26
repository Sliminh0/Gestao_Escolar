<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = (int)($_GET["id"] ?? 0);

if ($id === (int)$_SESSION["id_usuario"]) {
    die("Você não pode excluir o seu próprio usuário.<br><a href='admin/listarusuario.php'>Voltar</a>");
}

try {
    $stmt = $sql->prepare("DELETE FROM usuario WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

} catch (Exception $e) {
    // Acontece quando o registro está sendo usado em outro cadastro (matrícula, notas, turma...)
    die("Não foi possível excluir: este registro está ligado a outros cadastros.<br><a href='admin/listarusuario.php'>Voltar</a>");
}

header("Location: admin/listarusuario.php");
?>
