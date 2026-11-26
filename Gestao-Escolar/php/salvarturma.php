<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$nome_turma = $_POST["nome_turma"] ?? '';
$serie = $_POST["serie"] ?? '';
$turno = $_POST["turno"] ?? '';
if ($turno === '') { $turno = null; }
$ano_letivo = $_POST["ano_letivo"] ?? '';

try {
    $stmt = $sql->prepare("INSERT INTO turma (nome_turma, serie, turno, ano_letivo) VALUES(?, ?, ?, ?)");

    $stmt->bind_param('sssi', $nome_turma, $serie, $turno, $ano_letivo);

    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!<br><a href='admin/listarturma.php'>Voltar para a lista</a>";
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    die($e->getMessage() . "<br><a href='admin/cadturma.php'>Voltar</a>");
}
?>
