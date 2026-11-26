<?php
    // Escolhe sozinho: no seu computador (localhost) usa o banco local; na hospedagem usa o do InfinityFree.
    $local = in_array($_SERVER["SERVER_NAME"] ?? "", ["localhost", "127.0.0.1"]);

    if ($local) {
        $servidor = "localhost";
        $usuario  = "root";
        $senha    = "";
        $banco    = "finalescolar";
    } else {
        // >>> PREENCHA com os dados do painel do InfinityFree (menu "MySQL Databases") <<<
        $servidor = "sqlXXX.infinityfree.com";   // Hostname (NÃO é localhost)
        $usuario  = "if0_XXXXXXXX";               // MySQL Username
        $senha    = "SUA_SENHA_AQUI";             // senha da conta de hospedagem
        $banco    = "if0_XXXXXXXX_nome";          // nome completo do banco, com o prefixo
    }

    $sql = new mysqli($servidor, $usuario, $senha, $banco);

    if ($sql->connect_error){
        die ("Erro na conexão: " . $sql->connect_error);
     }

    $sql->set_charset("utf8mb4");

?>
