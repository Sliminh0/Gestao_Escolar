<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$nome = $_POST["nome"] ?? '';
$cpf = $_POST["cpf"] ?? '';
$tel = $_POST["telefone"] ?? '';
if ($tel === '') { $tel = null; }
$nascimento = $_POST["dataNascimento"] ?? '';
if ($nascimento === '') { $nascimento = null; }
$email = $_POST["email"] ?? '';
$salario = $_POST["salario"] ?? '';
if ($salario === '') { $salario = null; }

try {
    $stmt = $sql->prepare("INSERT INTO professor (nome, cpf, tel, data_nascimento, email, salario) VALUES(?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('ssssss', $nome, $cpf, $tel, $nascimento, $email, $salario);

    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!<br><a href='admin/listarprofessor.php'>Voltar para a lista</a>";
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    die($e->getMessage() . "<br><a href='admin/cadprofessor.php'>Voltar</a>");
}
?>
