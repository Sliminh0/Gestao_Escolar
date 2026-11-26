<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = (int)($_GET["id"] ?? 0);

try {
    $stmt = $sql->prepare("DELETE FROM materia WHERE id_materia = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

} catch (Exception $e) {
    die("Não foi possível excluir: este registro está ligado a outros cadastros.<br><a href='admin/listarmateria.php'>Voltar</a>");
}

header("Location: admin/listarmateria.php");
?>
