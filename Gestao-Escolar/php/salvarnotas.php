<?php
$exigido = "Professor";
include "verifica.php";
include_once "conexao.php";

$idProfessor = (int)($_SESSION["id_professor"] ?? 0);
$tm = (int)($_POST["id_turma_materia"] ?? 0);
$bimestre = (string)($_POST["bimestre"] ?? '');

if (!in_array($bimestre, ["Primeiro", "Segundo", "Terceiro", "Quarto"], true)) {
    die("Bimestre inválido.<br><a href='professor/painel.php'>Voltar</a>");
}

$voltar = "professor/lancarnotas.php?tm=" . $tm . "&bimestre=" . urlencode($bimestre);

$disc = consulta($sql,
    "SELECT tm_id_turma FROM turma_materia WHERE id_turma_materia = ? AND tm_id_professor = ?",
    "ii", [$tm, $idProfessor])->get_result()->fetch_assoc();

if (!$disc) {
    die("Disciplina não encontrada.<br><a href='professor/painel.php'>Voltar</a>");
}

$permitidos = consulta($sql,
    "SELECT id_aluno FROM matricula WHERE id_turma = ? AND estado = 'Ativa'",
    "i", [(int)$disc["tm_id_turma"]])->get_result()->fetch_all(MYSQLI_ASSOC);

$listas = [];
foreach (["nota1", "nota2", "nota3"] as $campo) {
    $listas[$campo] = is_array($_POST[$campo] ?? null) ? $_POST[$campo] : [];
}

$dados = [];
foreach ($permitidos as $p) {
    $idAluno = (int)$p["id_aluno"];
    $notas = [];

    foreach (["nota1", "nota2", "nota3"] as $campo) {
        $v = str_replace(",", ".", trim((string)($listas[$campo][$idAluno] ?? '')));

        if ($v === "") {
            $notas[] = null;
        } elseif (!is_numeric($v) || $v < 0 || $v > 10) {
            die("As notas devem ser números entre 0 e 10.<br><a href='" . $voltar . "'>Voltar</a>");
        } else {
            $notas[] = number_format((float)$v, 2, ".", "");
        }
    }

    $media = in_array(null, $notas, true) ? null : number_format(array_sum($notas) / 3, 2, ".", "");

    $dados[$idAluno] = [$notas[0], $notas[1], $notas[2], $media];
}

$sql->begin_transaction();
try {
    foreach ($dados as $idAluno => $n) {
        if ($n[0] === null && $n[1] === null && $n[2] === null) {
            // Notas em branco: remove a linha, se existir
            consulta($sql, "DELETE FROM notas WHERE nota_id_aluno = ? AND nota_id_turma_materia = ? AND bimestre = ?",
                "iis", [$idAluno, $tm, $bimestre]);
        } else {
            consulta($sql,
                "INSERT INTO notas (bimestre, nota1, nota2, nota3, media, nota_id_aluno, nota_id_turma_materia)
                 VALUES (?, ?, ?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE nota1 = VALUES(nota1), nota2 = VALUES(nota2),
                                         nota3 = VALUES(nota3), media = VALUES(media)",
                "sssssii", [$bimestre, $n[0], $n[1], $n[2], $n[3], $idAluno, $tm]);
        }
    }
    $sql->commit();
} catch (Exception $e) {
    $sql->rollback();
    die("Erro ao salvar: " . $e->getMessage() . "<br><a href='" . $voltar . "'>Voltar</a>");
}

header("Location: " . $voltar . "&ok=1");
?>
