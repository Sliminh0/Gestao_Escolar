<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$nome = $_POST["nome"] ?? '';
$cpf = $_POST["cpf"] ?? '';
$cargo = $_POST["cargo"] ?? '';
$email = $_POST["email"] ?? '';
$telefone = $_POST["telefone"] ?? '';
if ($telefone === '') { $telefone = null; }
$salario = $_POST["salario"] ?? '';
if ($salario === '') { $salario = null; }

try {
    $stmt = $sql->prepare("INSERT INTO funcionario (nome, cpf, cargo, email, telefone, salario) VALUES(?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('ssssss', $nome, $cpf, $cargo, $email, $telefone, $salario);

    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!<br><a href='admin/listarfunci.php'>Voltar para a lista</a>";
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    die($e->getMessage() . "<br><a href='admin/cadfunci.php'>Voltar</a>");
}
?>
