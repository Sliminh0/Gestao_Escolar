<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = $_POST["id"] ?? 0;
$nome = $_POST["nome"] ?? '';
$cpf = $_POST["cpf"] ?? '';
$cargo = $_POST["cargo"] ?? '';
$email = $_POST["email"] ?? '';
$telefone = $_POST["telefone"] ?? '';
if ($telefone === '') { $telefone = null; }
$salario = $_POST["salario"] ?? '';
if ($salario === '') { $salario = null; }

try {
    $stmt = $sql->prepare("UPDATE funcionario SET nome = ?, cpf = ?, cargo = ?, email = ?, telefone = ?, salario = ? WHERE id_funcionario = ?");

    $stmt->bind_param('ssssssi', $nome, $cpf, $cargo, $email, $telefone, $salario, $id);

    $stmt->execute();

} catch (Exception $e) {
    die("Erro ao alterar: " . $e->getMessage() . "<br><a href='admin/edfunci.php?id=" . (int)$id . "'>Voltar</a>");
}

header("Location: admin/listarfunci.php");

?>
