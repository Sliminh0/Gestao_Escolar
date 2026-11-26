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
$responsavel = $_POST["responsavel"] ?? '';
$email = $_POST["email"] ?? '';
if ($email === '') { $email = null; }

try {
    $stmt = $sql->prepare("INSERT INTO aluno (nome, cpf, tel, data_nascimento, responsavel, email) VALUES(?, ?, ?, ?, ?, ?)");

    $stmt->bind_param('ssssss', $nome, $cpf, $tel, $nascimento, $responsavel, $email);

    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!<br><a href='admin/listaraluno.php'>Voltar para a lista</a>";
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    die($e->getMessage() . "<br><a href='admin/cadaluno.php'>Voltar</a>");
}
?>
