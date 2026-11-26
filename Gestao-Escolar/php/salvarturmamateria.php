<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$turma = (int)($_POST["tm_id_turma"] ?? 0);
$materia = (int)($_POST["tm_id_materia"] ?? 0);
$professor = (int)($_POST["tm_id_professor"] ?? 0);

try {
    $stmt = $sql->prepare("INSERT INTO turma_materia (tm_id_turma, tm_id_materia, tm_id_professor) VALUES(?,?,?)");

    $stmt->bind_param('iii', $turma, $materia, $professor);

    if ($stmt->execute()) {
        header("Location: admin/turmamateria.php");
        exit;
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    // Normalmente: a matéria já está ligada a essa turma
    die($e->getMessage() . "<br><a href='admin/turmamateria.php'>Voltar</a>");
}
?>
