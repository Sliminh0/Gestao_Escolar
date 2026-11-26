<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = $_POST["id"] ?? 0;
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
    $stmt = $sql->prepare("UPDATE professor SET nome = ?, cpf = ?, tel = ?, data_nascimento = ?, email = ?, salario = ? WHERE id_professor = ?");

    $stmt->bind_param('ssssssi', $nome, $cpf, $tel, $nascimento, $email, $salario, $id);

    $stmt->execute();

} catch (Exception $e) {
    die("Erro ao alterar: " . $e->getMessage() . "<br><a href='admin/edprofessor.php?id=" . (int)$id . "'>Voltar</a>");
}

header("Location: admin/listarprofessor.php");

?>
