<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

// Verificar o tipo de usuário
if ($_SESSION['tipo'] != 'docente') {
    header("Location: ../index.php");
    exit();
}

?>