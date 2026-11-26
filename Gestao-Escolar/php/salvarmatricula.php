<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id_aluno = $_POST["id_aluno"] ?? '';
$id_turma = $_POST["id_turma"] ?? '';
$ano_letivo = $_POST["ano_letivo"] ?? '';
$data_matricula = $_POST["data_matricula"] ?? '';
if ($data_matricula === '') { $data_matricula = null; }
$estado = $_POST["estado"] ?? '';

try {
    $stmt = $sql->prepare("INSERT INTO matricula (id_aluno, id_turma, ano_letivo, data_matricula, estado) VALUES(?, ?, ?, ?, ?)");

    $stmt->bind_param('iiiss', $id_aluno, $id_turma, $ano_letivo, $data_matricula, $estado);

    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!<br><a href='admin/listarmatricula.php'>Voltar para a lista</a>";
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    die($e->getMessage() . "<br><a href='admin/cadmatricula.php'>Voltar</a>");
}
?>
