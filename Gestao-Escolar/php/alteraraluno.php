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
$responsavel = $_POST["responsavel"] ?? '';
$email = $_POST["email"] ?? '';
if ($email === '') { $email = null; }

try {
    $stmt = $sql->prepare("UPDATE aluno SET nome = ?, cpf = ?, tel = ?, data_nascimento = ?, responsavel = ?, email = ? WHERE id_aluno = ?");

    $stmt->bind_param('ssssssi', $nome, $cpf, $tel, $nascimento, $responsavel, $email, $id);

    $stmt->execute();

} catch (Exception $e) {
    die("Erro ao alterar: " . $e->getMessage() . "<br><a href='admin/edaluno.php?id=" . (int)$id . "'>Voltar</a>");
}

header("Location: admin/listaraluno.php");

?>
