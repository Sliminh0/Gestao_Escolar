<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = $_POST["id"] ?? 0;
$nome_materia = $_POST["nome_materia"] ?? '';
$carga_horaria = $_POST["carga_horaria"] ?? '';
if ($carga_horaria === '') { $carga_horaria = null; }

try {
    $stmt = $sql->prepare("UPDATE materia SET nome_materia = ?, carga_horaria = ? WHERE id_materia = ?");

    $stmt->bind_param('sii', $nome_materia, $carga_horaria, $id);

    $stmt->execute();

} catch (Exception $e) {
    die("Erro ao alterar: " . $e->getMessage() . "<br><a href='admin/edmateria.php?id=" . (int)$id . "'>Voltar</a>");
}

header("Location: admin/listarmateria.php");

?>
