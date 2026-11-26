<?php
session_start();

if (empty($_SESSION["id_usuario"]) || ($_SESSION["tipo"] ?? '') !== $exigido) {
    $script = str_replace('\\', '/', $_SERVER["SCRIPT_NAME"]);
    $raiz = substr($script, 0, (int)strrpos($script, "/php/"));   // pasta do projeto
    $site = rtrim(dirname($raiz), "/\\");                        // pasta de cima (onde está o index.php)
    header("Location: " . $site . "/index.php?erro=2");
    exit;
}

const MEDIA_MINIMA = 5;

function h($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

function consulta($sql, $query, $tipos = "", $params = []) {
    $stmt = $sql->prepare($query);
    if ($tipos !== "") {
        $stmt->bind_param($tipos, ...$params);
    }
    $stmt->execute();
    return $stmt;
}

function data_br($data) {
    return $data ? date("d/m/Y", strtotime($data)) : "—";
}

function dinheiro($valor) {
    if ($valor === null || $valor === "") {
        return "—";
    }
    return "R$ " . number_format((float)$valor, 2, ",", ".");
}

function rotulo_estado($estado) {
    return $estado === "Concluida" ? "Concluída" : $estado;
}

function celula_nota($valor) {
    if ($valor === null || $valor === "") {
        return '<td class="num">—</td>';
    }
    $classe = ((float)$valor >= MEDIA_MINIMA) ? "ok" : "abaixo";
    return '<td class="' . $classe . '">' . number_format((float)$valor, 1, ",", ".") . '</td>';
}
