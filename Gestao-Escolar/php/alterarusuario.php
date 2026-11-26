<?php
$exigido = "Administrador";
include "verifica.php";
include_once "conexao.php";

$id = (int)($_POST["id"] ?? 0);
$email = trim($_POST["email"] ?? '');
$senha = $_POST["senha"] ?? '';
$confirmar = $_POST["senha_confirmar"] ?? '';
$tipo = $_POST["tipo_usuario"] ?? '';
$id_professor = (int)($_POST["id_professor"] ?? 0) ?: null;
$id_aluno = (int)($_POST["id_aluno"] ?? 0) ?: null;

// Cada tipo só guarda o seu próprio vínculo
if ($tipo !== "Professor") { $id_professor = null; }
if ($tipo !== "Aluno") { $id_aluno = null; }

$erro = "";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "Informe um e-mail válido.";
} elseif (!in_array($tipo, ["Administrador", "Professor", "Aluno"], true)) {
    $erro = "Escolha o tipo de usuário.";
} elseif ($senha !== "" && strlen($senha) < 6) {
    $erro = "A senha precisa ter pelo menos 6 caracteres.";
} elseif ($senha !== $confirmar) {
    $erro = "As senhas não conferem.";
} elseif ($tipo === "Professor" && $id_professor === null) {
    $erro = "Escolha o professor vinculado a este usuário.";
} elseif ($tipo === "Aluno" && $id_aluno === null) {
    $erro = "Escolha o aluno vinculado a este usuário.";
}

// Não deixa o administrador tirar o próprio acesso
if ($erro === "" && $id === (int)$_SESSION["id_usuario"] && $tipo !== "Administrador") {
    $erro = "Você não pode tirar o seu próprio acesso de administrador.";
}

if ($erro !== "") {
    die($erro . "<br><a href='admin/edusuario.php?id=" . $id . "'>Voltar</a>");
}

try {
    if ($senha !== "") {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $sql->prepare("UPDATE usuario SET email = ?, senha_hash = ?, tipo_usuario = ?, id_professor = ?, id_aluno = ? WHERE id_usuario = ?");
        $stmt->bind_param('sssiii', $email, $hash, $tipo, $id_professor, $id_aluno, $id);
    } else {
        // Senha em branco: mantém a senha atual
        $stmt = $sql->prepare("UPDATE usuario SET email = ?, tipo_usuario = ?, id_professor = ?, id_aluno = ? WHERE id_usuario = ?");
        $stmt->bind_param('ssiii', $email, $tipo, $id_professor, $id_aluno, $id);
    }

    $stmt->execute();

} catch (Exception $e) {
    die("Erro ao alterar: " . $e->getMessage() . "<br><a href='admin/edusuario.php?id=" . $id . "'>Voltar</a>");
}

header("Location: admin/listarusuario.php");

?>
