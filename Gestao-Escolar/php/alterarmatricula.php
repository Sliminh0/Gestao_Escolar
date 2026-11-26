<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = $_POST["id"] ?? 0;
$id_aluno = $_POST["id_aluno"] ?? '';
$id_turma = $_POST["id_turma"] ?? '';
$ano_letivo = $_POST["ano_letivo"] ?? '';
$data_matricula = $_POST["data_matricula"] ?? '';
if ($data_matricula === '') { $data_matricula = null; }
$estado = $_POST["estado"] ?? '';

try {
    $stmt = $sql->prepare("UPDATE matricula SET id_aluno = ?, id_turma = ?, ano_letivo = ?, data_matricula = ?, estado = ? WHERE id_matricula = ?");

    $stmt->bind_param('iiissi', $id_aluno, $id_turma, $ano_letivo, $data_matricula, $estado, $id);

    $stmt->execute();

} catch (Exception $e) {
    die("Erro ao alterar: " . $e->getMessage() . "<br><a href='admin/edmatricula.php?id=" . (int)$id . "'>Voltar</a>");
}

header("Location: admin/listarmatricula.php");

?>
