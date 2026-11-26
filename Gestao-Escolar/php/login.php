<?php
session_start();
include_once "conexao.php";

$email = $_POST["email"] ?? '';
$senha = $_POST["senha"] ?? '';

$stmt = $sql->prepare("SELECT u.id_usuario, u.senha_hash, u.tipo_usuario, u.id_professor, u.id_aluno,
                              p.nome AS nome_professor, a.nome AS nome_aluno
                       FROM usuario u
                       LEFT JOIN professor p ON p.id_professor = u.id_professor
                       LEFT JOIN aluno a ON a.id_aluno = u.id_aluno
                       WHERE u.email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$usuario = $stmt->get_result()->fetch_assoc();

// E-mail ou senha errados: volta para o login
if (!$usuario || !password_verify($senha, $usuario["senha_hash"])) {
    header("Location: ../../index.php?erro=1");
    exit;
}

// Login certo: guarda os dados na sessão
session_regenerate_id(true);
$_SESSION["id_usuario"] = (int)$usuario["id_usuario"];
$_SESSION["tipo"] = $usuario["tipo_usuario"];
$_SESSION["id_professor"] = $usuario["id_professor"];
$_SESSION["id_aluno"] = $usuario["id_aluno"];
$_SESSION["nome"] = $usuario["nome_professor"] ?? $usuario["nome_aluno"] ?? "Administrador";

if ($usuario["tipo_usuario"] == "Professor") {
    header("Location: professor/painel.php");
} elseif ($usuario["tipo_usuario"] == "Aluno") {
    header("Location: aluno/painel.php");
} else {
    header("Location: admin/painel.php");
}
exit;
?>
