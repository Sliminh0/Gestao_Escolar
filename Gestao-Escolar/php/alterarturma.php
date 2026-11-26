<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = $_POST["id"] ?? 0;
$nome_turma = $_POST["nome_turma"] ?? '';
$serie = $_POST["serie"] ?? '';
$turno = $_POST["turno"] ?? '';
if ($turno === '') { $turno = null; }
$ano_letivo = $_POST["ano_letivo"] ?? '';

try {
    $stmt = $sql->prepare("UPDATE turma SET nome_turma = ?, serie = ?, turno = ?, ano_letivo = ? WHERE id_turma = ?");

    $stmt->bind_param('sssii', $nome_turma, $serie, $turno, $ano_letivo, $id);

    $stmt->execute();

} catch (Exception $e) {
    die("Erro ao alterar: " . $e->getMessage() . "<br><a href='admin/edturma.php?id=" . (int)$id . "'>Voltar</a>");
}

header("Location: admin/listarturma.php");

?>
