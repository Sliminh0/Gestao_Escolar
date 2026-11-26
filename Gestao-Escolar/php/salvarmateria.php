<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$nome_materia = $_POST["nome_materia"] ?? '';
$carga_horaria = $_POST["carga_horaria"] ?? '';
if ($carga_horaria === '') { $carga_horaria = null; }

try {
    $stmt = $sql->prepare("INSERT INTO materia (nome_materia, carga_horaria) VALUES(?, ?)");

    $stmt->bind_param('si', $nome_materia, $carga_horaria);

    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!<br><a href='admin/listarmateria.php'>Voltar para a lista</a>";
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    die($e->getMessage() . "<br><a href='admin/cadmateria.php'>Voltar</a>");
}
?>
