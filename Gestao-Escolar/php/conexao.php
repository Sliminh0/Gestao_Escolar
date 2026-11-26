<?php
    // Escolhe sozinho: no seu computador (localhost) usa o banco local; na hospedagem usa o do InfinityFree.
    $local = in_array($_SERVER["SERVER_NAME"] ?? "", ["localhost", "127.0.0.1"]);

    if ($local) {
        $servidor = "localhost";
        $usuario  = "root";
        $senha    = "";
        $banco    = "Gestao_Escolar";
    } else {

        $servidor = "sql109.infinityfree.com";   
        $usuario  = "if0_43544716";           
        $senha    = "p4hG9Qf7Atbqdr";           
        $banco    = "if0_43544716_GestaoEscolar";   
    }

    $sql = new mysqli($servidor, $usuario, $senha, $banco);

    if ($sql->connect_error){
        die ("Erro na conexão: " . $sql->connect_error);
     }

    $sql->set_charset("utf8mb4");

?>
