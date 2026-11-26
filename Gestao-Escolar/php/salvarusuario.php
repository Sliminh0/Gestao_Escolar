<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$email = trim($_POST["email"] ?? '');
$senha = $_POST["senha"] ?? '';
$confirmar = $_POST["senha_confirmar"] ?? '';
$tipo = $_POST["tipo_usuario"] ?? '';
$id_professor = (int)($_POST["id_professor"] ?? 0) ?: null;
$id_aluno = (int)($_POST["id_aluno"] ?? 0) ?: null;

if ($tipo !== "Professor") { $id_professor = null; }
if ($tipo !== "Aluno") { $id_aluno = null; }

$erro = "";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "Informe um e-mail válido.";
} elseif (!in_array($tipo, ["Administrador", "Professor", "Aluno"], true)) {
    $erro = "Escolha o tipo de usuário.";
} elseif (strlen($senha) < 6) {
    $erro = "A senha precisa ter pelo menos 6 caracteres.";
} elseif ($senha !== $confirmar) {
    $erro = "As senhas não conferem.";
} elseif ($tipo === "Professor" && $id_professor === null) {
    $erro = "Escolha o professor vinculado a este usuário.";
} elseif ($tipo === "Aluno" && $id_aluno === null) {
    $erro = "Escolha o aluno vinculado a este usuário.";
}

if ($erro !== "") {
    die($erro . "<br><a href='admin/cadusuario.php'>Voltar</a>");
}

try {
    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $sql->prepare("INSERT INTO usuario (email, senha_hash, tipo_usuario, id_professor, id_aluno) VALUES(?,?,?,?,?)");

    $stmt->bind_param('sssii', $email, $hash, $tipo, $id_professor, $id_aluno);

    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!<br><a href='admin/listarusuario.php'>Voltar para a lista</a>";
    } else {
        throw new Exception("Erro ao salvar: " . $stmt->error);
    }

} catch (Exception $e) {
    die($e->getMessage() . "<br><a href='admin/cadusuario.php'>Voltar</a>");
}
?>
